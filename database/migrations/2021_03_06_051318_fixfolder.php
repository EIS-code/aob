<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Fixfolder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixfolders', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->integer('is_delete')->default(0);
            $table->integer('final_delete')->default(0);
            $table->timestamps();
        });

        DB::table('fixfolders')->insert(
            array(
                'name' => 'Marketing Materials'
            )
        );

        DB::table('adminusers')->insert(
            array(
                'name' => 'Guides'
            )
        );

        DB::table('adminusers')->insert(
            array(
                'name' => 'How to use?'
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
        Schema::drop('fixfolders');
    }
}
