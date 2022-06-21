<div class="w-[700px] bg-white p-4 relative flex justify-center">
    <x-slot name="myjs">
        <script>
            const delImgBtns = document.querySelectorAll('.delImgBtn');
            const cateSelect = document.querySelector('#cateSelect');
            const thSelect = document.querySelector('#thSelect');
            const subcateSelect = document.querySelector('select[name="subcate"]');
            const imgInput = document.querySelector('#imgInput');
            const imgContainer = document.querySelector('#imgContainer');
            const allSubcateOption = subcateSelect.querySelectorAll('option[data-option="true"]');
            const detailImgInput = document.querySelector('input[name="detailimg[]"]');
            const detailImgContain = document.querySelector('#detailimgcontain');
            const desImgInput = document.querySelector('input[name="desimg[]"]');
            const desImgContain = document.querySelector('#desimgcontain');
            var listfile = [];
            var listfile2 = [];
            
            const FileListItems = (files) => {
                var b = new ClipboardEvent("").clipboardData || new DataTransfer()
                for (var i = 0, len = files.length; i<len; i++) b.items.add(files[i])
                return b.files
            }
            if (delImgBtns) {
                delImgBtns.forEach(e=>{
                    e.addEventListener('click',()=>{
                        let yes = confirm('bạn muốn xóa ảnh này ra khỏi sản phẩm?');
                        if (yes) {
                            let _token   = $('meta[name="csrf-token"]').attr('content');
                            let id = e.getAttribute('del-id');
                            $.ajax({
                                url: '/dashboard/callajax/delimg/'+id,
                                type: 'PUT',
                                data: {
                                    _token: _token,
                                },
                                success: (res)=>{
                                    e.closest('.dibox').remove();
                                },
                                error: (err)=>{
                                    console.log(err);
                                    alert('loi');
                                }
                            })
                        }
                    })
                })
            }
            
            desImgInput.addEventListener('change', (e)=>{
                desImgContain.innerHTML = '';
                if (e.target.files.length<=0) {
                    return
                }
                let fileArr = Object.values(e.target.files);
                listfile2 = listfile2.concat(fileArr);
                listfile2.forEach((img,i)=>{
                    const preimg = document.createElement('img');
                    preimg.src = window.URL.createObjectURL(img);
                    preimg.className = "cursor-pointer object-cover w-[150px] h-[150px]";
                    preimg.setAttribute('alt','img');
                    preimg.setAttribute('indeximg',i);
                    preimg.addEventListener('click', ()=>{
                        let index = listfile2.indexOf(preimg);
                        listfile2.splice(index, 1);
                        preimg.remove();
                        desImgInput.files = FileListItems(listfile2);
                    })
                    desImgContain.appendChild(preimg);
                })
              
                desImgInput.files = FileListItems(listfile2);
            });
            // detailImgInput.addEventListener('change',(e)=>{
            //     detailImgContain.innerHTML = '';
            //     if (e.target.files.length<=0) {
            //         return
            //     }
            //     let fileArr = Object.values(e.target.files);
            //     listfile = listfile.concat(fileArr);
            //     listfile.forEach((img,i)=>{
            //         const preimg = document.createElement('img');
            //         preimg.src = window.URL.createObjectURL(img);
            //         preimg.className = " object-cover w-[150px] h-[150px]";
            //         preimg.setAttribute('alt','img');
            //         preimg.setAttribute('indeximg',i);
            //         preimg.addEventListener('click', ()=>{
            //             let index = listfile.indexOf(preimg);
            //             listfile.splice(index, 1);
            //             preimg.remove();
            //             detailImgInput.files = FileListItems(listfile);
            //         })
            //         detailImgContain.appendChild(preimg);
            //     })
              
            //     detailImgInput.files = FileListItems(listfile);
            // })
            detailImgInput.addEventListener('change',(e)=>{
                detailImgContain.innerHTML = '';
                if (e.target.files.length<=0) {
                    return
                }
                let fileArr = Object.values(e.target.files);
                listfile = listfile.concat(fileArr);
                listfile.forEach((img,i)=>{
                    const preimg = document.createElement('img');
                    preimg.src = window.URL.createObjectURL(img);
                    preimg.className = "cursor-pointer object-cover w-[150px] h-[150px]";
                    preimg.setAttribute('alt','img');
                    preimg.setAttribute('indeximg',i);
                    preimg.addEventListener('click', ()=>{
                        let index = listfile.indexOf(preimg);
                        listfile.splice(index, 1);
                        preimg.remove();
                        detailImgInput.files = FileListItems(listfile);
                    })
                    detailImgContain.appendChild(preimg);
                })
              
                detailImgInput.files = FileListItems(listfile);
            })
            imgInput.addEventListener('change',(e)=>{
                let previewimg = imgContainer.querySelector('#previewimg');
                if (previewimg) {
                    imgContainer.removeChild(previewimg);
                }
                if(e.target.files.length > 0){
                    const preimg = document.createElement('img');
                    preimg.src = window.URL.createObjectURL(e.target.files[0]);
                    preimg.className = "absolute top-0 left-0 object-cover w-[200px] h-[200px] z-10"
                    preimg.setAttribute('alt','img');
                    preimg.setAttribute('id','previewimg');
                    imgContainer.appendChild(preimg);
                }
            })
            cateSelect.addEventListener('change',()=>{
                thSelect.innerHTML="";
                let _token   = $('meta[name="csrf-token"]').attr('content');
                let idCate = cateSelect.value;
                if ( idCate && idCate !== '') {
                    subcateSelect.removeAttribute('disabled');
                    allSubcateOption.forEach(e=>{
                        subcateSelect.value='';
                        e.classList.add('hidden');
                        if (e.getAttribute('parent-id')==idCate) {
                            e.classList.remove('hidden');
                        }
                    })
                    $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': _token
                            },
                            url: "/dashboard/callajax/getthbycate/"+idCate,
                            type:"GET",
                            success:function(response){
                                response.forEach(e=>{
                                    let newOption = document.createElement("option");
                                    newOption.value = e.id;
                                    newOption.innerHTML = e.name;
                                    thSelect.appendChild(newOption);
                                });
                                thSelect.removeAttribute("disabled");
                            },
                            error: function(error) {
                            console.log(error);
                            alert('xay ra loi');
                            }
                        });
                }
                        
            })
        </script>
    </x-slot>
    <form action="{{ isset($thisp) ? route('product.edit',[$thisp->id]) : route('product.interface') }}" method="post" enctype="multipart/form-data" class="w-full p-4">
        @csrf
        @if(isset($thisp))
        <input type="hidden" name="_method" value="PUT">
        @endif
        
        <label for="cate" class="font-bold">loại sản phẩm</label>
        <select name="cate" id="cateSelect" class="block w-[200px] px-2 py-1">
            <option value=""></option>
            @foreach($allcate as $item)
               @if($item->parent==0)
               <option value="{{$item->id}}" {{(isset($thisp) && $thisp->cate == $item->id) ? 'selected' : ''}}>{{$item->name}}</option>
               @endif
            @endforeach
        </select>
        <label for="subcate" class="font-bold mt-5 block">danh mục con</label>
        <select name="subcate" id="cateSelect" {{isset($thisp) ? '' : 'disabled'}} class="block w-[200px] px-2 py-1">
            <option value="">không cần</option>
            @foreach($allcate as $item)
                @if(isset($thisp))
                        <option value="{{$item->id}}" parent-id="{{$item->parent}}" {{(isset($thisp) && $thisp->subcate == $item->id) ? 'selected' : ''}} data-option="true" class="{{(isset($thisp) && $thisp->cate == $item->parent) ? '' : 'hidden'}}">{{$item->name}}</option>
                @elseif($item->parent!=0)
                    <option value="{{$item->id}}" parent-id="{{$item->parent}}" {{(isset($thisp) && $thisp->cate == $item->id) ? 'selected' : ''}} data-option="true" class="hidden">{{$item->name}}</option>
                @endif
            @endforeach
        </select>

        {{-- <label for="productname" class="font-bold block mt-5">thêm size cho mặt hàng</label>
        <input type="text" placeholder="nhập size mới" class="px-2 py-1 outline-none border placeholder:italic placeholder:text-gray-300">
        <button class=" p-1 bg-green-500 text-white">thêm</button>
        <br/>
        <span class="italic">các loại size của mặt hàng này:</span>
        <span class="font-bold">hiện chưa có size nào cả</span> --}}
        
        
        
        {{-- <label for="productname" class="font-bold block w-full mt-5">thêm màu sắc cho mặt hàng</label>
        <input type="color" class="coloris px-2 py-1" data-coloris/> 
          <button class="p-1 bg-green-500 text-white ml-2 my-1">thêm</button>
        <br/>
        <span class="italic">các màu sắc của mặt hàng này:</span>
        <span class="font-bold">hiện chưa có màu sắc nào cả</span> --}}
        <label for="th" class="font-bold block mt-5">thương hiệu</label>
        <select name="th" id="thSelect" {{isset($thisp) ? '' : 'disabled'}} class="block w-[200px] px-2 py-1">
            <option value='' class="text-red-500">{{isset($allth) ? "" : 'hãy chon loại sp'}}</option>
            @if(isset($allth))
                @foreach($allth as $th)
                    <option value="{{$th->id}}" {{$thisp->th == $th->id ? 'selected' : ''}} class="">{{$th->name}}</option>
                @endforeach
            @endif
        </select>


        <label for="name" class="font-bold block mt-5">sản phẩm</label>
        <input type="text" name="name" value="{{$thisp->name ?? ''}}" placeholder="nhập tên sản phẩm" class="w-full mt-2 text-md px-2 py-1 placeholder:italic placeholder:text-gray-300"/>
        
        
       
           
        <label for="productIMG" class="block font-bold mt-5">hình ảnh</label>
        <div id="imgContainer" class="relative w-[200px] h-[200px] border border-black">
            <input type="file" id="imgInput" name="productIMG" class="z-20 opacity-20 w-[200px] h-[200px] relative after:w-full after:h-full after:absolute after:content-['chọn_từ_thiết_bị'] after:bg-white after:left-0 after:top-0 after:flex after:justify-center after:items-center after:text-xl after:border-2 after:cursor-pointer after:text-wrap"/>
            @if(isset($thisp->image))
                <img src="{{url('/public/images/'.$thisp->image)}}" alt="{{$thisp->name}}" class="w-[200px] h-[200px] object-cover absolute top-0 left-0">
            @endif
        </div>
        <br/>
        @if(isset($thisp))
            <div class="flex gap-3 flex-wrap w-full">
                @foreach($thisp->detailimg as $img)
                    @if(!$img->des)
                    <div class="dibox w-[100px] h-[100px] relative">
                        <img src="{{url($img->image)}}" class=" w-[100px] h-[100px] object-cover" alt="detail">
                        <i del-id = "{{$img->id}}" class=" delImgBtn fa-solid fa-trash-can absolute top-1 right-1 cursor-pointer p-1 bg-red-500 text-white"></i>
                    </div>
                    @endif
                @endforeach
            </div>
            
        @endif
        <label for="productIMG" class="block font-bold mt-5">thêm hình ảnh khác</label>
        <input type="file" class="" name="detailimg[]" multiple>
        <div id="detailimgcontain" class="flex gap-3 p-3 flex-wrap"></div>
        <label for="des" class="font-bold block mt-5">mô tả</label>
        <textarea name="des" class="p-1 w-full h-[200px] resize-none overflow-y-auto">{{isset($thisp) ? $thisp->des : ''}}</textarea>
        @if(isset($thisp))
        <label for="" class="font-bold">hình ảnh mô tả sản phẩm</label>
            <div class="flex gap-3 flex-wrap w-full">
                @foreach($thisp->detailimg as $img)
                    @if($img->des)
                    <div class= " dibox w-[100px] h-[100px] relative ">
                        <img src="{{url($img->image)}}" class=" w-[100px] h-[100px] object-cover" alt="detail">
                        <i del-id = "{{$img->id}}" class="delImgBtn fa-solid fa-trash-can absolute top-1 right-1 cursor-pointer p-1 bg-red-500 text-white"></i>
                    </div>
                    @endif
                @endforeach
            </div>
            
        @endif
        <label for="productIMG" class="block font-bold mt-5">thêm hình để giới thiệu và mô tả</label>
        <input type="file" class="" name="desimg[]" multiple>
        <div id="desimgcontain" class="flex gap-3 p-3 flex-wrap"></div>
            <span class="text-red-500 px-2 py-1 block">{{ session()->get('imgerr') }}</span>
        <button type="submit" class="px-2 py-1 bg-blue-400 text-white mt-4 rounded-sm">thêm</button>
    </form>
</div>