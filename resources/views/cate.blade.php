<x-mainpage>
    <x-slot name="myjs">
        <script type="text/javascript">
            const params = new URLSearchParams(window.location.search);
            const filterBtn = document.querySelector('#filterBtn');
            const checkAllBtns = document.querySelectorAll('.checkall');
            const priceRange = document.querySelectorAll('input[type="checkbox"][name="priceRange"]');
            const allInputCheckBox = document.querySelectorAll('input[type="checkbox"][fiter-cate="true"]');
            checkAllBtns.forEach(e=>{
                e.addEventListener('click', ()=>{
                        let name = e.getAttribute('forname');
                        checkall(name);
                })
            })
            const checkall = (name) => {
                let rs = document.querySelectorAll('input[type="checkbox"][name="'+name+'"]');
                if (rs && rs.length > 0) {
                    rs.forEach(ip=>{
                        ip.checked = !ip.checked;
                    })
                }
            }
            filterBtn.addEventListener('click', ()=>setQuery());
            
            priceRange.forEach(e=>{
                e.addEventListener('change', ()=>checkme(e));
            })
            const checkme = (ele)=>{
                priceRange.forEach(e=>{
                    e.checked = false;
                });
                ele.checked = true;
            }
            const setQuery = ()=>{
                let qr = '';
                let currURL = window.location.href.split('?')[0];
                let checked = document.querySelectorAll('input[type="checkbox"][fiter-cate="true"]:checked');
                if (checked.length <= 0) {
                    window.location.replace(currURL);
                    return
                }
                for (let index = 0; index < checked.length; index++) {
                    if (index==checked.length-1) {
                        qr=qr+checked[index].getAttribute('name')+'='+checked[index].value;
                    }else{
                        qr=qr+checked[index].getAttribute('name')+'='+checked[index].value+'&';
                    }
                }
                let endqr = qr.replace(/\[\]/g,'');
                window.location.replace(currURL+'?'+endqr);

            }
            window.onload = ()=>{
                checkafterload('subcate[]');
                checkafterload('priceRange');
                checkafterload('th[]');
                
            }
            const checkafterload = (name)=>{
                let results = params.getAll(name);
                if (results && results.length>0) {
                    results.forEach(e=>{
                        document.querySelector('input[type="checkbox"][name="'+name+'"][value="'+e+'"]').checked = true;
                    })
                }
            }
        </script>
    </x-slot>
    <div class="container">
        <div class="w-full h-[400px] relative">
            <img class="w-full h-full object-cover" src="/images/tt.jpg" alt="cate">
            <div class="absolute top-0 left-0 w-full h-full bg-black/70 flex"></div>
        </div>
        <span class="block p-2 text-2xl font-bold uppercase text-white border-b-2 bg-black text-center">danh mục "{{$cate[0]->name}}"</span>
        <div class="w-full flex mt-5">
            <div class="w-1/5">
                <form action="">
                    <div class="p-2 text-xl">
                        <span class="text-x flex items-center justify-between mb-5 w-full "><b>DANH MỤC</b></span>
                        <span forname="subcate[]" class="checkall cursor-pointer text-orange-500">chọn tất cả</span>
                        <br>
                        @if (count($subcates)>0)
                        
                            @foreach ($subcates as $sc)
                            <input type="checkbox" fiter-cate="true" name="subcate[]" value="{{$sc->id}}" class="">
                            <label for="subcate" class="">{{$sc->name}}</label>
                            <br>
                            @endforeach
                        @endif
               
    
                       
    
                        <span class="text-xl font-bold block my-5">KHOẢNG GIÁ</span>
                        <input type="checkbox" value="" name="priceRange" class="">
                        <label for="check" class="">tất cả</label>
                        <br>
                        <input type="checkbox" value="100000" name="priceRange" class="">
                        <label for="check" class="">ít hơn 100.000đ</label>
                        <br>
                        <input type="checkbox" value="300000" name="priceRange" class="">
                        <label for="check" class="">ít hơn 300.000đ</label>
                        <br>
                        <input type="checkbox" value="500000" name="priceRange" class="">
                        <label for="check" class="">ít hơn 500.000đ</label>
                        <br>
    
                        <span class="text-xl font-bold block my-5">THƯƠNG HIỆU</span>
                        <span forname="th[]" class="checkall block cursor-pointer text-orange-500">chọn tất cả</span>
                        @if(count($allth)>0)
                        @foreach($allth as $th)
                        <input type="checkbox" fiter-cate="true" value="{{$th->id}}" name="th[]" class="">
                        <label for="th" class="">{{$th->name}}</label>
                        <br>
                        @endforeach
                        @endif
                        <button id="filterBtn" class="mt-5 bg-blue-500 px-3 rounded-md py-2 text-white"><i class="fa-solid fa-filter mr-2"></i>lọc</button>
                    </div>
                </form>
            </div>
            <div class="w-4/5 grid grid-columns-4 gap-3 py-2">
                @if(count($allp)<=0)
                <span class="block px-5 py-3 italic">chưa có sản phẩm bán trong mục này</span>
                @else
                    <div class="grid grid-cols-4 gap-3">
                        @foreach($allp as $item)
                            <x-card :item="$item"/>
                        @endforeach
                    </div>
                @endif
                
                {!! $allp->links() !!}
            </div>
  
        </div>
    </div>
</x-mainpage>