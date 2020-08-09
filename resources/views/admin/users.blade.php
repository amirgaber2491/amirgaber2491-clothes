@extends('admin.layouts.master')
@section('title', 'جميع الاعضاء')
@section('header')
    <link rel="stylesheet" href="{{ asset('css/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/datatables/buttons.dataTables.min.css') }}">

@stop
@section('content')

    <div class="container" style="text-align: right">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <div>
            <h1 style="text-align: center">جدول / الاعضاء</h1>
            <table id="table" class="display" style="width: 100%">
                <thead>
                <tr>
                    <th>id</th>
                    <th>اسم المستخدم</th>
                    <th>الصلحيه</th>
                    <th>اضيف فى</th>
                    <th>اعطاء صلحيات</th>
                    <th>تعديل</th>
                    <th>حذف</th>
                </tr>
                </thead>

            </table>

        </div>
    </div>

@stop

@section('footer')
    <script src="{{ asset('js/datatables/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

    <script>
        var table1 = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.user.data') }}',
            columns: [
                {data: 'id', name:'id'},
                {data: 'name', name:'name'},
                {data: 'role', name:'role'},
                {data: 'created_at', name:'created_at'},
                {data: 'make_role', name:'make_role'},
                {data: 'edit', name:'edit'},
                {data: 'delete', name:'delete'},
            ],

            "language": {
                "url": "{{ asset('datatable/Arabic.json') }}"
            },

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
