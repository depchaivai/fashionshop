<x-userlayout>
    <x-slot name="myjs">
        <script>
            const ordering = document.querySelector('#ordering');
            const waiting = document.querySelector('#waiting');
            const sending = document.querySelector('#sending');
            const cancel = document.querySelector('#cancel');
            const demiss = document.querySelector('#demiss');
            const orderingBtn = document.querySelector('#orderingBtn');
            const waitingBtn = document.querySelector('#waitingBtn');
            const sendingBtn = document.querySelector('#sendingBtn');
            const cancelBtn = document.querySelector('#cancelBtn');
            const demissBtn = document.querySelector('#demissBtn');
            const hdn = document.querySelectorAll('.hdn');
            const cancelBtnList = document.querySelectorAll('.cancle-order');
            const reoderBtnList = document.querySelectorAll('.reorder');
            cancelBtnList.forEach(e=>{
                e.addEventListener('click',()=>{
                    let yes = confirm('bạn muốn hủy đơn này?');
                    if(yes){
                        $.ajax({
                            url: '/callajax/cancelorder/'+e.getAttribute('order'),
                            type: 'GET',
                            success: (res)=>{
                                if(res.success){
                                    window.location.reload();
                                }
                                
                            },
                            error: (err)=>{
                                console.log(err);
                            }
                        })
                    }
                })
            });
            reoderBtnList.forEach(e=>{
                e.addEventListener('click',()=>{
                    let yes = confirm('bạn muốn đặt lại đơn này?');
                    if(yes){
                        $.ajax({
                            url: '/callajax/reorder/'+e.getAttribute('order'),
                            type: 'GET',
                            success: (res)=>{
                                if(res.success){
                                    window.location.reload();
                                }
                                else{
                                    alert('sản phẩm đã bán hết, hoặc không đủ số lượng yêu cầu')
                                }
                            },
                            error: (err)=>{
                                console.log(err);
                            }
                        })
                    }
                })
            });
            const show = (section)=>{
                hdn.forEach(e=>{
                    e.classList.add('hidden');
                })
                section.classList.remove('hidden');
            }
            orderingBtn.addEventListener('click',()=>show(ordering));
            waitingBtn.addEventListener('click',()=>show(waiting));
            sendingBtn.addEventListener('click',()=>show(sending));
            cancelBtn.addEventListener('click',()=>show(cancel));
            demissBtn.addEventListener('click',()=>show(demiss));
        </script>
    </x-slot>
    <div class="w-full p-5">
        <span class="w-full flex justify-between"><b>đơn của bạn</b></span>
        <div class="w-full flex">
            <span id="orderingBtn" class="w-1/4 block px-2 py-1 text-center bg-red-400 text-white cursor-pointer">chờ xác nhận({{count($ordering)}})</span>
            <span id="waitingBtn" class=" w-1/4 block px-2 py-1 text-center bg-blue-400 text-white cursor-pointer">đang xử lý({{count($waiting)}})</span>
            <span id="sendingBtn" class=" w-1/4 block px-2 py-1 text-center bg-green-400 text-white cursor-pointer">đang giao({{count($sending)}})</span>
            <span id="cancelBtn" class=" w-1/4 block px-2 py-1 text-center bg-gray-400 text-white cursor-pointer">tự hủy({{count($cancel)}})</span>
            <span id="demissBtn" class=" w-1/4 block px-2 py-1 text-center bg-black text-white cursor-pointer">bị hủy({{count($demiss)}})</span>
        </div>
        <div id="ordering" class="hdn w-full p-5">
            <span class="font-bold text-orange-500">đang chờ xác nhận</span>
            @foreach($ordering as $item)
                <x-user.ordercard :item="$item"/>
            @endforeach
            @if(count($ordering)<=0)
            <span class="p-2 italic text-center w-full block">không có đơn nào</span>
            @endif
        </div>
        <div id="waiting" class="hdn hidden w-full p-5">
            <span class="font-bold text-orange-500">đang xử lý</span>
            @foreach($waiting as $item)
                    <x-user.ordercard :item="$item"/>
            @endforeach
            @if(count($waiting)<=0)
            <span class="p-2 italic text-center w-full block">không có đơn nào</span>
            @endif
        </div>
        <div id="sending" class="hdn hidden w-full p-5">
            <span class="font-bold text-orange-500">đang giao hàng</span>
            @foreach($sending as $item)
                    <x-user.ordercard :item="$item"/>
            @endforeach
            @if(count($sending)<=0)
            <span class="p-2 italic text-center w-full block">không có đơn nào</span>
            @endif
        </div>
        <div id="cancel" class="hdn hidden w-full p-5">
            <span class="font-bold text-orange-500">đã hủy</span>
            @foreach($cancel as $item)
                    <x-user.ordercard :item="$item"/>
            @endforeach
            @if(count($cancel)<=0)
            <span class="p-2 italic text-center w-full block">không có đơn nào</span>
            @endif
        </div>
        <div id="demiss" class="hdn hidden w-full p-5">
            <span class="font-bold text-orange-500">bị hủy</span>
            @foreach($demiss as $item)
                    <x-user.ordercard :item="$item"/>
            @endforeach
            @if(count($demiss)<=0)
            <span class="p-2 italic text-center w-full block">không có đơn nào</span>
            @endif
        </div>
    </div>
</x-userlayout>