<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMorphModeratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('morph_moderates', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->smallInteger('result')->default(0);
            $table->integer('moderateable_id');
            $table->string('moderateable_type');
            $table->index(['moderateable_id', 'moderateable_type']);
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
        Schema::dropIfExists('morph_moderates');
    }
}
