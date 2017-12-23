@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="panel panel-default">

                <div class="panel-body">

                    <table class="table table-striped">

                        <tr>
                            <th>Тест</th>
                            <th>Хариу</th>
                        </tr>

                        @foreach($exams as $exam)

                            <tr>
                                <td>{{ $exam->test->name }}</td>
                                <td>
                                    <a href="{{ route('exam.history', $exam->getKey()) }}" class="btn btn-success btn-sm">
                                        <span class="glyphicon glyphicon-list"></span>
                                    </a>
                                </td>
                            </tr>

                        @endforeach

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection