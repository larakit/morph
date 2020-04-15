<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMorphCommentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('morph_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('comment');
            $table->integer('author_id')
                  ->default(0)
                  ->index();
            $table->string('ip')
                  ->nullable()
                  ->index();
            $table->integer('parent_id')
                  ->default(0)
                  ->index();
            $table->morphs('commentable');
            $table->string('path', 128)
                  ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('morph_comments');
    }
}
