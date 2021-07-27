<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_folders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('created_for')->comment('Questionnaire folder is created for this user');
            $table->unsignedBigInteger('created_by');
            $table->integer('is_delete')->default(0);
            $table->integer('final_delete')->default(0);
            $table->timestamps();
            $table->foreign('created_by')
                    ->references('id')->on('users');
            $table->foreign('created_for')
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
        Schema::dropIfExists('questionnaire_folders');
    }
}
