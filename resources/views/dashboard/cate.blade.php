<x-dashboard.adminlayout>
    <x-slot name="myjs">
        <script>
            const addCateBtn = document.querySelector('#addCateBtn');
            const addCatePopup = document.querySelector('#addCatePopup');
            const closeCateBtn = document.querySelector('#closeCateBtn');
            const callAddCateBtn = document.querySelector('#callAddCateBtn');
            const callEditCateBtn = document.querySelector('#callEditCateBtn');
            const deleteCateBtnList = document.querySelectorAll('.deleteCateBtn');
            const editCateBtnList = document.querySelectorAll('.editCateBtn');
            const cateNameInput = document.querySelector('#cateName');
            const cateParentInput = document.querySelector('#cateParent');
            const closeCatePopup = () => {
                addCatePopup.classList.add('hidden');
                addCatePopup.classList.remove('flex');
                cateNameInput.value='';
                cateParentInput.value=0;
                callEditCateBtn.classList.add('hidden');
                callAddCateBtn.classList.remove('hidden');
                cateParentInput.removeAttribute('disabled');
                if(addCatePopup.getAttribute('cate')){
                    addCatePopup.removeAttribute('cate');
                }
            }
            const openCatePopup = (cname = '', pcate = 0, cateId = '') => {
                addCatePopup.classList.remove('hidden');
                addCatePopup.classList.add('flex');
                cateNameInput.value=cname;
                cateParentInput.value=pcate;
                if(cname != '' && pcate == 0){
                    cateParentInput.setAttribute('disabled','');
                }
                if (cateId && cateId !== '') {
                    addCatePopup.setAttribute('cate',cateId);
                }
            }
            addCateBtn.addEventListener('click',()=>openCatePopup());
            closeCateBtn.addEventListener('click',closeCatePopup);
            callAddCateBtn.addEventListener('click',(e)=>{
                e.preventDefault();
                let catename = cateNameInput.value;
                let cateparent = cateParentInput.value;
                let _token   = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "/dashboard/callajax/addcate",
                    type:"POST",
                    data:{
                        name:catename,
                        parent:cateparent,
                        _token: _token
                    },
                    success:function(response){
                        if (response.success) {
                            window.location.reload();
                        }
                        
                    },
                    error: function(error) {
                    console.log(error);
                    alert('xay ra loi');
                    }
                });
            });
            editCateBtnList.forEach(e=>{
                e.addEventListener('click', ()=>{
                    let catename = e.getAttribute('catename');
                    let cateparent = e.getAttribute('cateparent');
                    let cate_id = e.getAttribute('cate');
                    callAddCateBtn.classList.add('hidden');
                    callEditCateBtn.classList.remove('hidden');
                    openCatePopup(catename,cateparent,cate_id);
                
                })
            })
            callEditCateBtn.addEventListener('click',()=>{
                let _token = $('meta[name="csrf-token"]').attr('content');
                let catename = cateNameInput.value;
                let cateparent = cateParentInput.value;
                let idCate = addCatePopup.getAttribute('cate');
                $.ajax({
                            url: "/dashboard/callajax/updatecate/"+idCate,
                            type:"PUT",
                            data:{
                                name: catename,
                                parent: cateparent,
                                _token: _token
                            },
                            success:function(response){
                                window.location.replace("http://localhost:8000/dashboard/danh-muc");
                            },
                            error: function(error) {
                            console.log(error);
                            alert('xay ra loi');
                            }
                        });
            })
            deleteCateBtnList.forEach(e=>{
                e.addEventListener('click',()=>{
                    let yes = confirm('bạn có thực sự muốn xóa danh mục này?');
                    if(yes){
                        let idCate = e.getAttribute('cate');
                        let _token   = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            url: "/dashboard/callajax/delcate/"+idCate,
                            type:"PUT",
                            data:{
                                _token: _token
                            },
                            success:function(response){
                                if (response.success) {
                                    window.location.replace("http://localhost:8000/dashboard/danh-muc");
                                } else {
                                    alert('đang có nhiều sản phẩm có thương hiệu này, không thể xóa');
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
    <div class="w-full p-5">
        <span class="py-1 font-bold text-2xl block"><i class="fa-solid fa-clipboard-list mr-2"></i>quản lý danh mục</span>
        <span class="py-1 italic text-gray-400">thêm danh mục tại đây</span><button id="addCateBtn" class="rounded-full ml-2 bg-green-400 text-white w-7 h-7 text-center leading-7"><i class="fa-solid fa-plus"></i></button>
        <x-dashboard.catepopup :allcate="$all_cate"/>
        <div class="mt-4">
            <ul class="">
                @foreach ($all_cate as $item)
                    @if($item->parent == 0)
                        <li class="relative px-2 py-1 flex items-center">
                            <i class="fa-solid fa-tag mr-2 text-blue-500"></i>
                            <span class="font-bold w-[200px]">{{$item->name}}</span>
                            <i cate="{{$item->id}}" catename="{{$item->name}}" cateparent="{{$item->parent}}" class="editCateBtn fa-solid fa-pen-to-square text-green-500 mr-2 cursor-pointer"></i>
                            <i cate="{{$item->id}}" class="deleteCateBtn fa-solid fa-square-minus text-red-500 cursor-pointer"></i>
                        </li>  
                        <ul class="pl-5">
                            @foreach ($all_cate as $child)
                                @if ($item->id == $child->parent)
                                    <li class="px-2 py-1 flex items-center">
                                        <i class="fa-solid fa-tag mr-2 text-blue-400"></i>
                                        <span class="font-bold w-[180px] text-gray-400">{{$child->name}}</span>
                                        <i cate="{{$child->id}}" catename="{{$child->name}}" cateparent="{{$child->parent}}" class="editCateBtn fa-solid fa-pen-to-square text-green-500 mr-2 cursor-pointer"></i>
                                        <i cate="{{$child->id}}" class="deleteCateBtn fa-solid fa-square-minus text-red-500 cursor-pointer"></i>
                                    </li> 
                                @endif
                            @endforeach
                        </ul> 
                    @endif 
                @endforeach
            
            </ul>
        </div>
    </div>
</x-dashboard.adminlayout>