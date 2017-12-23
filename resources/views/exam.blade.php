@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <exam :start="'{{ $startTime }}'" :test="{{ $test }}"></exam>
        </div>
    </div>

@endsection