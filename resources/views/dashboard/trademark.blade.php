<x-dashboard.adminlayout>
    <x-slot name="myjs">
        <script>
            const addTrademarkBtn = document.querySelector('#addTrademarkBtn');
            const addTrademarkPopup = document.querySelector('#addTrademarkPopup');
            const closeTrademarkBtn = document.querySelector('#closeTrademarkBtn');
            const TDInput = document.querySelector('#TDInput');
            const TDSelect = document.querySelector('#TDSelect');
            const callAddTrademarkBtn = document.querySelector('#callAddTrademarkBtn');
            const callEditTrademarkBtn = document.querySelector('#callEditTrademarkBtn');
            const deleteTHBtnList = document.querySelectorAll('.deleteTHBtn');
            const editTHBtnList = document.querySelectorAll('.editTHBtn');
            const closeTDPopUp = () => {
                addTrademarkPopup.classList.add('hidden');
                addTrademarkPopup.classList.remove('flex');
                TDInput.value='';
                TDSelect.value='';
                callAddTrademarkBtn.classList.remove('hidden');
                callEditTrademarkBtn.classList.add('hidden');
                if (addTrademarkPopup.getAttribute('cate')) {
                    addTrademarkPopup.removeAttribute('cate');
                }
            }
            const openTDPopUp = (trademark = '',cate='',thid='') => {
                addTrademarkPopup.classList.remove('hidden');
                addTrademarkPopup.classList.add('flex');
                TDInput.value=trademark;
                TDSelect.value=cate;
                if (thid && thid !== '') {
                    addTrademarkPopup.setAttribute('thid',thid);
                }
            }
            trademarkBtn.addEventListener('click',()=>openTDPopUp());
            closeTrademarkBtn.addEventListener('click',closeTDPopUp);

            callAddTrademarkBtn.addEventListener('click',(e)=>{
                e.preventDefault();
                let THName = TDInput.value;
                let THCate = TDSelect.value;
                let _token = $('meta[name="csrf-token"]').attr('content');
            
                $.ajax({
                    url: "/dashboard/callajax/addth",
                    type:"POST",
                    data:{
                        name:THName,
                        cate:THCate,
                        _token: _token
                    },
                    success:function(response){
                        window.location.replace("http://localhost:8000/dashboard/thuong-hieu");
                    },
                    error: function(error) {
                    console.log(error);
                    alert('xay ra loi');
                    }
                });
            })

            editTHBtnList.forEach(e=>{
                e.addEventListener('click',()=>{
                    let thname = e.getAttribute('thname');
                    let thcate = e.getAttribute('thcate');
                    let thid = e.getAttribute('thid');
                    callAddTrademarkBtn.classList.add('hidden');
                    callEditTrademarkBtn.classList.remove('hidden');
                    openTDPopUp(thname,thcate,thid);
                })
            })
            callEditTrademarkBtn.addEventListener('click',(e)=>{
                e.preventDefault();
                let thname = TDInput.value;
                let thcate = TDSelect.value;
                let thid = addTrademarkPopup.getAttribute('thid');
                let _token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                            url: "/dashboard/callajax/updateth/"+thid,
                            type:"PUT",
                            data:{
                                name:thname,
                                cate:thcate,
                                _token: _token
                            },
                            success:function(response){
                                window.location.replace("http://localhost:8000/dashboard/thuong-hieu");
                            },
                            error: function(error) {
                            console.log(error);
                            alert('xay ra loi');
                            }
                        });
            })

            deleteTHBtnList.forEach(e=>{
                e.addEventListener('click',()=>{
                    let yes = confirm('bạn có thực sự muốn xóa thuowng hiệu này?');
                    if(yes){
                        let idth = e.getAttribute('thid');
                        let _token   = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            url: "/dashboard/callajax/delth/"+idth,
                            type:"PUT",
                            data:{
                                _token: _token
                            },
                            success:function(response){
                                if (response.success) {
                                    window.location.replace("http://localhost:8000/dashboard/thuong-hieu");
                                }else{
                                    alert("vẫn còn nhiều sản phẩm có thương hiệu này, chưa thể xóa");
                                }
                                
                            },
                            error: function(error) {
                            console.log(error);
                            alert('xay ra loi');
                            }
                        });
                    }
                })
            })
        </script>
    </x-slot>
    <div class="w-full p-4">
        <span class="px-2 py-1 font-bold text-2xl block"><i class="fa-solid fa-registered mr-2"></i>quản lý thương hiệu</span>
        <span class="px-2 py-1 italic text-gray-400">thêm thương hiệu tại đây</span><button id="trademarkBtn" class="rounded-full bg-green-400 text-white w-7 h-7 text-center leading-7"><i class="fa-solid fa-plus"></i></button>
        <x-dashboard.trademarkpopup :allcate="$all_cate"/>
        <div class="mt-5">
            <ul class="">
                @foreach($all_th as $item)
                    <li class="px-2 py-1 flex items-center">
                        <i class="fa-solid fa-tag mr-2 text-blue-500"></i>
                        <span class="font-bold w-[200px]">{{$item->name}}</span>
                        <span class="text-gray-400 w-[100px]">{{$item->thiscate->name}}</span>
                        <i thid="{{$item->id}}" thname="{{$item->name}}" thcate="{{$item->cate}}" class="editTHBtn fa-solid fa-pen-to-square text-green-500 mr-2 cursor-pointer"></i>
                        <i thid="{{$item->id}}" class="deleteTHBtn fa-solid fa-square-minus text-red-500 cursor-pointer"></i>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-dashboard.adminlayout>