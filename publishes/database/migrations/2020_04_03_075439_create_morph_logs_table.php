<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMorphLogsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('morph_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('logable_id');
            $table->string('logable_type');
            $table->text('comment')
                  ->nullable()
            ;
            $table->integer('user_id')
                  ->nullable()
            ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('morph_logs');
    }
}
