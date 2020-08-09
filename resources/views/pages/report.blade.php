@extends('layouts.master')
@section('title', 'التقارير')
@section('header')

    <link rel="stylesheet" href="{{ asset('css/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/datatables/buttons.dataTables.min.css') }}">
@stop

@section('content')

    <div class="container" style="text-align: right">

        <div>
{{--            اجمالى المشتريات : {{ $sum_purchases }}--}}
        </div>
        <div>
{{--            اجمالى المبيعات : {{ $sum_sales }}--}}
        </div>
        <div>
{{--            اجمالى المصروفات : {{ $sum_expenses }}--}}
        </div>
        <hr>
        <div>
            <form action="{{ route('report') }}">
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
        <hr>
        <div>
            <h1 style="text-align: center">جدول / المشتريات</h1>
            <table id="table1" class="display" style="width: 100%">
                <thead>
                <tr>
                    <th>id</th>
                    <th>اسم المستخدم</th>
                    <th>المبالغ</th>
                    <th>الوصف</th>
                    <th>اضيف فى</th>
                </tr>
                </thead>

            </table>
        </div>
        <br>
        <hr>
        <br>
        <br>
        <div>
            <h1 style="text-align: center">جدول / المبيعات</h1>
            <table id="table2" class="display" style="width: 100%">
                <thead>
                <tr>
                    <th>id</th>
                    <th>اسم المستخدم</th>
                    <th>المبالغ</th>
                    <th>الوصف</th>
                    <th>اضيف فى</th>
                </tr>
                </thead>

            </table>
        </div>
        <br>
        <hr>
        <br>
        <br>
        <div>
            <h1 style="text-align: center">جدول / المصروفات</h1>
            <table id="table3" class="display" style="width: 100%">
                <thead>
                <tr>
                    <th>id</th>
                    <th>اسم المستخدم</th>
                    <th>المبالغ</th>
                    <th>الوصف</th>
                    <th>اضيف فى</th>

                </tr>
                </thead>

            </table>
        </div>
        <br>
        <hr>
        <br>
        <br>
    </div>





@stop

@section('footer')

    <script src="{{ asset('js/datatables/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

    <script>
        var table1 = $('#table1').DataTable({
            processing: true,
            serverSide: true,
            @if(Request::has('date_from') || Request::has('date_to'))
            ajax: '{!! url('report/purchases/data?' .  'date_from=' . Request::input('date_from')  . "&date_to=" . Request::input('date_to')) !!}',
            @else
                ajax: '{{ url('report/purchases/data') }}',
            @endif
            columns: [
                {data: 'id', name:'id'},
                {data: 'user_id', name:'user_id'},
                {data: 'total_purchases', name:'total_purchases'},
                {data: 'dis_purchases', name:'dis_purchases'},
                {data: 'created_at', name:'created_at'},
            ],

            "language": {
                "url": "{{ asset('datatable/Arabic.json') }}"
            },

            @if(!Request::has('date_from') || !Request::has('date_to'))
            "order": [[0, 'desc']],
            @endif
            aLengthMenu: [
                [5, 10, 25, 50, 100, 200, -1],
                [5, 10, 25, 50, 100, 200, "All"]
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'reload',
                    text: 'اعاده تحميل'
                },
            ]
        });
        var table2 = $('#table2').DataTable({
            processing: true,
            serverSide: true,
            @if(Request::has('date_from') || Request::has('date_to'))
                ajax: '{!!  url('report/sales/data?' .  'date_from=' . Request::input('date_from') . '&' . 'date_to=' . Request::input('date_to')) !!}',
            @else
                ajax: '{{ url('report/sales/data') }}',
            @endif
            columns: [
                {data: 'id', name:'id'},
                {data: 'user_id', name:'user_id'},
                {data: 'total_sales', name:'total_sales'},
                {data: 'dis_sales', name:'dis_sales'},
                {data: 'created_at', name:'created_at'},
            ],

            "language": {
                "url": "{{ asset('datatable/Arabic.json') }}"
            },
            @if(!Request::has('date_from') || !Request::has('date_to'))
            "order": [[0, 'desc']],
            @endif
            aLengthMenu: [
                [5, 10, 25, 50, 100, 200, -1],
                [5, 10, 25, 50, 100, 200, "All"]
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'reload',
                    text: 'اعاده تحميل'
                },
            ]
        });
        var table3 = $('#table3').DataTable({
            processing: true,
            serverSide: true,
            @if(Request::has('date_from') || Request::has('date_to'))
            ajax: '{!!  url('report/expenses/data?' .  'date_from=' . Request::input('date_from') . '&' . 'date_to=' . Request::input('date_to')) !!}',
            @else
            ajax: '{{ url('report/expenses/data') }}',
            @endif
            columns: [
                {data: 'id', name:'id'},
                {data: 'user_id', name:'user_id'},
                {data: 'total_expenses', name:'total_expenses'},
                {data: 'dis_expenses', name:'dis_expenses'},
                {data: 'created_at', name:'created_at'},
            ],

            "language": {
                "url": "{{ asset('datatable/Arabic.json') }}"
            },
            @if(!Request::has('date_from') || !Request::has('date_to'))
            "order": [[0, 'desc']],
            @endif
            aLengthMenu: [
                [5, 10, 25, 50, 100, 200, -1],
                [5, 10, 25, 50, 100, 200, "All"]
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'reload',
                    text: 'اعاده تحميل'
                },
            ]
        });
    </script>

@stop
