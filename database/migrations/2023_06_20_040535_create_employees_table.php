<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('employee_id',5);
            $table->string('name',50);
            $table->string('nrc',50);
            $table->string('phone',50);
            $table->string('email',50);
            $table->integer('gender');
            $table->date('date_of_birth');
            $table->string('address',255);
            $table->string('language',10);
            $table->integer('career_part');
            $table->string('level', 5);
            $table->string('image',255)->nullable();
            $table->string('created_by',6)->nullable();
            $table->string('updated_by',6)->nullable();
            $table->softDeletes();
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
