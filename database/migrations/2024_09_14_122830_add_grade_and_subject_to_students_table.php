<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGradeAndSubjectToStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('grade_id')->nullable()->constrained()->onDelete('set null');
            $table->dropForeign(['subject_id']);
            $table->dropColumn('subject_id');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('set null');
            $table->dropForeign(['grade_id']);
            $table->dropColumn('grade_id');
        });
    }
}
