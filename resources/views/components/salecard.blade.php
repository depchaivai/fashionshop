<div class="w-full h-full">
    <img src="{{url('/public/images/'.$item->image)}}" alt="cardimage" class="w-full object-cover h-[220px]">
    <span class="w-full px-2 -y-1 block font-bold mt-2">{{$item->name}}</span>
    <span class=" text-red-500 px-2 py-1">{{$vndformat($item->firstview[0]->price)}}</span>
</div>
