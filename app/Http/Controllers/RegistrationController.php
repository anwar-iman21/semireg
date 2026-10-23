<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function home(): View
    {
        $total = Registration::count();
        $quota = config('seminar.quota');

        return view('registrations.home', [
            'total' => $total,
            'remaining' => max(0, $quota - $total),
            'quota' => $quota,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $quota = config('seminar.quota');
        if (Registration::count() >= $quota) {
            return back()->with('error', 'Kuota peserta sudah penuh.');
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'unique:registrations,email'],
            'no_hp' => ['required', 'regex:/^(08|\+628)[0-9]{8,13}$/'],
            'kategori' => ['required', 'in:mahasiswa,umum'],
            'nim' => ['required_if:kategori,mahasiswa', 'nullable', 'string', 'max:40'],
            'institusi' => ['required', 'string', 'max:160'],
        ], [
            'required' => 'Kolom :attribute wajib diisi.',
            'email.email' => 'Format email belum benar.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'no_hp.regex' => 'Gunakan nomor Indonesia, contoh 081234567890.',
            'kategori.in' => 'Pilih kategori yang tersedia.',
            'nim.required_if' => 'NIM wajib diisi untuk mahasiswa.',
        ], ['nama' => 'nama lengkap', 'email' => 'email', 'no_hp' => 'nomor HP', 'institusi' => 'asal institusi']);

        do {
            $data['kode_tiket'] = 'SMR-' . strtoupper(Str::random(6));
        } while (Registration::where('kode_tiket', $data['kode_tiket'])->exists());

        $registration = Registration::create($data);

        return redirect()->to(route('registration.success', [$registration->kode_tiket], false));
    }

    public function success(string $kode): View
    {
        return view('registrations.success', ['registration' => Registration::where('kode_tiket', $kode)->firstOrFail()]);
    }

    public function ticketLookup(Request $request): View
    {
        $registration = null;
        $searched = $request->filled('email') || $request->filled('kode_tiket');

        if ($searched) {
            $data = $request->validate([
                'email' => ['required', 'email'],
                'kode_tiket' => ['required', 'regex:/^SMR-[A-Z0-9]{6}$/'],
            ], [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email belum benar.',
                'kode_tiket.required' => 'Kode tiket wajib diisi.',
                'kode_tiket.regex' => 'Format kode tiket harus seperti SMR-ABC123.',
            ]);

            $registration = Registration::whereRaw('LOWER(email) = ?', [strtolower($data['email'])])
                ->where('kode_tiket', strtoupper($data['kode_tiket']))
                ->first();
        }

        return view('registrations.lookup', compact('registration', 'searched'));
    }
}
