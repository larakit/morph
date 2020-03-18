<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMorphAbusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('morph_abuses', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('ip')
                  ->nullable()
            ;
            $table->integer('usr_id')
                  ->default(0)
            ;
            $table->integer('abuseable_id');
            $table->string('abuseable_type');
            $table->index(['abuseable_id', 'abuseable_type']);
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
        Schema::dropIfExists('morph_abuses');
    }
}
