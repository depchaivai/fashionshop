<x-userlayout>
    <x-slot name="myjs">
        <script>
            const addAddPopup = document.querySelector('#addAddPopup');
            const closeAddressPopup = document.querySelector('#closeAddressPopup');
            const addAddBtn = document.querySelector('#addAddBtn');
            const openAddPopup = document.querySelector('#openAddPopup');
            const pick_adr = document.querySelectorAll('.pick_adr');
            pick_adr.forEach(e=>{
                e.addEventListener('click',()=>{
                    let adr = e.getAttribute('adr');
                    $.ajax({
                    url: '/callajax/pickadr/'+adr,
                    type: 'GET',
                    success: (res)=>{
                        if (res.success) {
                            window.location.reload();
                            return
                        }
                        alert('bạn cần đăng nhập lại');
                        window.location.replace('/login');
                    },
                    error: ()=>{
                        alert('đã xảy ra lỗi')
                    }
                })
                });
            });
            openAddPopup.addEventListener('click',()=>{
                addAddPopup.classList.remove('hidden');
            })
            closeAddressPopup.addEventListener('click', ()=>{
                addAddPopup.classList.add('hidden');
            });
            addAddBtn.addEventListener('click', ()=>{
                let _token = $('meta[name="csrf-token"]').attr('content');
                let receiver = addAddPopup.querySelector('input[name="receiver"]').value;
                let phone = addAddPopup.querySelector('input[name="phone_number"]').value;
                let addr = addAddPopup.querySelector('textarea[name="address"]').value;
                $.ajax({
                    url: '/callajax/addadd',
                    type: 'POST',
                    data: {
                        _token: _token,
                        receiver: receiver,
                        phone_number: phone,
                        address: addr
                    },
                    success: (res)=>{
                        if (res.success) {
                            window.location.reload();
                            return
                        }
                        alert('bạn cần đăng nhập lại');
                        window.location.replace('/login');
                    },
                    error: ()=>{
                        alert('đã xảy ra lỗi')
                    }
                })
            })
        </script>
    </x-slot>
    <div class="w-full p-5">
        <span class="w-full flex justify-between"><b>địa chỉ giao hàng</b><span id="openAddPopup" class="cursor-pointer flex p-2 items-center w-[150px] text-white bg-green-500"><i class="fa-solid fa-plus text-xl mr-2"></i>thêm địa chỉ</span></span>
        <hr class="my-2">
        @if(count($all_address) <=0 )
            <span class="w-full block text-center p-2 font-bold italic">chưa có địa chỉ nào</span>
        @endif
        @foreach ($all_address as $item)
            @if(isset($main_adr) && $item->id == $main_adr)
                <x-user.addresscard :mainadr="$main_adr" :item="$item"/>
            @else
                <x-user.addresscard :item="$item"/>
            @endif
        @endforeach
    </div>
    <x-user.addresspopup/>
</x-userlayout>