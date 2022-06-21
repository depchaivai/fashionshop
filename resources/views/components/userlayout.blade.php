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
    <body class="antialiased bg-slate-200">
        <x-nav/>
        <div class="flex container mx-auto my-10 justify-center min-h-screen">
            <div class="w-1/5 sticky top-0 ">
                <ul class="list-none p-4 text-xl">
                    {{-- <li class="w-full"><a href="#" class="px-2 py-1 w-full block">thông tin tài khoản</a></li> --}}
                    <li class="w-full"><a href="/tai-khoan" class="px-2 py-1 w-full block"><i class="fa-solid fa-receipt mr-2"></i>đơn hàng</a></li>
                    <li class="w-full"><a href="/tai-khoan/dia-chi" class="px-2 py-1 w-full block"><i class="fa-solid fa-location-dot mr-2"></i>địa chỉ</a></li>
                    <li class="w-full"><a href="/tai-khoan/thong-bao" class="px-2 py-1 w-full block"><i class="fa-solid fa-bell mr-2"></i>thông báo</a></li>
                </ul>
            </div>
            <div class="w-4/5 bg-white">
                {{ $slot }}
            </div>
        </div>
        <x-footer/>
    </body>
    {{ $myjs ?? '' }}
    @if(Auth::check())
        <script>
            const userInfo = {!! auth()->user()->toJson() !!};
            const logoutBtn = document.querySelector('#logoutBtn');
            const searchInput = document.querySelector('#searchInput');
            const ulProduct = document.querySelector('#ulProduct');
            
            function debounce(fn, delay) {
                let timer;
                return (() => {
                    clearTimeout(timer);
                    timer = setTimeout(() => fn(), delay);
                })();
            
            };
            
            searchInput.addEventListener('keyup', e=>{
                debounce(()=>getListProduct(e.target.value),1000);
            })
            const getListProduct = (text) => {
                let _token   = $('meta[name="csrf-token"]').attr('content');
                if(text == ''){
                    ulProduct.innerHTML = '';
                    return
                }
                $.ajax({
                        headers: {
                                'X-CSRF-TOKEN': _token
                            },
                            url: "/callajax/productbytext/"+text,
                            type:"GET",
                            success:function(response){
                                ulProduct.innerHTML = '';
                                response.forEach(e=>{
                                    let newli = document.createElement('li');
                                    let newLink = document.createElement('a');
                                    newLink.className = 'flex w-full hover:bg-blue-300 p-1 items-center'
                                    newLink.href = "/chi-tiet/"+e.id;
                                    let newImg = document.createElement('img');
                                    newImg.src=public_path+'/'+e.image;
                                    newImg.className="w-[40px] h-[40px] ml-1 object-cover";
                                    let newSpan = document.createElement('span');
                                    newSpan.className="block font-bold px-1 w-[calc(100%_-_40px)] text-sm";
                                    newSpan.innerHTML = e.name;
                                    newLink.appendChild(newImg);
                                    newLink.appendChild(newSpan);
                                    newli.appendChild(newLink);
                                    ulProduct.appendChild(newli);
                                })
                            },
                            error: function(error) {
                                console.log(error);
                                alert('xay ra loi');
                            }
                })
            }
            logoutBtn.addEventListener('click', ()=>{
                $.ajax({
                    url: "/logout",
                    type:"GET",
                    success:function(response){
                        window.location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        </script>
    @endif
    {{-- <script src="https://unpkg.com/flowbite@1.4.2/dist/flowbite.js"></script> --}}
    <script src="https://kit.fontawesome.com/dab4d8d77a.js" crossorigin="anonymous"></script>
</html>