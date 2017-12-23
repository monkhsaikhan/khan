<?php

namespace App\Http\Controllers;

use App\Exam;
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

        return \DB::transaction(function() use ($result, $id){
            $exam = Exam::create(['user_id' => \Auth::user()->getKey(), 'test_id' => $id]);

            $question_ids =[];
            $answer_ids = '';
            foreach ($result as $key => $res) {
                foreach ($res as $key1 => $r) {
                    array_push($question_ids, $r['id']);
                    $answer_ids .= !is_null($r['checked']) ? $r['checked'] . ',' : '';
                    $exam->questions()->attach($r['id'], ['answer_id' => is_null($r['checked']) ? null : $r['checked']]);
                }
            }
            $answer_ids = $answer_ids == '' ? 0 : substr($answer_ids, 0, strlen($answer_ids) - 1);

            return response()->json([
                'result' => Question::leftJoin(
                    \DB::raw('(SELECT id as answer_id, question_id, is_correct FROM answer where id in ('.$answer_ids.')) `b`'),
                    'question.id', '=', 'b.question_id'
                )->whereIn('question.id', $question_ids)->select(['question.*', 'answer_id', 'b.is_correct'])->get(),
                'exam' => $exam
            ]);
        });
    }

    public function histories()
    {
        $exams = Exam::where('user_id', \Auth::user()->id)->get();

        return view('histories', compact('exams'));
    }

    public function history($id)
    {
        $exam = Exam::where('user_id', \Auth::user()->id)->where('id', $id)->first();

        if(is_null($exam))
        {
            return redirect()->route('home');
        }

        return view('history', compact('exam'));
    }
}
