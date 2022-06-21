<x-dashboard.adminlayout>
    <x-slot name="myjs">
        <script>
            const catefilter = document.querySelector('#catefilter');
            const thfilterList = document.querySelectorAll('.thpick');
            const params = new URLSearchParams(window.location.search);
            const findBtn = document.querySelector('#findBtn');
            const findInput = document.querySelector('input[name="findInput"]');
            const stopbuyList = document.querySelectorAll('.stopbuy');
            const closeDisBtn = document.querySelector('#closeDisBtn');
            const addDisBtn = document.querySelector('#addDisBtn');
            const addDisPopup = document.querySelector('#addDisPopup');
            const addDisName = addDisPopup.querySelector('label');
            const addDisInput = addDisPopup.querySelector('input');
            const changeDisBtns = document.querySelectorAll('.changeDisBtn');
            const invalidSpan = document.querySelector('#invalidSpan');
            const isDiscountsBtn = document.querySelector('input[type="checkbox"][name="discounts"]');
            isDiscountsBtn.addEventListener('change',()=>{
                var searchParams = new URLSearchParams(window.location.search);

                if (isDiscountsBtn.checked) {
                    searchParams.set("isdiscount", 1);
                    window.location.search = searchParams.toString();
                    return
                }
                searchParams.set("isdiscount", 0);
                window.location.search = searchParams.toString();
                return
            })
            stopbuyList.forEach(e=>{
                e.addEventListener('click',()=>{
                    
                    let yes = confirm('bạn thực sự muốn ngưng bán mặt hàng này?');
                    if (yes) {
                        let _token = $('meta[name="csrf-token"]').attr('content');
                        let pid = e.getAttribute('pid');
                        $.ajax({
                            url: '/dashboard/callajax/disableproduct/'+pid,
                            type: 'PUT',
                            data: {
                                _token:_token
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
            })
            window.onload = ()=>{
                let cate = '';
                let th = '';
                
                if (params.has('cate')) {
                    cate=params.get('cate');
                }
                if (params.has('th')) {
                   let thchecked = document.querySelector('span[th="'+params.get('th')+'"]')
                   thchecked.classList.add('ring-4');
                }
                if (params.has('isdiscount')) {
                    if (params.get('isdiscount')=='1') {
                        isDiscountsBtn.checked = true;
                    }else{
                        isDiscountsBtn.checked = false;
                    }
                    
                }
                catefilter.value = cate;
            }
            findBtn.addEventListener('click', ()=>{
                if (findInput.value.length <= 0) {
                    return;
                }
                th="";
                cate="";
               
                if (catefilter.value != '') {
                    cate='cate='+catefilter.value;
                }
                if (params.has('th')) {
                    th='&th='+params.get('th');
                }
                if (params.has('isdiscounts')) {
                    th='&th='+params.get('th');
                }
                window.location.replace('/dashboard/san-pham?'+cate+th+'&find='+findInput.value);
            })
            thfilterList.forEach(e=>{
                e.addEventListener('click',()=>{
                    let th='';
                    if (e.getAttribute('th') != '') {
                        th='&th='+e.getAttribute('th');
                    }
           
                    window.location.replace('/dashboard/san-pham?cate='+catefilter.value+th);
                });
            });
            catefilter.addEventListener('change',(e)=>{
                let cate = '';
                if (e.target.value != '') {
                    cate = '?cate='+e.target.value;
                }
                
                window.location.replace('/dashboard/san-pham'+cate);
            });
            closeDisBtn.addEventListener('click',()=>{
                addDisPopup.classList.add('hidden');
            })
            changeDisBtns.forEach(e=>{
                e.addEventListener('click',()=>{
                    let curValue = e.querySelector('b').innerHTML || 0;
                    addDisPopup.setAttribute('dis-id',e.getAttribute('dis-id'));
                    addDisPopup.setAttribute('last-discounts',parseInt(curValue));
                    addDisName.innerHTML = e.getAttribute('dis-name');
                    addDisInput.value = parseInt(curValue);
                    addDisPopup.classList.remove('hidden'); 
                })
            })
            addDisBtn.addEventListener('click', ()=>{
                invalidSpan.classList.add('hidden');
                let lastDis = parseInt(addDisPopup.getAttribute('last-discounts'));
                let newDiscounts =parseInt(addDisInput.value);
                if (lastDis == newDiscounts) {
                    addDisPopup.classList.add('hidden');
                    return
                }
                if (newDiscounts > 100) {
                    invalidSpan.classList.remove('hidden');
                    return
                }
                if (newDiscounts < 0) {
                    invalidSpan.classList.remove('hidden');
                    return
                }
                let id = addDisPopup.getAttribute('dis-id');
                let _token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '/dashboard/callajax/product/discounts/'+id,
                    type:"PUT",
                    data:{
                        _token: _token,
                        discounts: newDiscounts
                    },
                    success: (res)=>{
                        if (res.success) {
                            document.querySelector('span[dis-id="'+id+'"]').querySelector('b').innerHTML=newDiscounts;
                        }
                        else{
                            alert('loi gia tri, 0-100');
                        }
                        addDisPopup.classList.add('hidden');
                        
                    },
                    error: (err)=>{
                        alert('loi');
                        console.log(err);
                    }
                })
            })
        </script>
    </x-slot>
    <div class="w-full p-4">
        <span class="px-2 py-1 font-bold text-2xl block"><i class="fa-solid fa-shirt mr-2"></i>quản lý sản phẩm</span>
        <span class="flex items-center"><i class='text-gray-500 px-2'>thêm sản phẩm mới</i><a href="/dashboard/product/addnew" class="w-7 h-7 text-center leading-7 rounded-full bg-green-500 text-white block"><i class="fa-solid fa-plus"></i></a></span>
        <x-dashboard.productpopup/>
        <div class="px-2 w-full">
            <form action="" class="my-2">
                <label for="cate" class="font-bold">danh mục: </label>
                <select name="cate" id="catefilter" class="px-2 py-1 min-w-[150px] border-0 italic text-orange-600" >
                    <option value="" class="">tất cả</option>
                    @foreach($allcate as $cate)
                        <option value="{{$cate->id}}" class="">{{$cate->name}}</option> 
                    @endforeach
                </select>
                <input type="checkbox" name = "discounts" class="">
                <label for="discounts" class="">đang giảm giá</label>
                <div id="thfilter" class="flex py-2 gap-2 items-center">
                    <i class="fa-solid fa-registered text-3xl"></i>
                    <span th="" class="thpick px-2 py-1 rounded-md border-2 cursor-pointer bg-gray-500 text-white">tất cả</span>
                    @foreach($allth as $th)
                        <span th="{{$th->id}}" class="thpick px-2 py-1 rounded-md border-2 cursor-pointer bg-red-500 text-white">{{$th->name}}</span>
                    @endforeach
                </div>
                <span class="flex justify-end px-5">
                    <input name="findInput" type="text" class="px-2 py-1 placeholder:text-sm border-blue-500" placeholder="tìm kiếm">
                    <span id="findBtn" class="px-2 py-1 bg-blue-500 text-white cursor-pointer">tìm</span>
                </span>
            </form>
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-500 text-white capitalize">
                        <th class="text-left p-2">hình ảnh</th>
                        <th class="text-left p-2">tên sp</th>
                        <th class="text-left p-2">giảm giá</th>
                        <th class="text-left p-2">thương hiệu</th>
                        <th class="text-left p-2">loại sp</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach($allp as $item)
                        <tr class="even:bg-blue-100 odd:bg-blue-50">
                            <td class="p-1 w-[120px]"><img src="{{url('/public/images/'.$item->image)}}" alt="{{$item->name}}" class="w-20 h-20 object-cover"></td>
                            <td class="font-bold">{{$item->name}}</td>
                            <td><span dis-id="{{$item->id}}" dis-name="{{$item->name}}" class="changeDisBtn cursor-pointer text-red-500"><b class="">{{$item->discounts}}</b>%</span></td>
                            <td>{{$item->thisth->name}}</td>
                            
                            <td>{{$item->thiscate->name}}</td>
                            <td class="">
                                <a href={{"/dashboard/san-pham/edit/$item->id"}}><i class="editPBtn fa-solid fa-pen-to-square text-xl text-green-500 mr-2"></i></a>
                                <i pid="{{$item->id}}" class="stopbuy fa-solid fa-square-minus text-xl text-red-500 cursor-pointer"></i>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
            @if(count($allp) <= 0)
                <span class="w-full block text-center italic text-green-500">không tìm thấy sản phẩm phù hợp</span>
            @endif
            <div id="addDisPopup" class="hidden fixed top-0 left-0 flex justify-center items-center bg-black/30 w-screen h-screen">
                <div class="w-[200px] p-2 bg-white relative">
                    <span class="">thêm giảm giá %</span>
                    <label class="block w-full">quần dẻo</label>
                    <i id="closeDisBtn" class="fa-solid fa-xmark absolute top-1 right-1 text-red-500 text-2xl cursor-pointer"></i>
                    <input class="w-full p-1 my-2" type="number" min="0" max="100" class="">
                    <span id="invalidSpan" class="hidden block w-full text-red-500">0-100</span>
                    <span id="addDisBtn" class="block cursor-pointer px-2 py-1 bg-blue-500 text-white">thêm giảm giá</span>
                </div>
            </div>
            {!! $allp->links() !!}
        </div>
    </div>
</x-dashboard.adminlayout>