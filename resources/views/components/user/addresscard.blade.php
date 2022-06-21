<div class="{{isset($mainadr) ? 'font-bold' : ''}} w-full flex items-center">
    <span adr="{{$item->id}}" class=" px-1 w-[100px] block {{isset($mainadr) ? 'text-black' : 'cursor-pointer text-green-500 pick_adr'}}">{{isset($mainadr) ? 'mặc định' : 'chọn làm mặc định' }}</span>
    <span class=" block p-2 text-center"><i class="text-xl text-orange-500 fa-solid fa-location-dot"></i></span>
    <p class="p-2 w-[calc(100%_-_400px)]">{{$item->address}}</p>
    <span class="flex w-[150px] p-2 items-center"><i class="fa-solid fa-phone mr-2"></i>{{$item->phone_number}}</span>
    <span class="flex w-[200px] p-2 items-center"><i class="fa-solid fa-user mr-2"></i>{{$item->receiver}}</span>
    <span class="w-[100px] flex p-2 gap-2 text-xl"><i class="fa-solid fa-file-pen"></i><i class="text-red-500 fa-solid fa-circle-minus"></i></span>
</div>