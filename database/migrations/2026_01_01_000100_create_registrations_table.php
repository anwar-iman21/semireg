<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('no_hp', 20);
            $table->string('kategori', 20);
            $table->string('nim')->nullable();
            $table->string('institusi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
