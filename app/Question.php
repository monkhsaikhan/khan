<?php
/**
 * Created by PhpStorm.
 * User: chmun
 * Date: 2017-12-21
 * Time: 16:59
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    protected $table = 'question';

    protected $fillable = ['test_id', 'question'];

    protected $appends = ['show', 'checked'];

    public function getCheckedAttribute()
    {
        return null;
    }

    public function getShowAttribute()
    {
        return false;
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function answersForGuest()
    {
        return $this->hasMany(Answer::class, 'question_id')->select('answer', 'id', 'question_id');
    }

}