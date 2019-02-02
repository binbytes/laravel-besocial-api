<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->integer('conversation_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('type')->default('text');
            $table->boolean('is_seen')->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('conversation_id')
                ->references('id')
                ->on('conversations')
                ->onDelete('cascade');
        });

        Schema::create('conversation_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('conversation_id')->unsigned();
            $table->primary([
                'user_id', 'conversation_id'
            ]);
            $table->timestamps();

            $table->foreign('conversation_id')
                ->references('id')->on('conversations')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists([
            'conversations', 'messages', 'conversation_user'
        ]);
    }
}
