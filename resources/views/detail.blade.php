<x-mainpage>
  <x-slot name="myjs">
    <script type="text/javascript">
      const detailimgs = document.querySelectorAll('.detailimg'); //
      const mainImg = document.querySelector('#mainImg');
      const myCount = document.querySelector('#myCount');
      const insBtn = document.querySelector('#insBtn').addEventListener('click', ()=>editCount(1));
      const desBtn = document.querySelector('#desBtn');
      const detailBtn = document.querySelector('#detail');
      const icon = detailBtn.querySelectorAll('i')[0];
      const dcontent = document.querySelector('#detail-content');
      const mp = document.querySelector('#mp');
      const vp = document.querySelector('#vp');
      const vote = document.querySelector('#vote');
      const pimage = document.querySelector('#pimage');
      const productInfoBox = document.querySelector('#productInfoBox');
      const radioSize = productInfoBox.querySelectorAll('input[name="size"]');
      const radioColor = productInfoBox.querySelectorAll('input[name="color"]');
      const priceSpan = productInfoBox.querySelector('#priceSpan');
      const addToCartBtn = document.querySelector('#addToCartBtn');
      const prePrice = document.querySelector('#prePrice');
      const btnSendFB = document.querySelector('#sendFB');
      const FeedbackContent = document.querySelector('#feedback');
      btnSendFB.addEventListener('click', ()=>{
        if (!FeedbackContent) {
          alert('chưa đăng nhập');
          return
        }
        let _token = $('meta[name="csrf-token"]').attr('content');
        let id = btnSendFB.getAttribute('p-id');
        let content = FeedbackContent.value;
        $.ajax({
          url: '/callajax/product/feedback/'+id,
          type: 'POST',
          data: {
            _token: _token,
            feedback: content,
          },
          success: (res)=>{
            if (res.success) {
              let fbbox = document.querySelector('#fbbox');
              let fbmess = fbbox.querySelector('#fb-mess');
              if (fbmess) {
                fbmess.remove();
              }
              let newCmtString = `<div class="">
              <span class="block px-2 py-1 font-bold text-blue-500">${userInfo.name}</span>
              <p class="px-2">
                <i>${content}</i>
              </p>
            </div>`;
              fbbox.insertAdjacentHTML('afterbegin', newCmtString);
            }else {
              alert('chưa đăng nhập');
            }
            
          },
          error: (err)=>{
            console.log(err);
            alert('loi');
          }
        })
      })
      detailimgs.forEach(e=>{
        e.addEventListener('click', ()=>{
          let newMainSrc = e.src;
          mainImg.src=newMainSrc;
        })
      })
      addToCartBtn.addEventListener('click',()=>{
        if(!userInfo){
          alert('vui lòng đăng nhập');   
          return     
        }
        let p_id = document.querySelector('input[type="radio"][name="color"]:checked');
        if(!p_id){
          alert('vui lòng chọn màu sản phẩm');
          return
        }
        let _token = $('meta[name="csrf-token"]').attr('content');
        let count = parseInt(myCount.innerHTML);
        $.ajax({
                    url: "/callajax/addtocart",
                    type:"POST",
                    data:{
                        product_sale:p_id.value,
                        count:count,
                        user_id: userInfo.id,
                        _token: _token
                    },
                    success:function(response){
                        window.location.replace("/gio-hang");
                    },
                    error: function(error) {
                    console.log(error);
                    alert('xay ra loi');
                    }
                });
      });
      radioColor.forEach(cl=>{
            cl.addEventListener('change', ()=>{
              
              let discounts =parseInt( cl.getAttribute('discounts'));
              let newval = parseInt(cl.getAttribute('price'))*(100-discounts)/100;
              prePrice.innerHTML = newval.toLocaleString('it-IT', {style : 'currency', currency : 'VND'});
              if (discounts > 0) {
                priceSpan.classList.remove('hidden');
                priceSpan.innerHTML = parseInt(cl.getAttribute('price')).toLocaleString('it-IT', {style : 'currency', currency : 'VND'});
              }
            });
          })
      radioSize.forEach(e=>{
        e.addEventListener('change', ()=>{
          prePrice.innerHTML = '---';
          if (priceSpan) {
            priceSpan.classList.add('hidden');
          }
          radioColor.forEach(cl=>{
            cl.checked = false;
            if (e.value == cl.getAttribute('size')) {
              cl.classList.remove('hidden');
            }else{
              cl.classList.add('hidden');
            }
            
          })
        })
      })
      mp.addEventListener('click',()=>mpvpClick(pimage,vote,mp,vp));
      vp.addEventListener('click',()=>mpvpClick(vote,pimage,vp,mp));
  
      const mpvpClick = (div1,div2,btn1,btn2) => {
        if (div1.getAttribute('actived')) {
          return
        }
        if (div1.getAttribute('actived') == null){
          div1.setAttribute('actived',"");
          div1.classList.remove('hidden');
          div2.removeAttribute('actived');
          div2.classList.add('hidden');
          btn1.classList.add('border-b-2');
          btn2.classList.remove('border-b-2');
        }
      }
      detailBtn.addEventListener('click', ()=>{
        
        if(dcontent.classList.contains('hidden')){
          icon.className="fa-solid fa-caret-up";
          dcontent.classList.remove('hidden');

          return
        }
        if(!dcontent.classList.contains('hidden')){
          
          icon.className="fa-solid fa-sort-down";
          dcontent.classList.add('hidden');
          return
        }
      })
      desBtn.addEventListener('click', ()=>editCount(-1));
     function editCount(vl){
        let newCount = parseInt(myCount.innerHTML) + vl;
        myCount.innerHTML = newCount;
        if(newCount <= 1){
          desBtn.disabled = true;
        }else desBtn.disabled = false;
     }
    </script>
  </x-slot>
  <div class="container p-10">
    {{-- <span class="w-full block">
      <a href="#">áo</a>/
      <a href="#">áu thun</a>/
      <a href="#">len</a>
    </span> --}}
    <div class="flex">
      <div class="w-1/2 flex max-h-[600px] bg-black/80 gap-3 p-3">
        
        <div class="w-[calc(100%_-_60px)]">
          <img id="mainImg" src="{{url('public/images/'.$thisp->image)}}" alt="{{$thisp->name}}" class=" object-cover w-full h-full">
        </div>
        <div class="w-[60px] flex flex-col gap-3 items-center">
          <img class=" detailimg cursor-pointer w-full h-[70px] object-cover mb-2" src="{{url('public/images/'.$thisp->image)}}" alt="detail">
          @if (count($thisp->detailimg))
            @foreach ($thisp->detailimg as $img)
              @if(!$img->des)
              <img class="detailimg cursor-pointer w-full h-[70px] object-cover mb-2" src="{{url($img->image)}}" alt="detail">
              @endif
              
            @endforeach
          @endif
        </div>
      </div>
      <div id="productInfoBox" class="w-1/2 px-12">
        <span class="text-orange-700 first-letter:uppercase text-2xl font-bold block" >{{$thisp->name}}</span>
        <span class="text-gray-500 block mb-2">PID: {{$thisp->id}}</span>
        <span class="flex my-4">
          
          <span><i class="fa-solid fa-clipboard-list mr-2"></i><b>danh mục:</b> <b class="text-blue-500">{{$thisp->thiscate->name}}</b></span>
          <span class="ml-5"><i class="fa-solid fa-registered mr-2"></i><b>thương hiệu:</b> <b class="text-blue-500">{{$thisp->thisth->name}}</b></span>
          
        </span>
        <span class="text-black font-bold block"><i class="fa-solid fa-arrows-left-right mr-2"></i>kích thước:</span>
        <div class="flex gap-3 p-2"> 
          @foreach($listSize as $size)
            @if($thisp->allsalling[0]->size == $size)
              <span class="flex items-center"><input name="size" value="{{$size}}" type="radio" checked class="p-2 border min-w-[40px] text-center rounded-lg border-gray-500 mr-1"><b>{{$size}}</b></span>
            @else
              <span class="flex items-center"><input name="size" value="{{$size}}" type="radio" class="p-2 border min-w-[40px] text-center rounded-lg border-gray-500 mr-1"><b>{{$size}}</b></span>
            @endif
          @endforeach
        </div>
        <span class="text-black font-bold block"><i class="fa-solid fa-droplet mr-2"></i>màu sắc:</span>
        <div class="flex gap-3 p-2">
          
          @foreach($thisp->allsalling as $item)
            @if($item->size == $thisp->allsalling[0]->size)
              <input type="radio" value="{{$item->id}}" {{$item->price == $thisp->allsalling[0]->price ? 'checked' : ''}} name="color" size="{{$item->size}}" price="{{$item->price}}" discounts="{{$thisp->discounts}}" class="block p-2 border w-10 h-10 text-center rounded-full border-gray-500 checked:ring-4 checked:ring-orange-500" style="background:{{$item->color}}">
            @else
              <input type="radio" value="{{$item->id}}" {{$item->price == $thisp->allsalling[0]->price ? 'checked' : ''}} name="color" size="{{$item->size}}" price="{{$item->price}}" discounts="{{$thisp->discounts}}" class="hidden p-2 border w-10 h-10 text-center rounded-full border-gray-500 checked:ring-4 checked:ring-orange-500 disabled:opacity-20" style="background:{{$item->color}}">
            @endif
          @endforeach
        </div>
        <div class="flex items-center justify-center">
          <i class="fa-solid fa-money-bill-wave mr-2"></i>

          @if ($thisp->discounts > 0)
          <span class="px-2 py-1 text-yellow-400 font-bold">-{{$thisp->discounts}}%</span>
          @endif
          <div class="text-center w-[180px]">
            <span id="prePrice" class="text-orange-500 block text-xl mr-4 font-bold">{{number_format($thisp->allsalling[0]->price-$thisp->allsalling[0]->price*$thisp->discounts/100,0,'','.')}} VND</span>
            @if ($thisp->discounts > 0)
            <span id="priceSpan" class="text-red-500 {{$thisp->discounts>0 ? 'line-through text-sm' : 'text-xl '}} block mr-4 font-bold">{{number_format($thisp->allsalling[0]->price,0,'','.')}} VND</span>
            @endif
            
           
          </div>
          <x-editcount count="1"/>
        </div>
        
        {{-- <div class="flex w-full justify-center p-2">
          <button id="desBtn" class="w-10 h-10 text-center leading-10 bg-black font-bold text-white">-</button>
          <span id='myCount' class="w-10 h-10 leading-10 text-center border-none">1</span>
          <button id="insBtn" class="w-10 h-10 text-center leading-10 font-bold text-white bg-black">+</button>
        </div> --}}
        @if(Auth::check())
          <button class="w-full mt-5 p-2 text-center text-xl font-bold text-white bg-black">mua ngay</button>
          <button id="addToCartBtn" class="w-full mt-5 p-2 text-center text-xl font-bold text-black bg-white border border-black">thêm vào giỏ</button>
        @else
          <span class="text-red-500">bạn phải đăng nhập mới có thê mua hàng</span>
          <a href="/dang-nhap" class="block w-full mt-5 p-2 text-center text-xl font-bold text-white bg-black">đăng nhập</a>
          <a href="/dang-ky" class="block w-full mt-5 p-2 text-center text-xl font-bold text-black bg-gray-200">đăng ký</a>
          <button class="hidden w-full mt-5 p-2 text-center text-xl font-bold text-white bg-black">mua ngay</button>
          <button id="addToCartBtn" class="hidden w-full mt-5 p-2 text-center text-xl font-bold text-black bg-white border border-black">thêm vào giỏ</button>
          @endif
        <span class="text-black font-bold mt-5 block">mô tả sản phẩm <span id="detail" class=""><i class="fa-solid fa-sort-down"></i></span> </span>
        <p id="detail-content" open class="hidden text-sm">{{$thisp->des}}</p>
      </div>
    </div>
    <ul class="flex gap-3 font-bold text-xl px-10">
      <li id="mp" class="cursor-pointer py-2 border-b-2 mr-5"><i class="fa-solid fa-images mr-2"></i>hình ảnh sản phẩm</li>
      <li id="vp" class="cursor-pointer py-2"><i class="fa-solid fa-face-smile mr-2"></i>đánh giá sản phẩm</li>
    </ul>
    <div class="p-10">
      <div id="pimage" actived class="flex flex-col items-center">
        @if(count($thisp->detailimg)>0)
          @foreach($thisp->detailimg as $img)
            {{-- @if($img->des) --}}
              <img class="max-h-screen object-contain" src="{{URL($img->image)}}" alt="det">
            {{-- @endif --}}
          @endforeach
        @else
          <span class="block italic text-gray-400 ">không có hình ảnh mô tả sản phẩm</span>
        @endif
        
      </div>
      <div id="vote" class="hidden">
        <span class="font-bold text-xl"><i class="fa-solid fa-comment-dots mr-2"></i>đánh giá sản phẩm</span>
        <div class="w-1/2">
          @if (Auth::check())
            <textarea name="content" id="feedback" class="block resize-none w-full h-[100px] overflow-y-auto p-2" placeholder="để lại đánh giá của bạn"></textarea>
            <button id="sendFB" p-id="{{$thisp->id}}" class="px-2 py-1 bg-blue-500 text-white mt-2">gửi<i class="fa-solid fa-circle-right ml-2"></i></button>
          @else
            <span class="block text-gray-400">bạn cần <a href="/dang-nhap" class="text-blue-500 font-bold">đăng nhập</a> mới có thể đánh giá sản phẩm</span>
          @endif
          <hr class="my-2">
          <div id="fbbox" class="">
            @foreach($feedbacks as $feedback)
          <div class="">
            <span class="block px-2 py-1 font-bold text-blue-500">{{$feedback->thisuser->name}}</span>
            <p class="px-2">
              <i>{{$feedback->feedback}}</i>
            </p>
          </div>
          @endforeach
          @if (count($feedbacks)<=0)
            <span id="fb-mess" class='block italic text-gray-400'>chưa có đánh giá nào về sản phẩm này</span>
          @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</x-mainpage>