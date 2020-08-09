@extends('layouts.master')


@section('content')

    <div class="container" style="text-align: right">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <div>
            <h1 style="text-align: center">تعديل بيانات المستخدم : {{ Auth::user()->name }}</h1>
            <div>
                {!! Form::model($user, ['method'=>'POST', 'action'=>'ClothesController@userUpdateData']) !!}
                <div class="form-group">
                    {!! Form::label('الاسم :') !!}
                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="form-group">
                    {!! Form::label('اسم المستخدم : ') !!}
                    {!! Form::text('username', null,  ['class'=>'form-control']) !!}
                </div>
                @error('username')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    {!! Form::submit('تحديث البيانات', ['class'=>'btn btn-info']) !!}
                </div>
                {!! Form::close() !!}
            </div>
            <div>
                <h1 style="text-align: center">تغير كلمه المرور</h1>
                {!! Form::open(['method'=>'POST', 'action'=>'ClothesController@changeUserPassword']) !!}
                {!! Form::open(['method'=>'POST', 'action'=>['AdminController@changeAdminPassword', $user->id]]) !!}
                <div class="form-group">
                    <input type="password" class="form-control" id="current-password" name="current-password" placeholder="current-password">
                </div>
                @if(Session::has('message'))
                    <div class="alert alert-danger">
                        {{ Session::get('message') }}
                    </div>
                @endif
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="new Password">
                </div>
                @error('password')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
                <div class="form-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter Password">
                </div>
                <div class="form-group">
                    {!! Form::submit('تغير كلمه المرور', ['class'=>'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>

        </div>

    </div>
@stop
