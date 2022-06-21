<a class="" href="/chi-tiet/{{$item->id}}">
    <div class="w-full relative pt-[130%] shadow-sm bg-gray-100">
        @if($discounts > 0)
        <span class="absolute top-2 right-2 text-sm px-2 py-1 font-bold rounded-md text-white bg-yellow-300 z-10">-{{$discounts}}%</span>
        @endif
        <div class="absolute top-0 w-full h-full">
            <img src="{{url('/public/images/'.$item->image)}}" alt="cardimage" class="w-full object-cover h-[75%]">
            <div class="pb-2">
            <span class="w-full px-2 line-clamp-2 block font-bold mt-1">{{$item->name}}</span>
            <span class="flex w-full justify-between px-2">
                <span class=" text-sm {{$discounts > 0 ? 'line-through' : ''}} text-red-500 px-2 py-1">{{ number_format($item->firstview[0]->price,0,'','.')}} vnđ</span>
                @if ($discounts > 0)
                <span class="justify-self-end text-sm bg-yellow-300 text-white p-1">{{ number_format($item->firstview[0]->price-$item->firstview[0]->price*$discounts/100,0,'','.')}} vnđ</span>
                @endif
            </span>
        </div>
        </div>
    </div>
</a>
