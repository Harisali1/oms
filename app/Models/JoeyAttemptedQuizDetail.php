<?php

namespace App\Models;


use App\Models\Interfaces\JoeyAttemptedQuizDetailInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class JoeyAttemptedQuizDetail extends Model implements JoeyAttemptedQuizDetailInterface
{
    use SoftDeletes;
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'joey_attempted_quiz_details';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];

    public function question()
    {
        return $this->belongsTo(Quiz::class,'question_id','id');
    }

    public function answer()
    {
        return $this->belongsTo(QuizAnswers::class,'answer_id','id');
    }

}