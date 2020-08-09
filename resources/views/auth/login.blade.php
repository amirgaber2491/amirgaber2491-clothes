<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        body,html {
            background-image: url('https://i.imgur.com/xhiRfL6.jpg');
            height: 100%;
        }

        #profile-img {
            height:180px;
        }
        .h-80 {
            height: 80% !important;
        }
    </style>
</head>
<body style="direction: rtl">
<div class="container h-80">
    <div class="row align-items-center h-100">
        <div class="col-3 mx-auto">
            <div class="text-center">
                <img id="profile-img" class="rounded-circle profile-img-card" src="https://i.imgur.com/6b6psnA.png" />
                <p id="profile-name" class="profile-name-card"></p>
                <form  class="form-signin" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <input type="text" class="form-control" autofocus placeholder="ادخل اسم المستخدم" name="username" value="{{ old('username') }}">
                    <br>
                    <input type="password" name="password" id="inputPassword" class="form-control form-group" placeholder="ادخل كلمه المرور" required >

                    <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">تسجيل</button>
                </form>
                <!-- /form -->
            </div>
        </div>
    </div>
</div>
</body>
</html>

