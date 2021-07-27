<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username',255)->nullable();
            $table->string('name',255);
            $table->string('image',100)->default('user.png');
            $table->string('email',255);
            $table->string('phone',255);
            $table->string('dob',255)->nullable();
            $table->string('initials',255)->nullable();
            $table->string('position',255)->nullable();
            $table->integer('reminder_email',1)->default(0);
            $table->text('password');
            $table->text('login_token')->nullable();
            $table->string('login_number',10)->nullable();
            $table->integer('role_id')->default(2);
            $table->integer('is_active')->default(1);
            $table->integer('is_delete')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'username' => 'admin',
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'password' => '4297f44b13955235245b2497399d7a93',
                'role_id' => 1
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
