@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="panel panel-default">

                <div class="panel-heading">

                    <div class="input-group input-group-sm">

                        <input type="text" class="form-control" />

                        <div class="input-group-btn">

                            <button class="btn btn-default">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>

                        </div>

                    </div>

                </div>

                <div class="panel-body">

                    <table class="table table-striped">

                        <tr>
                            <th>Тест</th>
                            <th>Асуултын тоо</th>
                            <th>Үүсэгсэн</th>
                            <th>Тест бөглөх</th>
                        </tr>

                        @foreach($tests as $test)

                            <tr>
                                <td>{{ $test->name }}</td>
                                <td>{{ $test->questions->count() }}</td>
                                <td>
                                    {{ $test->user->name }}
                                    <div class="help-block">{{ $test->created_at }}</div>
                                </td>
                                <td>
                                    <a href="{{ route('exam', $test->getKey()) }}" class="btn btn-warning btn-sm" onclick="event.preventDefault();
                                        document.getElementById('exam-form-{{ $test->getKey() }}').submit();">
                                        <span class="glyphicon glyphicon-flash"></span>
                                    </a>
                                    <form id="exam-form-{{ $test->getKey() }}" action="{{ url('/exam/'.$test->getKey()) }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </td>
                            </tr>

                        @endforeach

                    </table>

                </div>

            </div>

        </div>

    </div>


@endsection