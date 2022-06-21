<x-dashboard.adminlayout>
    <x-slot name="myjs">
        <script>
           const rebuy = document.querySelectorAll('.rebuy');
           const truedel = document.querySelectorAll('.truedel');
           truedel.forEach(e=>{
                e.addEventListener('click',()=>{
                   let yes = confirm('bạn muốn xóa hoàn toàn mẫu sản phẩm này?');
                   if (yes) {
                    let pid = e.getAttribute('pid');
                   let _token = $('meta[name="csrf-token"]').attr('content');
                   
                    $.ajax({
                        url: '/dashboard/callajax/salep/truedel/'+pid,
                        type: 'PUT',
                        data: {
                            _token:_token
                        },
                        success: function(res){
                            if (res.success) {
                                window.location.reload();
                            }else{
                                alert('có đơn hàng của sản phẩm này, chưa thể xóa')
                            }
                        },
                        error: function(err){
                            alert('loi');
                            console.log(err);
                        }
                    })
                   }
                   
               });
               })
           rebuy.forEach(e=>{
               e.addEventListener('click',()=>{
                   let yes = confirm('bạn muốn mở lại mẫu sản phẩm này?');
                   if (yes) {
                    let pid = e.getAttribute('pid');
                   let _token = $('meta[name="csrf-token"]').attr('content');
                   
                    $.ajax({
                        url: '/dashboard/callajax/disablesalep/'+pid,
                        type: 'PUT',
                        data: {
                            _token:_token
                        },
                        success: function(res){
                            if (res.success) {
                                window.location.reload();
                            }
                        },
                        error: function(err){
                            alert('loi');
                            console.log(err);
                        }
                    })
                   }
                   
               });
           });
        </script>
    </x-slot>
    <div class="w-full p-4">
        <span class="px-2 py-1 font-bold text-2xl block"><i class="fa-solid fa-circle-pause mr-2"></i>hàng ngưng bán</span>
        <div class="mt-5">
            @if(count($allsalep) <= 0 )
            <span class="text-green-500 block w-full text-center">không có mặt hàng nào</span>
            @else
            <table class="w-full">
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
                <tbody class="">
                    @foreach($allsalep as $item)
                        <tr class="even:bg-blue-100 odd:bg-blue-50">
                            <td class="p-2"><img src="{{url('/public/images/'.$item->thisproduct->image)}}" alt="{{$item->thisproduct->name}}" class="w-20 h-20 object-cover"></td>
                            <td class="font-bold p-2">{{$item->thisproduct->name}}</td>
                            <td class="p-2 italic">{{$item->thisproduct->thisth->name}}</td>
                            <td class="p-2 text-red-600">{{number_format($item->price,0,'','.')}}</td>
                            <td class="p-2 text-sky-500" >{{$item->size}}</td>
                            <td class="p-2" ><input type="color" disabled value="{{$item->color}}" class=""></td>
                            <td class="p-2 text-gray-500">{{$item->thisproduct->thiscate->name}}</td>
                            <td class="p-2">{{$item->count}}</td>
                            <td class="p-2 text-center ">
                                <span pid="{{$item->id}}" class="rebuy text-green-500 cursor-pointer p-1">mở bán lại</span>
                                <span pid="{{$item->id}}" class="truedel text-red-500 cursor-pointer p-1">xóa hẳn</span>
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