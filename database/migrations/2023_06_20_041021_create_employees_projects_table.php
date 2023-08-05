<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId("employee_id")->constrained("employees")->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("project_id")->constrained("projects")->onDelete("cascade")->onUpdate("cascade");
            $table->date("start_date");
            $table->date("end_date");
            $table->softDeletes();
            $table->timestamps();
            $table->string("created_by", 6)->nullable();
            $table->string("updated_by", 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_projects');
    }
}
