<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMorphTagsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('morph_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tag_id');
            $table->integer('tagable_id')
                  ->index();
            $table->string('tagable_type');
            $table->index(['tagable_id', 'tagable_type']);
            $table->timestamps();
        });
        foreach (
            DB::table('taggables')
              ->get() as $item
        ) {
            \Larakit\MorphTag::firstOrCreate([
                'tag_id'       => $item->tag_id,
                'tagable_id'   => $item->taggable_id,
                'tagable_type' => $item->taggable_type,
            ]);
        }
        Schema::table('taggables', function (Blueprint $table) {
            $table->rename('__taggables');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('morph_tags');
        Schema::table('__taggables', function (Blueprint $table) {
            $table->rename('taggables');
        });
    }
}
