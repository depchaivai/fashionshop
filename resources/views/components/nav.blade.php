<div class="w-full bg-white">
    <div class="container mx-auto h-[50px] flex items-center justify-between">
        <a href="/"><span class="text-4xl font-bold px-3 py-1 italic text-yellow-400">Nhatstyle</span></a>
        <ul class="flex h-full font-thin capitalize text-xl items-center z-50">
            @foreach ($allmenu as $item)
            @if($item->parent == 0)
            <li class="font-bold px-3 relative group flex items-center h-full hover:text-orange-500"><a href="/san-pham/{{$item->slug}}">{{$item->name}}</a>
                <ul class="invisible group-hover:visible absolute top-[100%] bg-gray-500 text-white w-[180px]">
                    @foreach ($allmenu as $subitem)
                        @if($subitem->parent == $item->id)
                            <li class="px-3 my-2 py-1 w-full hover:bg-orange-500"><a href="/san-pham/{{$item->slug}}?subcate[]={{$subitem->id}}">{{$subitem->name}}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
            @endif
            @endforeach
        </ul>

        <div class="flex items-center">
            <div class="flex border-2 rounded-md items-center bg-slate-100 relative">
                <span class=" w-7 h-7 text-center"><i class="fa-solid fa-magnifying-glass"></i></span>
                <form action="">
                    <input type="text" id="searchInput" class="w-[200px] outline-none border-none px-2 h-7 leading-7 bg-slate-100 focus:ring-0" placeholder="tìm kiếm sản phẩm">
                </form>
                <ul id="ulProduct" class="absolute z-50 w-full top-full left-0 bg-gray-200 shadow-sm"></ul>
            </div>
            <div class="relative">
                @if(Auth::check())
                    <div class="group flex items-center">
                        <span class="w-[35px] h-[35px] text-center leading-[35px] rounded-full uppercase bg-slate-600 text-white block ml-2 cursor-pointer">{{Auth::user()->name[0]}}</span>
                        <a href="/gio-hang" id='cart' class="mx-2 cursor-pointer"><i class="fa-solid fa-cart-shopping"></i></a>
                        <ul class="invisible group-hover:visible block absolute top-[34px] z-[100] right-0 w-[100px] italic p-1 cursor-pointer">
                            <li class="hover:bg-orange-200 bg-gray-300 px-2 py-1"><a href="/tai-khoan" class="">dashboard</a></li>
                            <li id='logoutBtn' class="hover:bg-orange-200 bg-gray-300 px-2 py-1">đang xuất</li>
                        </ul>
                        
                        
                    </div>
                    
                @else
                    <a href="/dang-nhap" class="mx-2 cursor-pointer"><i class="fa-solid fa-user"></i></a>
                @endif 
            </div>
            
        </div>
       
    </div>
    
</div>