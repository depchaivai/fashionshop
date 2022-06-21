<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Laravel</title>

        <!-- Fonts -->
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script>
            var public_path = '{{url('/public/images')}}';
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="flex w-full min-h-screen">
        <div id="openMenuSpace" class="w-[40px] hidden"><i id="openMenuBtn" class="fa-solid fa-bars text-2xl w-full text-center mt-2 cursor-pointer"></i></div>

            <div id="leftmenu" class="w-1/5 bg-blue-900 sticky top-0 ">
                <span class="w-full h-10 relative flex items-center text-xl px-2 py-1 text-yellow-500"><i class="fa-solid fa-house"></i><span class='px-2'>logout</span><i id="toggleBtn" class="cursor-pointer fa-solid fa-angles-left text-2xl absolute top-2 right-2 text-white"></i></span>
                <a href="/" class="flex items-center justify-center py-5 w-full text-center font-bold bg-black/30 text-yellow-300 text-4xl">NhatStyle</a>
                <ul class="list-none py-4 text-md uppercase text-white/80 ">
                    {{-- <li class="w-full mb-1"><a href="/dashboard" class="px-6 hover:bg-yellow-500 py-1 w-full block"><i class="fa-solid fa-table-cells w-[35px] text-center"></i>dashboard</a></li> --}}
                    <li class="w-full mb-1"><a href="/dashboard/danh-muc" class="px-6 py-1 w-full block hover:bg-yellow-500"><i class="fa-solid fa-clipboard-list w-[35px] text-center"></i>danh mục</a></li>
                    <li class="w-full mb-1"><a href="/dashboard/don-hang" class="px-6 hover:bg-yellow-500 py-1 w-full block"><i class="fa-solid fa-receipt w-[35px] text-center"></i>đơn hàng</a></li>
                    <li class="w-full mb-1"><a href="/dashboard/spotlight" class="px-6 hover:bg-yellow-500 py-1 w-full block"><i class="fa-solid fa-images w-[35px] text-center"></i>spotlight</a></li>
                    <li class="w-full mb-1"><a href="/dashboard/san-pham" class="px-6 hover:bg-yellow-500 py-1 w-full block"><i class="fa-solid fa-shirt w-[35px] text-center"></i>sản phẩm</a></li>
                    <li class="w-full mb-1"><a href="/dashboard/thuong-hieu" class="px-6 hover:bg-yellow-500 py-1 w-full block"><i class="fa-solid fa-registered w-[35px] text-center"></i>thương hiệu</a></li>
                    <li class="w-full mb-1"><a href="/dashboard/dang-ban" class="px-6 hover:bg-yellow-500 py-1 w-full block"><i class="fa-solid fa-scale-unbalanced-flip w-[35px] text-center"></i>đang bán</a></li>
                    <li class="w-full mb-1"><a href="/dashboard/mau-ngung-ban" class="px-6 hover:bg-yellow-500 py-1 w-full block"><i class="fa-solid fa-ban w-[35px] text-center"></i>mẫu ngưng bán</a></li>
                    <li class="w-full mb-1"><a href="/dashboard/hang-ngung-ban" class="px-6 hover:bg-yellow-500 py-1 w-full block"><i class="fa-solid fa-circle-pause w-[35px] text-center"></i>hàng ngưng bán</a></li>
                    <li class="w-full mb-1"><a href="/dashboard/flash-sales" class="px-6 hover:bg-yellow-500 py-1 w-full block"><i class="fa-solid fa-bolt w-[35px] text-center"></i>flash sales</a></li>
                    <li></li>
                </ul>
            </div>
            <div class="flex-1">
                {{ $slot }}
            </div>
        </div>
    </body>
    <script>
        const toggleBtn = document.querySelector('#toggleBtn');
        const leftmenu = document.querySelector('#leftmenu');
        const openMenuBtn = document.querySelector('#openMenuBtn');
        const openMenuSpace = document.querySelector('#openMenuSpace');
        openMenuBtn.addEventListener('click', ()=>{
            leftmenu.classList.remove('hidden');
            openMenuSpace.classList.add('hidden');
        });
        toggleBtn.addEventListener('click', ()=>{
            leftmenu.classList.add('hidden');
            openMenuSpace.classList.remove('hidden');
        });
        
    </script>
    {{ $myjs ?? '' }}
    <script src="https://unpkg.com/flowbite@1.4.2/dist/flowbite.js"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/datepicker.js"></script>
    <script src="https://kit.fontawesome.com/dab4d8d77a.js" crossorigin="anonymous"></script>
</html>