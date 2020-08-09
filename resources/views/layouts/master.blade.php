<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        صفحه / @yield('title')
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    @yield('header')
</head>
<body style="direction: rtl">
<!-- As a link -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('inputs') }}">مدخلات</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('purchases.index') }}">مشتريات</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('sales.index') }}">مبيعات</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('expenses.index') }}">مصروفات</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('report') }}">التقارير</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('user.profile') }}">الصفحه الشخصيه</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Str::title(Auth::user()->name) }}
                </a>
                <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                    <form action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                    </form>
                </div>
            </li>

        </ul>
    </div>
</nav>
@yield('content')
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
@yield('footer')
</body>
</html>
