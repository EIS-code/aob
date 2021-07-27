<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('questionnaire_folder_id');
            $table->unsignedBigInteger('uploaded_by');
            $table->string('name');
            $table->string('ext');
            $table->string('size')->nullable();
            $table->string('filetype')->default('normal');
            $table->integer('is_delete')->default(0);
            $table->integer('final_delete')->default(0);
            $table->timestamps();
            $table->foreign('questionnaire_folder_id')
                    ->references('id')->on('questionnaire_folders')
                    ->onDelete('cascade');
            $table->foreign('uploaded_by')
                    ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaire_files');
    }
}
