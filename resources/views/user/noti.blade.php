<x-userlayout>   
    <div class="w-full p-5">
        <span class="w-full flex justify-between"><b>thông báo của bạn</b></span>
        <hr>
    @foreach($notis as $noti)
        <span class="flex p-1 text-sm ">
            <b>+</b>
            <b>{{$noti->product_name}}</b>
            <i>{{$noti->message}}</i>
            <b class="w-[150px] ml-2">{{date('d-m-Y', strtotime($noti->created_at))}}</b>
        </span>
    
    @endforeach
    </div>
</x-userlayout>