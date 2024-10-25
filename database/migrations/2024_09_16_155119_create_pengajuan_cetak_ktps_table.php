<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('pengajuan_cetak_ktps')) {
            Schema::create('pengajuan_cetak_ktps', function (Blueprint $table) {
                $table->id();
                $table->string('fullName');
                $table->string('birthPlace');
                $table->date('birthDate');
                $table->string('gender');
                $table->string('address');
                $table->string('rtRw');
                $table->string('village');
                $table->string('subdistrict');
                $table->string('religion');
                $table->string('maritalStatus');
                $table->string('occupation');
                $table->string('citizenship');
                $table->string('bloodType');
                $table->string('submittedBy');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_cetak_ktps');
    }
};
