<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteCascadeToRatingBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rating_blogs', function (Blueprint $table) {
            //
            $table->dropForeign('rating_blogs_blog_id_foreign');

            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rating_blogs', function (Blueprint $table) {
            //
            $table->dropForeign('rating_blogs_blog_id_foreign');
            $table->foreign('blog_id')->references('id')->on('blogs')->change();

            // $table->foreignId('blog_id')->change()->constrained('blogs');
            // $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade')->change();



        });
    }
}
