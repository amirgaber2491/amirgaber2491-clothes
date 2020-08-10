@extends('layouts.master')
@section('title', 'المدخلات اليوميه')
@section('content')
    <div class="container" style="direction: rtl; text-align: right">
        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif
        <div>
            <h1 style="text-align: center">مدخلات / المشتريات</h1>
            <form action="{{ route('purchases') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="">اجمالى المشتريات</label>
                    <input type="text" class="form-control" name="total_purchases" value="{{ old('total_purchases') }}">
                    @error('total_purchases')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">الملاحظات</label>
                    <textarea class="form-control" name="dis_purchases" style="resize: vertical;">{{ old('dis_purchases') }}</textarea>
                    @error('dis_purchases')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">الفواتير</label>
                    <input type="file" class="form-control" name="images[]" multiple accept="image/*" id="fUpload">
                    @error('images')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                    @if(Session::has('error_purchases'))
                        <div class="alert alert-danger">
                            {{ Session::get('error_purchases') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="ارسال">
                </div>
            </form>
        </div>
        <div>
            <h1 style="text-align: center">مدخلات / المبيعات</h1>
            <form action="{{ route('sales') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="">اجمالى المبيعات</label>
                    <input type="text" class="form-control" name="total_sales">
                    @error('total_sales')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">الملاحظات</label>
                    <textarea class="form-control" name="dis_sales" style="resize: vertical;"></textarea>
                    @error('dis_sales')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="ارسال">
                </div>
            </form>
        </div>
        <div>
            <h1 style="text-align: center">مدخلات / المصروفات</h1>
            <form action="{{ route('expenses') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="">اجمالى المصروفات</label>
                    <input type="text" class="form-control" name="total_expenses">
                    @error('total_expenses')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">الملاحظات</label>
                    <textarea class="form-control" name="dis_expenses" style="resize: vertical;"></textarea>
                    @error('dis_expenses')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">الفواتير</label>
                    <input type="file" class="form-control" name="images[]" multiple accept="image/*" id="fUpload2">
                </div>
                @if(Session::has('error_expenses'))
                    <div class="alert alert-danger">
                        {{ Session::get('error_expenses') }}
                    </div>
                @endif
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="ارسال">
                </div>
            </form>
        </div>
    </div>


@stop
@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#fUpload').change(function(){
                var fp = $("#fUpload");
                var lg = fp[0].files.length; // get length
                var items = fp[0].files;
                var fileSize = 0;

                if (lg > 0) {
                    for (var i = 0; i < lg; i++) {
                        fileSize = fileSize+items[i].size; // get file size
                    }
                    if(fileSize > 2097152) {
                        alert('يجب الا تتعدى حجم الصور 2 ميجا');
                        $('#fUpload').val('');
                    }
                }
            });
            $('#fUpload2').change(function(){
                var fp = $("#fUpload2");
                var lg = fp[0].files.length; // get length
                var items = fp[0].files;
                var fileSize = 0;

                if (lg > 0) {
                    for (var i = 0; i < lg; i++) {
                        fileSize = fileSize+items[i].size; // get file size
                    }
                    if(fileSize > 2097152) {
                        alert('يجب الا تتعدى حجم الصور 2 ميجا');
                        $('#fUpload2').val('');
                    }
                }
            });
        });
    </script>

@stop
