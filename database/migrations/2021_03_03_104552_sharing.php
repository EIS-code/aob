<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Sharing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sharing', function (Blueprint $table) {
            $table->id();
            $table->integer('team_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('type',255);
            $table->integer('shared_id')->nullable();
            $table->date('activation_date');
            $table->date('expiration_date');
            $table->integer('is_delete')->default(0);
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
        Schema::drop('sharing');
    }
}
