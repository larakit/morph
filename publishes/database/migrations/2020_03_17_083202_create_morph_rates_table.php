<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMorphRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('morph_rate_items', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->morphs('rateable');
            $table->string('ip')
                  ->nullable()
            ;
            $table->bigInteger('usr_id')
                  ->default(0)
            ;
            $table->float('rate')
                  ->default(0)
            ;
            $table->timestamps();
        });

        Schema::create('morph_rates', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->morphs('rateable');
            $table->float('rate_avg')
                  ->default(0)
            ;
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
        Schema::dropIfExists('morph_rates');
        Schema::dropIfExists('morph_rate_items');
    }
}
