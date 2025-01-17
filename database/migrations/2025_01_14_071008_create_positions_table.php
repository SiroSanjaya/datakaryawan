<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'positions'.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id(); // Kolom id otomatis sebagai primary key
            $table->string('name'); // Kolom untuk nama posisi
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Rollback migrasi jika tabel 'positions' sudah ada.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
