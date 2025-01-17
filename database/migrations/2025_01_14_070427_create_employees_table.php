<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'employees'.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Kolom id otomatis sebagai primary key
            $table->string('name'); // Kolom untuk nama karyawan
            $table->decimal('salary', 15, 2); // Kolom untuk gaji karyawan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Rollback migrasi jika tabel 'employees' sudah ada.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
