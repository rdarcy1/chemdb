<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('n_atoms');
            $table->unsignedTinyInteger('n_bonds');
            $table->unsignedTinyInteger('n_rings');
            $table->unsignedTinyInteger('n_C');
            $table->unsignedTinyInteger('n_C1');
            $table->unsignedTinyInteger('n_C2');
            $table->unsignedTinyInteger('n_CHB1p');
            $table->unsignedTinyInteger('n_CHB2p');
            $table->unsignedTinyInteger('n_CHB3p');
            $table->unsignedTinyInteger('n_CHB4');
            $table->unsignedTinyInteger('n_O2');
            $table->unsignedTinyInteger('n_O3');
            $table->unsignedTinyInteger('n_N1');
            $table->unsignedTinyInteger('n_N2');
            $table->unsignedTinyInteger('n_N3');
            $table->unsignedTinyInteger('n_S');
            $table->unsignedTinyInteger('n_SeTe');
            $table->unsignedTinyInteger('n_F');
            $table->unsignedTinyInteger('n_Br');
            $table->unsignedTinyInteger('n_Cl');
            $table->unsignedTinyInteger('n_I');
            $table->unsignedTinyInteger('n_P');
            $table->unsignedTinyInteger('n_B');
            $table->unsignedTinyInteger('n_Met');
            $table->unsignedTinyInteger('n_X');
            $table->unsignedTinyInteger('n_b1');
            $table->unsignedTinyInteger('n_b2');
            $table->unsignedTinyInteger('n_b3');
            $table->unsignedTinyInteger('n_bar');
            $table->unsignedTinyInteger('n_C1O');
            $table->unsignedTinyInteger('n_C2O');
            $table->unsignedTinyInteger('n_CN');
            $table->unsignedTinyInteger('n_XY');
            $table->unsignedTinyInteger('n_r3');
            $table->unsignedTinyInteger('n_r4');
            $table->unsignedTinyInteger('n_r5');
            $table->unsignedTinyInteger('n_r6');
            $table->unsignedTinyInteger('n_r7');
            $table->unsignedTinyInteger('n_r8');
            $table->unsignedTinyInteger('n_r9');
            $table->unsignedTinyInteger('n_r10');
            $table->unsignedTinyInteger('n_r11');
            $table->unsignedTinyInteger('n_r12');
            $table->unsignedTinyInteger('n_r13p');
            $table->unsignedTinyInteger('n_rN');
            $table->unsignedTinyInteger('n_rN1');
            $table->unsignedTinyInteger('n_rN2');
            $table->unsignedTinyInteger('n_rN3p');
            $table->unsignedTinyInteger('n_rO');
            $table->unsignedTinyInteger('n_rO1');
            $table->unsignedTinyInteger('n_rO2p');
            $table->unsignedTinyInteger('n_rS');
            $table->unsignedTinyInteger('n_rX');
            $table->unsignedTinyInteger('n_rAr');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('structures');
    }
}
