<?php

namespace App\Models;


use App\Models\Interfaces\JoeyAttemptedQuizInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class JoeyAttemptedQuiz extends Model implements JoeyAttemptedQuizInterface
{
    use SoftDeletes;
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'joey_attempted_quiz';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];

    public function category()
    {
        return $this->belongsTo(OrderCategory::class,'category_id','id');
    }


    public function attemptDetail()
    {
        return $this->hasMany(JoeyAttemptedQuizDetail::class, 'quiz_id','id');
    }


}