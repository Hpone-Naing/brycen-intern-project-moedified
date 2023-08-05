<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesProgrammingLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_programming_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("employee_id")->constrained("employees")->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("programming_language_id")->constrained("programming_languages")->onDelete("cascade")->onUpdate("cascade");
            $table->softDeletes();
            $table->string("created_by", 6)->nullable();
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
        Schema::dropIfExists('employees_programming_languages');
    }
}
