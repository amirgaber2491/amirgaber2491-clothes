@extends('admin.layouts.master')
@section('content')

    <div class="container" style="text-align: right">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        {!! Form::model($user, ['method'=>'POST', 'action'=>['AdminController@update', $user->id]]) !!}
        <div class="form-group">
            {!! Form::label('الاسم :') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            {!! Form::label('اسم المستخدم : ') !!}
            {!! Form::text('username', null, ['class'=>'form-control']) !!}
        </div>
        @error('userName')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            {!! Form::label('الصلحيات : ') !!}
            {!! Form::select('role', ['0'=>'عضو', '1'=>'مشرف'], null, ['class'=>'form-control']) !!}
        </div>
        @error('role')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            {!! Form::submit('تعديل المستخدم', ['class'=>'btn btn-info']) !!}
        </div>
        {!! Form::close() !!}

        <div>
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
        </div>
    </div>

@stop
