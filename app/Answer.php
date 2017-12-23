<?php
/**
 * Created by PhpStorm.
 * User: chmun
 * Date: 2017-12-21
 * Time: 23:45
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected $table = 'answer';

    protected $casts = ['is_correct' => 'boolean'];

    protected $fillable = ['question_id', 'answer', 'is_correct'];

}