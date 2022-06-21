<div id="addTrademarkPopup" class="hidden w-screen h-screen fixed bg-black/40 top-0 left-0 justify-center items-center">
    <div class="w-[250px] bg-white shadow-md p-4 relative flex justify-center">
        <i id="closeTrademarkBtn" class="cursor-pointer fa-solid fa-rectangle-xmark absolute top-1 right-1 text-red-500 text-3xl"></i>
        <form action="" class="full">
            <label for="TDInput" class="font-bold">thương hiệu</label>
            <input id="TDInput" type="text" placeholder="nhập thương hiệu" class="w-full mt-2 text-md px-2 py-1 rounded-md placeholder:italic placeholder:text-gray-300"/>
            <label for="TDTH" class="font-bold">loại sản phẩm</label>
            <select name="TDTH" id="TDSelect" class="w-full px-2 py-1">
                <option value="" class=""></option>

                @foreach($allcate as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            <button id="callAddTrademarkBtn" class="px-2 py-1 bg-blue-400 text-white mt-4 rounded-sm">thêm</button>
            <button id="callEditTrademarkBtn" class="hidden px-2 py-1 bg-blue-400 text-white mt-4 rounded-sm">sửa</button>
        </form>
    </div>
</div>