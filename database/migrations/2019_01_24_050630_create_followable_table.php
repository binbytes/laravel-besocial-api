<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followables', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('followable_id');
            $table->string('followable_type')->index();
            $table->string('relation')->default('follow')->comment('follow | like');
            $table->timestamps();

            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onUpdate('cascade')
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
        Schema::dropIfExists('followable');
    }
}
