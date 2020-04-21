<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMorphViewedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('morph_vieweds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('viewedable');
            $table->integer('cnt')->default(0);
            $table->string('ip')
                  ->nullable()
            ;
            $table->bigInteger('usr_id')
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
        Schema::dropIfExists('morph_vieweds');
    }
}
