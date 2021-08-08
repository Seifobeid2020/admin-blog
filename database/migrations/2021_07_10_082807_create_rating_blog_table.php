<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating_blogs', function (Blueprint $table) {
            $table->id();

            $table->integer('stars');
            $table->longText('comment');

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('blog_id')->constrained('blogs');
            $table->unique(['user_id','blog_id']);

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
        Schema::dropIfExists('rating_blogs');
    }
}
