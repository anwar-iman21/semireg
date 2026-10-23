<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class AdminController extends Controller
{
    /* ────── login ────── */

    public function loginForm(): View
    {
        return view('admin.login');
    }

    public function loginProcess(Request $request): RedirectResponse
    {
        $request->validate(['password' => 'required']);

        $valid = hash_equals(config('seminar.admin_password'), $request->input('password'));

        if (! $valid) {
            return back()->with('error', 'Password salah.');
        }

        $request->session()->put('admin_authenticated', true);
        return redirect()->to(route('admin.dashboard', [], false));
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin_authenticated');
        return redirect()->to(route('admin.login', [], false));
    }

    /* ────── dashboard ────── */

    public function dashboard(Request $request): View
    {
        $query = Registration::query();

        $search = $request->query('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('kode_tiket', 'like', "%{$search}%")
                    ->orWhere('institusi', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->simplePaginate(15)->withQueryString();
        $totalAll = Registration::count();
        $totalMhs = Registration::where('kategori', 'mahasiswa')->count();
        $totalUmum = Registration::where('kategori', 'umum')->count();
        $remaining = max(0, config('seminar.quota') - $totalAll);

        return view('admin.dashboard', compact('registrations', 'totalAll', 'totalMhs', 'totalUmum', 'remaining', 'search'));
    }

    /* ────── delete ────── */

    public function destroy(Registration $registration): RedirectResponse
    {
        $registration->delete();
        return redirect()->to(route('admin.dashboard', [], false))->with('success', 'Peserta berhasil dihapus.');
    }

    /* ────── CSV export ────── */

    public function exportCsv()
    {
        $registrations = Registration::latest()->get();

        $csv = "\xEF\xBB\xBF"; // UTF-8 BOM
        $csv .= "No,Kode Tiket,Nama,Email,Nomor HP,Kategori,NIM,Institusi,Tanggal Daftar\n";

        foreach ($registrations as $i => $reg) {
            $csv .= implode(',', [
                $i + 1,
                $reg->kode_tiket,
                '"' . str_replace('"', '""', $reg->nama) . '"',
                $reg->email,
                $reg->no_hp,
                $reg->kategori,
                $reg->nim ?: '-',
                '"' . str_replace('"', '""', $reg->institusi) . '"',
                $reg->created_at->format('Y-m-d H:i'),
            ]) . "\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="peserta_sinatek_' . date('Ymd') . '.csv"',
        ]);
    }

    /* ────── tunnel info ────── */

    public function info(Request $request): View
    {
        return view('admin.info', ['request' => $request]);
    }
}
