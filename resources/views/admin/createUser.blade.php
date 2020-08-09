@extends('admin.layouts.master')
@section('content')

    <div class="container" style="text-align: right">
        {!! Form::open(['method'=>'POST', 'action'=>'AdminController@store']) !!}
        <div class="form-group">
            {!! Form::label('الاسم :') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            {!! Form::label('اسم المستخدم : ') !!}
            {!! Form::text('userName', null, ['class'=>'form-control']) !!}
        </div>
        @error('userName')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            {!! Form::label('الصلحيات : ') !!}
            {!! Form::select('role', ['0'=>'عضو', '1'=>'مشرف'], 0, ['class'=>'form-control']) !!}
        </div>
        @error('role')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            {!! Form::label('كلمه المرور : ') !!}
            {!! Form::password('password', ['class'=>'form-control']) !!}
        </div>
        @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            {!! Form::label('اعاده كتابه كلمه المرور : ') !!}
            {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('انشاء عضو', ['class'=>'btn btn-info']) !!}
        </div>
    </div>

@stop
