<?php
/**
 * Created by PhpStorm.
 * User: chmun
 * Date: 2017-12-23
 * Time: 21:33
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exam extends Model
{

    /**
     * @var string
     */
    protected $table = 'exam';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'test_id'];

    /**
     * @return BelongsTo
     */
    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    /**
     * @return BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_question','exam_id', 'question_id')->withPivot('answer_id');
    }

}