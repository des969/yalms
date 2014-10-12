<?php

namespace Yalms\Models\Courses;

/**
 * Yalms\Models\Courses\Lesson
 *
 * @property integer $id
 * @property integer $course_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Course $courses
 * @property-read \Illuminate\Database\Eloquent\Collection|\Exam[] $exams
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Lesson whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Lesson whereCourseId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Lesson whereName($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Lesson whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Lesson whereUpdatedAt($value) 
 */
/**
 * Yalms\Models\Courses\Lesson
 *
 * @property integer $id
 * @property integer $course_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Lesson whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Lesson whereCourseId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Lesson whereName($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Lesson whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Lesson whereUpdatedAt($value) 
 */
class Lesson extends \Eloquent {

	protected $fillable = [];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'course_lessons';

	public function courses()
	{
		return $this->belongsTo('Course');
	}

	public function exams()
	{
		return $this->hasMany('Exam');
	}
}