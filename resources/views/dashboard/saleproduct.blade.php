<x-dashboard.adminlayout>
    <x-slot name='myjs'>
        <script>
            const catefilter = document.querySelector('#catefilter');
            const thfilterList = document.querySelectorAll('.thpick');
            const rangefilterList = document.querySelectorAll('.rangepick');
            const findBtn = document.querySelector('#findBtn');
            const findInput = document.querySelector('input[name="findInput"]');
            const params = new URLSearchParams(window.location.search);
            const stopbuyList = document.querySelectorAll('.stopbuy');
            stopbuyList.forEach(e=>{
                e.addEventListener('click',()=>{
                    let yes = confirm('bạn thực sự muốn ngưng bán mặt hàng này?');
                    if (yes) {
                        let _token = $('meta[name="csrf-token"]').attr('content');
                        let pid = e.getAttribute('pid');
                        $.ajax({
                            url: '/dashboard/callajax/disablesalep/'+pid,
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
                let from='';
                if (params.has('cate')) {
                    cate=params.get('cate');
                }
                if (params.has('th')) {
                   let thchecked = document.querySelector('span[th="'+params.get('th')+'"]')
                   thchecked.classList.add('ring-4');
                }
                if (params.has('from')) {
                    from=params.get('from');   
                }
                let rangecheck = document.querySelector('span[range-from="'+from+'"]');
                rangecheck.classList.add('ring-4');
                catefilter.value = cate;
            }
            thfilterList.forEach(e=>{
                e.addEventListener('click',()=>{
                    let th=e.getAttribute('th');
                    window.location.replace('/dashboard/dang-ban?cate='+catefilter.value+'&&th='+th);
                });
            });
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
                window.location.replace('/dashboard/dang-ban?'+cate+th+'&find='+findInput.value);
            })
            rangefilterList.forEach(e=>{
                e.addEventListener('click',()=>{
                    let th='';
                    if (params.has('th')) {
                        th=params.get('th');
                    }
                    let from=e.getAttribute('range-from');
                    let to=e.getAttribute('range-to');
                    let range='';
                    if (parseInt(from) > 0) {
                        range='&&from='+from+'&&to='+to;
                    }
                    window.location.replace('/dashboard/dang-ban?cate='+catefilter.value+'&&th='+th+range);
                });
            });
            catefilter.addEventListener('change',(e)=>{
                let cate = e.target.value;
                let th='';
                if (params.has('th')) {
                    th=params.get('th');
                }
                window.location.replace('/dashboard/dang-ban?cate='+cate);
            });
        </script>
    </x-slot>
    <div class="w-full p-4">
        <span class="px-2 py-1 font-bold text-2xl block"><i class="fa-solid fa-scale-unbalanced-flip mr-2"></i>hàng đang bán</span>
        <span class="flex"><i class="px-2">thêm sản phảm muốn bán</i><a href="/dashboard/dang-ban/them" class="w-7 h-7 text-center leading-7 rounded-full bg-green-500 text-white block"><i class="fa-solid fa-plus"></i></a></span>
        {{-- <x-dashboard.productpopup/> --}}
        <div class="mt-5 p-2">
            <form action="" class="">
                <label for="cate" class="font-bold">danh mục: </label>
                <select name="cate" id="catefilter" class="px-2 py-1 min-w-[150px] border-0 italic text-orange-600" >
                    <option value="" class="">tất cả</option>
                    @foreach($allcate as $cate)
                        <option value="{{$cate->id}}" class="">{{$cate->name}}</option> 
                    @endforeach
                </select>
                <div id="thfilter" class="flex my-4 gap-2 items-center">
                    <i class="fa-solid fa-registered text-3xl"></i>
                    <span th="" class="thpick px-2 py-1 rounded-md border-2 cursor-pointer bg-gray-500 text-white">tất cả</span>

                    @foreach($allth as $th)
                        <span th="{{$th->id}}" class="thpick px-2 py-1 rounded-md border-2 cursor-pointer bg-red-500 text-white">{{$th->name}}</span>
                    @endforeach
                </div>
                <label for="cate" class="font-bold w-[100px]"><i class="fa-solid fa-coins text-3xl mr-1"></i></label>
                <span range-from="0" range-to="1000000" class="rangepick p-2 rounded-md border-2 cursor-pointer bg-gray-500 text-white">tất cả</span>
                <span range-from="1" range-to="100000" class="rangepick p-2 rounded-md border-2 cursor-pointer ml-1 bg-lime-500 text-white">dưới 100.000</span>
                <span range-from="100000" range-to="300000" class="rangepick p-2 rounded-md border-2 cursor-pointer ml-1 bg-lime-500 text-white">100.000-300.000</span>
                <span range-from="300000" range-to="500000" class="rangepick p-2 rounded-md border-2 cursor-pointer ml-1 bg-lime-500 text-white">300.000-500.000</span>
                <span range-from="501000" range-to="501000" class="rangepick p-2 rounded-md border-2 cursor-pointer ml-1 bg-lime-500 text-white">trên 500.000</span>
                <span class="flex justify-end px-5 my-2">
                    <input name="findInput" type="text" class="py-1 px-2 border-blue-500 placeholder:text-sm" placeholder="tìm kiếm">
                    <span id="findBtn" class="px-2 py-1 bg-blue-500 text-white cursor-pointer">tìm</span>
                </span>
            </form>
            @if(count($allsalep)<=0)
                <span class="w-full text-center block italic text-green-500">không có sản phẩm phù hợp với bộ lọc</span>
            @else
                <table class="w-full mb-4">
                <thead>
                    <tr class="bg-blue-500 text-white capitalize">
                        <th class="text-left p-2">hình ảnh</th>
                        <th class="text-left p-2">tên sp</th>
                        <th class="text-left p-2">thương hiệu</th>
                        <th class="text-left p-2">đơn giá</th>
                        <th class="text-left p-2">size</th>
                        <th class="text-left p-2">màu</th>
                        <th class="text-left p-2">loại sp</th>
                        <th class="text-left p-2">sl</th>
                        <th class="text-left p-2"></th>
                    </tr>
                </thead>
                <tbody class="text-md">
                    @foreach($allsalep as $item)
                        <tr class="even:bg-blue-200/50 odd:bg-green-100/50">
                            <td class="p-2 w-[120px]"><img src="{{url('/public/images/'.$item->thisproduct->image)}}" alt="{{$item->thisproduct->name}}" class="w-20 h-20 object-cover"></td>
                            <td class="font-bold p-2">{{$item->thisproduct->name}}</td>
                            <td class="p-2 italic">{{$item->thisproduct->thisth->name}}</td>
                            <td class="p-2 text-red-600">{{number_format($item->price,0,'','.')}}</td>
                            <td class="p-2 text-sky-500" >{{$item->size}}</td>
                            <td class="p-2" ><input type="color" disabled value="{{$item->color}}" class=""></td>
                            <td class="p-2 text-gray-500">{{$item->thisproduct->thiscate->name}}</td>
                            <td class="p-2">{{$item->count}}</td>
                            <td class="p-2 text-center">
                                <a href={{"/dashboard/dang-ban/edit/$item->id"}}><i class="editPBtn fa-solid fa-pen-to-square text-xl text-green-500 mr-2"></i></a>
                                <i pid="{{$item->id}}" class="stopbuy fa-solid fa-square-minus text-xl text-red-500 cursor-pointer"></i>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
            
            @endif
                {!! $allsalep->links() !!}
        </div>
    </div>
</x-dashboard.adminlayout>