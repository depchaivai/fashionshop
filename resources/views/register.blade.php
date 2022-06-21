<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="w-screen h-screen flex items-center justify-center bg-gradient-to-r from-cyan-500 to-blue-500">
            <div id="loginform" class="bg-white shadow-sm min-w-[300px] min-h-[300px] p-7">
                <form id="authenform" action="{{route('register')}}" method="post">
                    @csrf
                    <span class=" dk w-full font-bold text-2xl">đăng ký</span>
                    <input type="text" name="name" placeholder="tên đăng nhập" class=" block p-1 w-full my-5">
                    <input type="email" name="email" placeholder="email" class="dk block p-1 w-full my-5">
                    <input type="password" name="password" placeholder="mật khẩu" class=" block p-1 w-full my-5">
                    <input type="password" name="password_confirmation" placeholder="nhập lại mật khẩu" class="block p-1 w-full my-5">
                    @if($errors->any())
                            <span class="text-red-500 block p-1">{{$errors->first()}}</span>
                    @endif
                    <button type="submit" class="dk  px-2 py-1 bg-blue-500 text-white">đăng ký</button>
                    <br>
                    <div class="flex flex-col items-end">
                        <a href="/dang-nhap" class=" dk text-blue-500 cursor-pointer">đã có tài khoản</a>
                    </div>
                </form>
            </div>
        </div>       
    </body>
    <script src="https://unpkg.com/flowbite@1.4.2/dist/flowbite.js"></script>
    <script src="https://kit.fontawesome.com/dab4d8d77a.js" crossorigin="anonymous"></script>
</html>