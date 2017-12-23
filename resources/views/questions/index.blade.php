@extends('layouts.app')

@section('content')

    <div class="container">

        <questions :id="{{ $test->getKey() }}"></questions>

    </div>


@endsection