<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Satuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satuans', function (Blueprint $table) {
            $table->bigIncrements('id_satuan');
            $table->string('nm_satuan');
            $table->string('jumlah');
            $table->string('eceran');
            $table->timestamps();
        });

        DB::table('satuans')->insert([
            'nm_satuan' => 'kg',
            'jumlah' => '1000',
            'eceran' => 'gram',
        ]);

        DB::table('satuans')->insert([
            'nm_satuan' => 'biji',
            'jumlah' => '1',
            'eceran' => 'biji',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
