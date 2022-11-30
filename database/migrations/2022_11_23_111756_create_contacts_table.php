<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->text('image');
            $table->text('address');
            $table->string('job_time');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('call_phone');
            $table->string('email');
            $table->text('map');
            $table->text('facebook');
            $table->text('youtube');
            $table->text('instagram');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
