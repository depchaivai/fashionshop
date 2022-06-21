<x-mainpage>
    <x-slot name="myjs">
        <script>
            const delCartBtns = document.querySelectorAll('.delCartBtn');
            let _token = $('meta[name="csrf-token"]').attr('content');

            delCartBtns.forEach(e=>{
                e.addEventListener('click',()=>{
                    let id = e.getAttribute('cart-id');
                    $.ajax({
                        url: '/callajax/delcart/'+id,
                        type: "PUT",
                        data: {
                            _token:_token
                        },
                        success: (res)=>{
                            let pr = e.closest('.cartcard');
                            pr.remove();
                        },
                        error: (error)=>{
                            console.log(error);
                            alert('Error');
                        }
                    })
                })
            })
        </script>
    </x-slot>
    <div class="w-full min-h-screen h-full bg-gradient-to-r from-red-500 to-orange-500 flex justify-center">
        <div class="container py-10 flex justify-center">
            <div class="w-[900px] px-8 py-5 bg-white">
                <span class="w-full text-2xl font-bold"><i class="fa-solid fa-cart-shopping mr-2"></i>giỏ hàng của bạn</span>
                
                <form method="post" action="{{route('buynow')}}">
                    
                    @csrf
                    @foreach ($allcart as $item)
                    <x-cartitem :item="$item" editable/>
                    @endforeach
                    @if(count($allcart) <=0 )
                    <span class="block p-4 my-5 w-full text-center italic text-xl">giở hàng đang trống, vui lòng <a class="text-blue-500" href="/">chọn thêm</a></span>
                    @else
                    <div class="w-full flex justify-center gap-3">
                        <button type="submit" id="buyBtn" class="px-2 py-1 bg-blue-500 text-white">mua hàng</button>
                        <a href="/" class="px-2 py-1 bg-orange-500 text-white">xem thêm</a>
                    </div>
                    @endif
                </form>
                
            </div>
            
        </div>
    </div>
</x-mainpage>