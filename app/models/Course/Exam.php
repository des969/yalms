<?php


namespace Yalms\Models\Courses;


/**
 * Yalms\Models\Courses\Exam
 *
 * @property integer $id
 * @property integer $course_lesson_id
 * @property integer $exam_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property-read \Lesson $lesson
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExamTypes[] $exam_types
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Exam whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Exam whereCourseLessonId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Exam whereExamTypeId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Exam whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Exam whereUpdatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\Exam whereName($value) 
 */
class Exam extends \Eloquent {

	protected $fillable = ['name'];
	protected $guarded = ['id'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'course_lesson_exams';

	public function lesson()
	{
		return $this->belongsTo('Lesson');
	}

	public function exam_types()
	{
		return $this->hasMany('ExamTypes');
	}
}