<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseLessonExamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_lesson_exams', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('course_lesson_id')->unsigned();

			$table->integer('exam_type_id')->unsigned();

			$table->timestamps();
		});

		Schema::table('course_lesson_exams', function(Blueprint $table)
		{
			$table->foreign('course_lesson_id')->references('id')->on('course_lessons');
		});

		Schema::table('course_lesson_exams', function(Blueprint $table)
		{
			$table->foreign('exam_type_id')->references('id')->on('exam_types');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_lesson_exams');
	}

}
