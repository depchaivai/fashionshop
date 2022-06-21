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
                        url: '/dashboard/callajax/product/truedel/'+pid,
                        type: 'PUT',
                        data: {
                            _token:_token
                        },
                        success: function(res){
                            if (res.success) {
                                console.log(res);
                                window.location.reload();
                            }else{
                                alert('mẫu này đang còn hàng bán, không thể xóa')
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
                        url: '/dashboard/callajax/disableproduct/'+pid,
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
        <span class="px-2 py-1 font-bold text-2xl block"><i class="fa-solid fa-ban mr-2"></i>mẫu ngưng bán</span>
        <div class="mt-5">
            @if(count($allp) <= 0 )
            <span class="text-green-500 block w-full text-center">không có mặt hàng nào</span>
            @else
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-500 text-white capitalize">
                        <th class="text-left p-2">hình ảnh</th>
                        <th class="text-left p-2">tên sp</th>
                        <th class="text-left p-2">thương hiệu</th>
                        <th class="text-left p-2">loại sp</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach($allp as $item)
                        <tr class="border-b-[1px] even:bg-blue-100 odd:bg-blue-50">
                            <td class="p-1 w-[120px]"><img src="{{url('/public/images/'.$item->image)}}" alt="{{$item->name}}" class="w-20 h-20 object-cover"></td>
                            <td class="font-bold">{{$item->name}}</td>
                            <td class="w-[150px]">{{$item->thisth->name}}</td>
                            <td class="w-[150px]">{{$item->thiscate->name}}</td>
                            <td class="p-2 text-center ">
                                <span pid="{{$item->id}}" class="rebuy text-green-500 cursor-pointer p-1">mở bán lại</span>
                                <span pid="{{$item->id}}" class="truedel text-red-500 cursor-pointer p-1">xóa hẳn</span>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
            
            @endif
            {!! $allp->links() !!}
        </div>
    </div>
</x-dashboard.adminlayout>