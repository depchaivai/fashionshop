<x-dashboard.adminlayout>
    <x-slot name="myjs">
        <script>
            const uploadImgContainer = document.querySelector('#uploadImgContainer');
            const ImgInput = uploadImgContainer.querySelector('input[name="slideIMG"]');
            const previewimg = uploadImgContainer.querySelector('#previewimg');
            const delBtns = document.querySelectorAll('.delSlideBtn');
            delBtns.forEach(e=>{
                e.addEventListener('click', ()=>{
                    let delId = e.getAttribute('delId');
                    let yes = confirm('bạn muốn gỡ bỏ ảnh này ra khỏi slide?');
                    if(yes){
                        let _token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: '/dashboard/callajax/slide/del/'+delId,
                            type: 'PUT',
                            data: {
                                _token: _token
                            },
                            success: (res)=>{
                                if (res.success) {
                                    window.location.replace('/dashboard/spotlight');
                                }
                            },
                            error: (err)=>{
                                alert('đã xảy ra lỗi');
                                console.log(err);
                            }
                        })
                    }
                })
            })
            ImgInput.addEventListener('change',(e)=>{
                if(e.target.files.length > 0){
                    let newpreimg = window.URL.createObjectURL(e.target.files[0]);
                    previewimg.src=newpreimg;
                }
            });
        </script>
    </x-slot>
    <div class="w-full p-4">
        <span class="px-2 py-1 font-bold text-2xl block"><i class="fa-solid fa-images mr-2"></i>slideshow</span>
        <div class="mt-2 p-2">
            <span class="py-2 text-blue-500 capitalize font-bold block">Spotlight trên trang chủ</span>
            @if (count($slides)>0)   
             
            <div id="controls-carousel" class="relative" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="overflow-hidden relative pt-[35%] rounded-lg  ">
                        @foreach($slides as $slide)
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{URL($slide->image)}}" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2" alt="...">
                        </div>
                        @endforeach
                        
                      
                    </div>
                    <!-- Slider controls -->
                    <button type="button" class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-prev>
                        <span class="inline-flex justify-center items-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            <span class="hidden">Previous</span>
                        </span>
                    </button>
                    <button type="button" class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-next>
                        <span class="inline-flex justify-center items-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="hidden">Next</span>
                        </span>
                    </button>
                </div>
                @endif
                
            <span class="py-2 text-blue-500 capitalize font-bold block">đang show</span>
            @if (count($slides)<=0)
                <span class="p-2 italic">chưa có ảnh nào được chọn, vui lòng đăng ảnh.</span>
            @else
                <div class="flex flex-wrap gap-2">
                    @foreach($slides as $slide)
                        <div class="w-[300px] h-[150px] relative">
                            <img src="{{URL($slide->image)}}" alt="slide spotlight"  class="w-full h-full object-cover">
                            <button delId="{{$slide->id}}" class="delSlideBtn p-2 rounded-md text-white bg-red-500 absolute top-2 right-2">xóa</button>
                        </div>
                    @endforeach
                </div>
                
            @endif
            <span class="block mt-4 py-2 capitalize font-bold text-blue-500">thêm slide</span>
                <form action="{{route('slide.add')}}" method="post" enctype="multipart/form-data"">
                    @csrf
                    <div id="uploadImgContainer" class="flex relative">
                        <img id="previewimg" src="{{URL('/images/defaultImg.jpg')}}" alt="preload" class="w-[300px] h-[150px] object-cover absolute top-0 left-0 ">
                        <input type="file" name="slideIMG" class="w-[300px] h-[150px] border-4 z-50 opacity-0 cursor-pointer">
                    </div>
                    <div class="flex justify-center w-[300px]">
                        <button class="px-3 py-2 bg-green-500 text-white my-2 w-full">đăng</button>
                    </div>
                </form>
            <span class="text-red-500 px-2 py-1 block">{{ session()->get('imgerr') }}</span>
        </div>
       
    </div>
</x-dashboard.adminlayout>