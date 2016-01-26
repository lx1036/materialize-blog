<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('intro');
            $table->integer('category_id')->unsigned();
            $table->Text('body');
            $table->string('origin');
            $table->integer('comment_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('favorite_count')->default(0);
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('posts_category_id_foreign');
        });

        Schema::drop('posts');
    }
}