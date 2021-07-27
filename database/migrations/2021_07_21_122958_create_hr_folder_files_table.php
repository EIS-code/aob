<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrFolderFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_folder_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('folder_id')->unsigned();
            $table->foreign('folder_id')->references('id')->on('hr_folders')->onDelete('cascade');
            $table->string('full_name');
            $table->date('dob');
            $table->string('passport_number');
            $table->date('passport_expired_date');
            $table->string('nif')->nullable();
            $table->string('niss')->nullable();
            $table->enum('niss_type', [0,1,2,3,4])->comment('0: single, 1: Married, 2: Divorced, 3: Widowed, 4: Separated');
            $table->integer('total_dependents');
            $table->string('iban');
            $table->string('address');
            $table->string('contact_no');
            $table->string('email');
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_details');
            $table->string('last_employer')->nullable();
            $table->string('designation')->nullable();
            $table->string('total_work_time')->nullable();
            $table->string('reason_of_leaving')->nullable();
            $table->string('iban_proof');
            $table->string('card_proof');
            $table->string('residence_proof');
            $table->string('educational_proof');
            $table->string('local_proof');
            $table->string('date_time');
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
        Schema::dropIfExists('hr_folder_files');
    }
}
