<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- Fonts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script>
            var public_path = '{{url('/public/images')}}';
        </script>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <x-nav/>
        <div class="flex justify-center w-full">
            {{$slot}}
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
    <script src="https://unpkg.com/flowbite@1.4.2/dist/flowbite.js"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/datepicker.js"></script>
    <script src="https://kit.fontawesome.com/dab4d8d77a.js" crossorigin="anonymous"></script>
</html>