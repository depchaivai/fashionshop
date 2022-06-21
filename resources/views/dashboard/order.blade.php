<x-dashboard.adminlayout>
    <x-slot name="myjs">
        <script>
            const denyList = document.querySelectorAll('.deny');
            const cancelPopup = document.querySelector('#cancelPopup');
            const editOrderPopup = document.querySelector('#editOrderPopup');
            const yesCancel = document.querySelector('#yesCancel');
            const noCancel = document.querySelector('#noCancel');
            const updateStt = document.querySelectorAll('.updateStt');
            const sttCheckBox = editOrderPopup.querySelectorAll('input[type=radio]');
            const cancelUpdate = editOrderPopup.querySelector('#cancelUpdate');
            const updateNow = editOrderPopup.querySelector('#updateNow');
            const span_type = document.querySelectorAll('span[name="order-span-type"]');

            span_type.forEach(e=>{
                e.addEventListener('click', ()=>{
                    span_type.forEach(ele=>ele.classList.remove('ring-4'));
                    let typeo = e.getAttribute('order-type');
                    window.location.replace('/dashboard/don-hang?type='+typeo);
                })
            });
            
            noCancel.addEventListener('click',()=>{
                cancelPopup.classList.add('hidden');
                cancelPopup.removeAttribute('for-order');
            });
            cancelUpdate.addEventListener('click',()=>{
                editOrderPopup.classList.add('hidden');
                editOrderPopup.removeAttribute('for-order');
            });
            denyList.forEach(e=>{
                e.addEventListener('click', ()=>{
                    cancelPopup.classList.remove('hidden');
                    cancelPopup.setAttribute('for-order',e.getAttribute('order'));
                })
            });

            
            yesCancel.addEventListener('click', ()=>{
                let thisOrder = cancelPopup.getAttribute('for-order');
                if (thisOrder) {
                    let _token = $('meta[name="csrf-token"]').attr('content');
                    let message = cancelPopup.querySelector('textarea[name="cancel"]').value;
                    $.ajax({
                        url: '/dashboard/callajax/demiss/'+thisOrder,
                        type: 'POST',
                        data:{
                            _token: _token,
                            message: message
                        },
                        success: (res)=>{
                            if(res.success){
                                window.location.reload();
                            }
                            
                        },
                        error: (err)=>{
                            alert('loi');
                            console.log(err);
                        }
                    })
                }
            })
            window.onload = () => {
                let type = '';
                const params = new URLSearchParams(window.location.search);
                if (params.has('type')) {
                    type=params.get('type');
                }
                let ckd = document.querySelector('span[name="order-span-type"][order-type="'+type+'"]');
                ckd.classList.add('ring-4');
            }
            updateStt.forEach(e=>{
                e.addEventListener('click', ()=>{
                    
                    editOrderPopup.classList.remove('hidden');
                    editOrderPopup.setAttribute('for-order',e.getAttribute('order'));
                    let stt = e.getAttribute('order-stt');
                    sttCheckBox.forEach(cb=>{
                        console.log(cb.value);
                        if(cb.value==stt){
                            cb.checked=true;
                        }
                    })
                })
            });

            updateNow.addEventListener('click', ()=>{
                let thisOrder = editOrderPopup.getAttribute('for-order');
                if (thisOrder) {
                    let _token = $('meta[name="csrf-token"]').attr('content');
                    let stt = editOrderPopup.querySelector('input[type="radio"][name="stt"]:checked').value;
                    $.ajax({
                        url: '/dashboard/callajax/updatestt/'+thisOrder,
                        type: 'PUT',
                        data:{
                            _token: _token,
                            stt: stt
                        },
                        success: (res)=>{
                            if(res.success){
                                window.location.reload();
                            }
                            
                        },
                        error: (err)=>{
                            alert('loi');
                            console.log(err);
                        }
                    })
                }
            })
        </script>
    </x-slot>
    <div class="w-full p-4">
        <span class="px-2 py-1 font-bold text-2xl block"><i class="fa-solid fa-receipt mr-2"></i>quản lý đơn hàng</span>
        <div class="mt-5 p-2">
                <span class="flex mb-5">
                    <span name="order-span-type" order-type="" class="type-show px-2 py-1 block border rounded-sm mr-2 cursor-pointer bg-gray-500 text-white">tất cả</span>
                    <span name="order-span-type" order-type="order" class="type-show px-2 py-1 block border rounded-sm mr-2 cursor-pointer bg-blue-500 text-white">chưa xác nhận</span>
                    <span name="order-span-type" order-type="waiting" class="type-show px-2 py-1 block border rounded-sm mr-2 cursor-pointer bg-yellow-500 text-white">đang xử lý</span>
                    <span name="order-span-type" order-type="sending" class="type-show px-2 py-1 block border rounded-sm cursor-pointer bg-green-500 text-white">đã gửi</span>
                </span>
                
                <div class="">
                    @if(count($all_order) <= 0)
                        <span class="block w-full text-center italic">không có đơn nào</span>
                    @endif
                    @foreach($all_order as $item)
                        <div class="flex items-center">
                            <img src="{{url('/public/images/'.$item->saleproduct->thisproduct->image)}}" alt="{{$item->saleproduct->thisproduct->name}}" class="w-20 h-20 object-cover">
                            <div class="min-w-[200px] p-2">
                                <span class="font-bold p-2">{{$item->saleproduct->thisproduct->name}}</span><br>
                                <span class="p-2" class="text-red-600"><b class="text-red-600">{{number_format($item->saleproduct->price*(100-$item->discounts)/100,0,'','.')}}x{{$item->count}}</b></span>
                            </div>
                            <div class="min-w-[150px] p-2">
                                <span class=" p-2"><b>size: </b>{{$item->saleproduct->size}}</span><br>
                                <span class=" p-2"><b>color: </b><input type="color" disabled value="{{$item->saleproduct->color}}" class=""></span><br>
                            </div>
                           <span class="w-[120px] block text-xl font-bold text-red-700">{{number_format($item->saleproduct->price*$item->count*(100-$item->discounts)/100,0,'','.')}}</span>
                            <span class="w-[100px]"><i class="ml-2 {{ $item->stt == 'order' }}">{{$item->stt}}</i></span>
                            <div class="w-[250px]">
                                <span class="flex text-sm  my-1"><b class="mr-2"><i class="fa-solid fa-location-dot"></i></b><i>{{$item->address->address}}</i></span>
                                <span class="flex">
                                    <span class="flex text-sm my-1"><b class="mr-2"><i class="fa-solid fa-phone"></i></b><i>{{$item->address->phone_number}}</i></span>
                                    <span class="flex text-sm my-1 ml-4"><b class="mr-2"><i class="fa-solid fa-user"></i></b><i>{{$item->address->receiver}}</i></span>
                                </span>
                            </div>
                            <td class="border p-2 text-center">
                                <i order="{{$item->id}}" order-stt="{{$item->stt}}" class="updateStt fa-solid fa-pen-to-square text-xl text-green-500 mr-2 cursor-pointer"></i>
                                <i order="{{$item->id}}" class="deny fa-solid fa-square-minus text-xl text-red-500 cursor-pointer"></i>
                            </td>
                        </div>
                    @endforeach
                    
                    {!! $all_order->links() !!}
                </div>
        </div>
        <div id="cancelPopup" class="hidden fixed top-0 left-0 w-screen h-screen flex justify-center items-center">
            <div class="w-[300px] p-2 bg-slate-400">
                <span class="p-2">lý do hủy đơn?</span>
                <textarea name="cancel" id="cancelArea" class="p-1 resize-none w-full h-[100px] text-gray-500 text-sm">vì một số lý do không mong muốn nên chúng tôi buộc phải hủy đơn của quý khách, xin thứ lỗi vì sự bất tiện này, xin chân thành cảm ơn.</textarea>
                <button id="yesCancel" class="px-2 py-1 bg-blue-500 text-white">hủy đơn</button>
                <button id="noCancel" class="px-2 py-1 bg-red-500 text-white">không hủy</button>
            </div>
        </div>
        <div id="editOrderPopup" class=" hidden fixed top-0 left-0 w-screen h-screen flex justify-center items-center">
            <div class="w-[320px] p-2 bg-green-300">
                <span class="p-2 font-bold">cập nhật trạng thái đơn hàng</span>
                <div class="my-2">
                    <span class="mr-3">
                        <input name="stt" value="order" type="radio" class="">
                        chờ xử lý
                    </span>
                    <span class="mr-3">
                        <input name="stt" value="waiting" type="radio" class="">
                        đang xử lý
                    </span>
                    <span class="">
                        <input name="stt" value="sending" type="radio" class="">
                        đã gửi
                    </span>
                </div>
                <button id="updateNow" class="px-2 py-1 bg-green-500 text-white">cập nhật</button>
                <button id="cancelUpdate" class=" px-2 py-1 bg-red-500 text-white">hủy</button>
            </div>
        </div>
    </div>
</x-dashboard.adminlayout>