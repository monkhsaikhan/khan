<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Test;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $test = Test::where('user_id', \Auth::user()->getKey())
            ->where('id', $id)
            ->with(['user', 'questions', 'questions.answers'])
            ->first();

        if(is_null($test))
        {
            return redirect('home');
        }

        return view('questions.index', compact('test'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $parameters = $request->all();

        if($request->has('id'))
        {
            $question = Question::findOrFail($request->get('id'));

            $question->update($request->all());

            foreach ($parameters['answers'] as $a)
            {
                if(array_key_exists('id', $a))
                {
                    $answer = Answer::findOrFail($a['id']);

                    $answer->update($a);
                }else
                {
                    Answer::create([
                        'question_id' => $question->getKey(),
                        'answer' => $a['answer'],
                        'is_correct' => $a['is_correct']
                    ]);
                }
            }

        } else {
            $question = Question::create([
                'test_id' => $id,
                'question' => $parameters['question']
            ]);

            foreach ($parameters['answers'] as $a)
            {
                Answer::create([
                    'question_id' => $question->getKey(),
                    'answer' => $a['answer'],
                    'is_correct' => $a['is_correct']
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::findOrFail($id)->delete();
    }
}
