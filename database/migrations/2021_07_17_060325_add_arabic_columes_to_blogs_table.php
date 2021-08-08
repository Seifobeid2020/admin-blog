<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArabicColumesToBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            //

            $table->string('title_ar')->nullable();
            $table->longText('content_ar')->nullable();
            $table->string('topic_ar')->nullable();
            $table->string('writer_ar')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {


                $table->dropColumn('title_ar');
                $table->dropColumn('content_ar');
                $table->dropColumn('topic_ar');
                $table->dropColumn('writer_ar');


        });
    }
}
