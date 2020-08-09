@extends('layouts.master')

@section('title', 'المصروفات')

@section('content')
    <div class="container" style="text-align: right">
        <div>
            <form action="{{ route('expenses.search') }}">
                <div class="form-group">
                    <input type="date" name="date_from">
                    @error('date_from')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="date" name="date_to">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="بحث">
                </div>

            </form>
        </div>

        @if(isset($expenses))
            @forelse($expenses as $expense)
                <div>
                    <p>اسم المستخدم : {{ $expense->user->name }}</p>
                    <p>تاريخ المصروفات : {{ $expense->created_at->format('Y-m-d') }}</p>
                    <p>تفاصيل المصروفات : {{ $expense->dis_expenses }}</p>
                    <p>اجمالى المصروفات : {{ $expense->total_expenses }}</p>
                    <p>
                        @if($expense->images)
                            @foreach($expense->images as $image)
                                <img src="{{ asset('images/' . $image->name) }}" alt="" width="50px" height="50px">
                            @endforeach
                        @endif
                    </p>
                </div>
                <hr>
            @empty
                <div class="alert alert-danger">
                    لا يوجد بيانات حاليا
                </div>
            @endforelse
        @else
            <div class="alert alert-danger">
لا يوجد بيانات حاليا
            </div>
        @endif
    </div>
@stop
