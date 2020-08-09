@extends('layouts.master')

@section('title', 'المبيعات')

@section('content')
    <div class="container" style="text-align: right">
        <div>
            <form action="{{ route('sales.search') }}">
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
        @if(isset($sales))
            @forelse($sales as $sale)
                <div>
                    <p>اسم المستخدم : {{ $sale->user->name }}</p>
                    <p>تاريخ المبيعات : {{ $sale->created_at->format('Y-m-d') }}</p>
                    <p>تفاصيل المبيعات : {{ $sale->dis_sales }}</p>
                    <p>اجمالى  المبيعات : {{ $sale->total_sales }}</p>
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
