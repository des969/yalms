<?php

namespace Yalms\Models\Courses;

/**
 * Yalms\Models\Courses\ExamType
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Exam[] $exams
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\ExamType whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\ExamType whereName($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\ExamType whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\ExamType whereUpdatedAt($value) 
 */
/**
 * Yalms\Models\Courses\ExamType
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\ExamType whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\ExamType whereName($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\ExamType whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Yalms\Models\Courses\ExamType whereUpdatedAt($value) 
 */
class ExamType extends \Eloquent {
	protected $fillable = [];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'exam_types';

	public function exams()
	{
		return $this->hasMany('Exam');
	}
}
