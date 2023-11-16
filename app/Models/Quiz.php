<?php

namespace App\Models;


use App\Models\Interfaces\QuizInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Quiz extends Model implements QuizInterface
{
    use SoftDeletes;
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'quiz_questions';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];


    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswers::class, 'quiz_questions_id','id');
    }



}