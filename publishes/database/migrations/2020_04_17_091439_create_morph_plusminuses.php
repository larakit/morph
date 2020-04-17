<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMorphPlusminuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('morph_plusminus_items', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->morphs('plusminusable');
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

        Schema::create('morph_plusminuses', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->morphs('plusminusable');
            $table->float('rate_sum')
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
        Schema::dropIfExists('morph_plusminus_items');
        Schema::dropIfExists('morph_plusminuses');
    }
}
