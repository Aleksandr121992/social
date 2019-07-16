<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentLikeDislikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_like_dislikes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->unsignedBigInteger('comment_id');
            $table->boolean('like')->default(0);
            $table->boolean('dislike')->default(0);
            $table->timestamps();

             $table->foreign('comment_id')->references('id')->on('comments')->
                onUpdate('restrict')->onDelete('cascade'); 
        });

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_like_dislikes');

    }
}
