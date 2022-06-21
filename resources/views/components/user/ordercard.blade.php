<div class="w-full p-2 flex my-2">
    <img src="{{url('/public/images/'.$item->saleproduct->thisproduct->image)}}" alt="{{$item->saleproduct->thisproduct->name}}" class="w-[100px] h-[100px] object-cover">
    <div class="w-[calc(100%_-_100px)] flex">
        <div class="w-1/2 px-4">
            <span class="w-full p-1 font-bold text-sky-600 block">{{$item->saleproduct->thisproduct->name}}</span>
            <span class="p-1 px-5">số lượng: <b class="text-orange-500 ml-1">x{{$item->count}}</b></span>
            <span class="p-1 px-5">đơn giá: <b class="text-orange-500 ml-1">{{number_format($item->saleproduct->price*(100-$item->discounts)/100,0,'','.')}}</b></span>
            <span class="p-1 block px-5">tổng tiền: <b class="text-orange-500 ml-1">{{number_format($item->saleproduct->price*$item->count*(100-$item->discounts)/100)}}</b></span>
        </div>
        <div class="w-1/2 px-4 text-sm">
            <span class="w-full block"><i class="text-orange-500 mr-2 fa-solid fa-location-dot"></i>{{$item->address->address}}</span>
            <span class="w-full block"><i class="fa-solid fa-user text-orange-500 mr-2"></i>{{$item->address->receiver}}</span>
            <span class="w-full"><i class="fa-solid fa-phone text-orange-500 mr-2"></i>{{$item->address->phone_number}}</span>
        </div>
        @if($item->stt=="order" || $item->stt=="waiting")
        <span order="{{$item->id}}" class="cancle-order cursor-pointer block text-center text-red-500 w-[100px]">hủy đơn</span>
        @endif
        @if($item->stt=="cancel")
        <span order="{{$item->id}}" class="reorder cursor-pointer block text-center text-red-500 w-[100px]">đặt lại</span>
        @endif
    </div>
</div>