<?php

namespace App\Http\Controllers;

use App\Question;
use App\Test;
use Illuminate\Http\Request;
use App\Answer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function exam($id)
    {
        $test = Test::with(['questions', 'questions.answersForGuest'])->findOrFail($id);

        if(\Session::has('start_time'))
        {
            $startTime = \Session::get('start_time');
        }
        else 
        {
            $startTime = \Carbon\Carbon::now()->addMinutes($test->minutes)->format('Y-m-d H:i:s');            
        }            

        session()->flash('start_time', $startTime);

        return view('exam', compact('test', 'startTime'));
    }

    public function sendResult($id, Request $request) 
    {
        $result = $request->get('_result');

        $question_ids =[];
        $answer_ids = '';
        foreach ($result as $key => $res) {
            foreach ($res as $key1 => $r) {
                array_push($question_ids, $r['id']);
                $answer_ids .= !is_null($r['checked']) ? $r['checked'] . ',' : '';
            }
        }
        $answer_ids = $answer_ids == '' ? 0 : substr($answer_ids, 0, strlen($answer_ids) - 1);        

        return Question::leftJoin(
            \DB::raw('(SELECT id as answer_id, question_id, is_correct FROM answer where id in ('.$answer_ids.')) `b`'), 
            'question.id', '=', 'b.question_id'
        )->whereIn('question.id', $question_ids)->select(['question.*', 'answer_id', 'b.is_correct'])->get();        
    }
}
