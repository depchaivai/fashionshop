<x-dashboard.adminlayout>
    <x-slot name="myjs">
        <script>
            const _token = $('meta[name="csrf-token"]').attr('content');
            const activeBtn = document.querySelectorAll('.fs-active input');
            const deleteFS = document.querySelectorAll('.deleteFS');
            deleteFS.forEach(e=>{
                e.addEventListener('click',()=>{
                    let yes = confirm('bạn thật sự muốn xóa?');
                    if (yes) {
                        let id = e.getAttribute('fs-id');
                        $.ajax({
                        url: '/dashboard/callajax/fs/delete/'+id,
                        type: 'PUT',
                        data: {
                            _token: _token
                        },
                        success: (res) => {
                            if (res.success) {
                                window.location.reload();
                            }
                        },
                        error: (err) => {
                            alert('loi');
                        }
                    })
                    }
                    
                })
            })
            activeBtn.forEach(e=>{
                e.addEventListener('click',()=>{
                    let cur = e.checked;
                    e.checked = !cur;
                    let id = e.getAttribute('fs-id');
                    $.ajax({
                        url: '/dashboard/callajax/fs/swactive/'+id,
                        type: 'PUT',
                        data: {
                            _token: _token
                        },
                        success: (res) => {
                            console.log(res);
                            if (res.success) {
                                e.checked = cur;
                            } else {
                                alert(res.message);
                            }
                        },
                        error: (err) => {
                            alert('loi');
                        }
                    })
                    
                })
            });
        </script>
    </x-slot>
    <div class="w-full p-4">
        <span class="px-2 py-1 font-bold text-2xl block"><i class="fa-solid fa-bolt mr-2"></i>flash sales</span>
        <span class="px-2 py-1 italic flex text-gray-400">tạo flash sales<a href="/dashboard/flash-sales/add" class="ml-2 block rounded-full bg-green-400 text-white w-7 h-7 text-center leading-7"><i class="fa-solid fa-plus"></i></a></span>
        <div class="mt-5">
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-500 text-white capitalize">
                        <th class="text-left p-2">#</th>
                        <th class="text-left p-2">tiêu đề</th>
                        <th class="text-left p-2">banner</th>
                        <th class="text-left p-2">bắt đầu</th>
                        <th class="text-left p-2">kết thúc</th>
                        <th class="text-left p-2">kích hoạt</th>
                        <th class="text-left p-2">thao tác</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach($all_fs as $k => $fs)
                    <tr>
                        <td>{{$k + 1}}</td>
                        <td>{{$fs->title}}</td>
                        <td class="p-1"><img src="{{URL($fs->banner)}}" alt="{{$fs->title}}" class="w-[200px] h-[60px] object-cover"></td>
                        <td>{{$fs->from}}</td>
                        <td>{{$fs->expire_day}}</td>
                        <td>
                            <label class="inline-flex relative items-center mr-5 cursor-pointer fs-active">
                                @if ($fs->active)
                                <input type="checkbox" fs-id = "{{$fs->id}}" class="sr-only peer" checked>
                                @else
                                <input type="checkbox" fs-id = "{{$fs->id}}" class="sr-only peer">
                                @endif
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                            </label>
                        </td>
                        <td class="text-center">
                            <a href={{"/dashboard/flash-sales/edit/$fs->id"}}><i class="editPBtn fa-solid fa-pen-to-square text-xl text-green-500 mr-2"></i></a>
                            <i fs-id="{{$fs->id}}" class="deleteFS fa-solid fa-square-minus text-xl text-red-500 cursor-pointer"></i>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard.adminlayout>