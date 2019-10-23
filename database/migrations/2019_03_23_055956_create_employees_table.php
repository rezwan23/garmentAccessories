<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('depart_id');
            $table->integer('desig_id');
            $table->date('joining')->nullable();
            $table->string('fName');
            $table->string('faName')->nullable();
            $table->string('moName')->nullable();
            $table->tinyInteger('gender');
            $table->tinyInteger('blood');
            $table->tinyInteger('religion');
            $table->string('nid')->nullable();
            $table->date('dob')->nullable();
            $table->tinyInteger('marriage');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('phone_emer')->nullable();
            $table->string('image')->nullable();
            $table->text('present_add')->nullable();
            $table->text('permanent_add')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('employees');
    }
}
