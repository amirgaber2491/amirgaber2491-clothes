@extends('layouts.master')

@section('content')
    <div class="container" style="text-align: right">
        <form action="{{ route('test') }}" method="POST">
            {{ csrf_field() }}
            <input type="date" name="dattte" required>
            <input type="submit">
        </form>
    </div>


@stop
