<x-mainpage>
    <x-slot name="myjs">
        <script>
       
            const changeAdrBtn = document.querySelector('#changeAdrBtn');
            const changeAdrPopup = document.querySelector('#changeAdrPopup');
            const closeChangeAdr = document.querySelector('#closeChangeAdr');
            const adrforchange = document.querySelectorAll('.adrforchange');
            const receiver_adr = document.querySelector('#receiver_adr');
            const r_adr = document.querySelector('#r_adr');
            const r_receiver = document.querySelector('#r_receiver');
            const r_phone = document.querySelector('#r_phone');
            const buyBtn = document.querySelector('#buyBtn');
            const total = document.querySelector('#total');
            const itemList = document.querySelectorAll('input[type="checkbox"][name="spend[]"]');
            buyBtn.addEventListener('click',()=>{
                let arr = [];
                let checked = document.querySelectorAll('input[type="checkbox"][name="spend[]"]:checked');
                checked.forEach(e=>{
                    arr.push(e.value);
                })
                let _token = $('meta[name="csrf-token"]').attr('content');
                let adr = receiver_adr.getAttribute('adr');
                $.ajax({
                    url: '/callajax/ordernow',
                    type: 'POST',
                    data: {
                        _token: _token,
                        orders: arr,
                        adr: adr
                    },
                    success: (res)=>{
                        if(res.success){
                            window.location.replace('/xac-nhan');
                        }
                    },
                    error: ()=>{
                        alert('loi');
                    }
                })
            })
            itemList.forEach(e=>{
                e.addEventListener('change',()=>{
                    let vl = JSON.parse(e.value);
                    let crrString = total.innerHTML.replace(/\./g,'').replace(/a-Z/,'');
                    let crrTotal = parseInt(crrString);
                    if(!e.checked){
                        let newTotal = crrTotal - parseInt(vl.count * vl.thiscartproduct.price*(100-vl.thiscartproduct.thisproduct.discounts)/100);
                        total.innerHTML = newTotal.toLocaleString('it-IT', {style : 'currency', currency : 'VND'});
                    }else{
                        let newTotal = crrTotal + parseInt(vl.count * vl.thiscartproduct.price*(100-vl.thiscartproduct.thisproduct.discounts)/100);
                        total.innerHTML = newTotal.toLocaleString('it-IT', {style : 'currency', currency : 'VND'});
                    }
                    
                });
            });
            changeAdrBtn.addEventListener('click',()=>{
                changeAdrPopup.classList.remove('hidden');
            });
            closeChangeAdr.addEventListener('click',()=>{
                changeAdrPopup.classList.add('hidden');
            });
            adrforchange.forEach(e=>{
                e.addEventListener('click',()=>{
                    receiver_adr.setAttribute('adr',e.getAttribute('adr'));
                    r_adr.innerHTML = e.getAttribute('adr_text');
                    r_phone.innerHTML = e.getAttribute('adr_phone');
                    r_receiver.innerHTML = e.getAttribute('adr_receiver');
                    changeAdrPopup.classList.add('hidden');
                })
            });
        </script>
    </x-slot>
    <div class="w-full min-h-screen h-full bg-gradient-to-r from-blue-500 to-green-500 flex justify-center">
        <div class="container py-10 flex justify-center">
            <div class="w-[900px] px-8 py-5 bg-white">
                <span class="w-full text-2xl font-bold"><i class="fa-solid fa-cart-arrow-down mr-2"></i>xác nhận đơn hàng</span>
                
                <div class="my-5">
                    <span class="font-bold text-orange-500">địa chỉ</span>
                    @if (count($alladr)<=0)
                    <span class="p-4">hiện chưa có địa chỉ nào, vui lòng <a href="/tai-khoan/dia-chi" class="text-blue-500">thêm</a></span>
                    
                    @elseif(is_null($adr))
                    <div id="receiver_adr" adr="{{$alladr[0]->id}}" class="flex p-4 items-center text-blue-500">
                        <span class="mx-3"><i class="fa-solid fa-location-dot mr-2 text-orange-500"></i><b id="r_adr">{{$alladr[0]->address}}</b></span>
                        <span class="mx-3"><i class="fa-solid fa-phone mr-2 text-orange-500"></i><b id='r_phone'>{{$alladr[0]->phone_number}}</b></span>
                        <span class="mx-3"><i class="fa-solid fa-person mr-2 text-orange-500"></i><b id="r_receiver">{{$alladr[0]->receiver}}</b></span>
                        <span id="changeAdrBtn" class="text-green-500 cursor-pointer p-2 text-2xl"><i class="fa-solid fa-arrows-rotate"></i></span>
                    </div>
                        @else
                        <div id="receiver_adr" adr="{{$adr[0]->id}}" class="flex p-4 items-center text-blue-500">
                            <span class="mx-3"><i class="fa-solid fa-location-dot mr-2 text-orange-500"></i><b id="r_adr">{{$adr[0]->address}}</b></span>
                            <span class="mx-3"><i class="fa-solid fa-phone mr-2 text-orange-500"></i><b id='r_phone'>{{$adr[0]->phone_number}}</b></span>
                            <span class="mx-3"><i class="fa-solid fa-person mr-2 text-orange-500"></i><b id="r_receiver">{{$adr[0]->receiver}}</b></span>
                            <span id="changeAdrBtn" class="text-green-500 cursor-pointer p-2 text-2xl"><i class="fa-solid fa-arrows-rotate"></i></span>
                        </div>
                        

                        
                    @endif
                </div>
                <hr>
                <form method="post" action="{{route('buynow')}}">
                    @csrf
                    @foreach ($willbuy as $item)
                    <x-cartitem :item="$item"/>
                    @endforeach
                </form>
                <hr>
                <span class="flex font-bold text-xl"><span class="font-bold">tổng tiền:</span><b id="total" class="text-red-500 ml-2">{{number_format($total,0,'','.')}}VND</b></span>
                <hr>
                    <div class="w-full flex justify-center gap-3 my-5">
                        <button id="buyBtn" class="px-2 py-1 bg-blue-500 text-white">xác nhận</button>
                        <a href="/" class="px-2 py-1 bg-orange-500 text-white">giỏ hàng</a>
                    </div>
            </div>
            
        </div>
        <div id="changeAdrPopup" class="fixed top-0 left-0 w-screen h-screen flex justify-center items-center bg-black/40 hidden">
            <div class="w-[300px] p-5 bg-white relative">
                <i id="closeChangeAdr" class="fa-solid fa-xmark absolute top-2 right-2 text-2xl cursor-pointer text-red-500"></i>
                <span class="w-full">chọn địa chỉ</span>
                @foreach($alladr as $item)
                    <div class="flex w-full p-1 text-green-500">
                        <span adr="{{$item->id}}" adr_text="{{$item->address}}" adr_receiver = "{{$item->receiver}}" adr_phone = "{{$item->phone_number}}" class="adrforchange cursor-pointer">{{$item->address}}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-mainpage>