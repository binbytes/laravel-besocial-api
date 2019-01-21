<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Migrations\Migration;

class GeneratePassportRequiredClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call('passport:install');

        Artisan::call('passport:client', [
            '--personal' => true,
            '-n' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
