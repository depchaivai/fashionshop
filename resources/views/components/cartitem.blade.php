    <div class="cartcard w-full h-[120px] flex items-center" hidden-id="{{$item->id}}">
        <input value="{{json_encode($item)}}" type="checkbox" name="spend[]" class="mx-2" checked>
        <img src="{{url('/public/images/'.$item->thiscartproduct->thisproduct->image)}}" alt="cardimage" class="w-[100px] object-cover h-[100px]">
        <div class="w-[calc(100%_-_200px)] px-5">
            <span class="w-full px-2 -y-1 block font-bold mt-2">{{$item->thiscartproduct->thisproduct->name}}
                @if ($item->thiscartproduct->thisproduct->discounts > 0)
                <b class="text-sm px-1 bg-yellow-300 text-white">-{{$item->thiscartproduct->thisproduct->discounts}}%</b>
                @endif
            </span>
            <span class="px-2">đơn giá</span>
            <span class=" text-red-500 py-1 {{$item->thiscartproduct->thisproduct->discounts > 0 ? 'line-through text-sm' : ''}}">{{ number_format($item->thiscartproduct->price)}}</span>
            @if ($item->thiscartproduct->thisproduct->discounts > 0)
                <span class="font-bold text-orange-500 px-2 py-1">{{ number_format($item->thiscartproduct->price-$item->thiscartproduct->price*$item->thiscartproduct->thisproduct->discounts/100)}}</span>
            @endif
            
            
            <span class="px-2">số lượng</span><span class=" text-red-500 px-2 py-1">x{{ number_format($item->count)}}</span>
            <br><span class="px-2">tổng tiền</span><span class=" text-red-700 px-2 py-1 font-bold">{{ number_format($item->count*$item->thiscartproduct->price*(100-$item->thiscartproduct->thisproduct->discounts)/100)}}</span>
        </div>
        <div class="w-[100px] text-center">
            <span class=""><i cart-id="{{$item->id}}" class="delCartBtn text-2xl text-red-500 cursor-pointer fa-solid fa-calendar-minus"></i></span>
        </div>
            
    </div>
