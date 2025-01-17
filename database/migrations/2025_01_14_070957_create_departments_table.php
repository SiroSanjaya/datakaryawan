<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'departments'.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id(); // Kolom id otomatis sebagai primary key
            $table->string('name'); // Kolom untuk nama departemen
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Rollback migrasi jika tabel 'departments' sudah ada.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
