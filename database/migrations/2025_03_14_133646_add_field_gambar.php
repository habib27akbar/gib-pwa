<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldGambar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('komplain', function (Blueprint $table) {
            $table->string('gambar')->after('pesan')->nullable();
            $table->string('gambar_galeri')->after('gambar')->nullable();
            $table->integer('sts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('komplain', function (Blueprint $table) {
            //
        });
    }
}
