<?php

use App\Models\student;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $students = student::all();
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('class');
            $table->string('category')->default('Student');
        });
        Schema::table('students', function (Blueprint $table) use ($students) {
            $table->string('class')->nullable();
            foreach ($students as $student) {
                $student->class = $student->class;
                $student->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         $students = student::all();

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('class');
        });

        Schema::table('students', function (Blueprint $table) use ($students) {
            $table->string('class')->nullable();
            $table->dropColumn('category');
            foreach ($students as $student) {
                $student->class = $student->class;
                $student->save();
            }
        });
    }
}
