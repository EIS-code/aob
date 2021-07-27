<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Allnotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('title',255)->nullable();
            $table->text('details')->nullable();
            $table->integer('is_delete')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('notifications');
    }
}
