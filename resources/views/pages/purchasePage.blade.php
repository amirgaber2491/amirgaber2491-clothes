@extends('layouts.master')

@section('title', 'المشتريات')

@section('content')
    <div class="container" style="text-align: right">
        <div>
            <form action="{{ route('purchases.search') }}">
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
        @if(isset($purchases))
            @forelse($purchases as $purchase)
                <div>
                    <p>اسم المستخدم : {{ $purchase->user->name }}</p>
                    <p>تاريخ الشراء : {{ $purchase->created_at->format('Y-m-d') }}</p>
                    <p>تفاصيل الشراء : {{ $purchase->dis_purchases }}</p>
                    <p>سعر الشراء : {{ $purchase->total_purchases }}</p>
                    <p>
                        @if($purchase->images)
                            @foreach($purchase->images as $image)
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
