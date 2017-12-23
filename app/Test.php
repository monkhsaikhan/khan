<?php
/**
 * Created by PhpStorm.
 * User: chmun
 * Date: 2017-12-21
 * Time: 15:46
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

    protected $table = 'test';

    protected $fillable = ['name', 'user_id', 'minutes'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'test_id');
    }

}