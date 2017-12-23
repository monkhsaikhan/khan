@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            @foreach($exam->questions as $question)
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-2">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        {{ $question->question }}
                    </div>

                    <div class="panel-body">

                        <ul class="list-group">
                            @foreach($question->answers as $answer)
                            <li class="list-group-item {{
                                $answer->is_correct ? 'list-group-item-success' : ($answer->getKey() == $question->pivot->answer_id ? 'list-group-item-danger' : '')
                            }} ">
                                {{ $answer->answer }}
                            </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
            @endforeach

        </div>

    </div>

@endsection