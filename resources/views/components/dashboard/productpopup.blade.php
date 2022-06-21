<div id="addProductPopup" class="hidden w-screen h-screen fixed bg-black/40 top-0 left-0 justify-center items-center">
    <div class="w-[700px] bg-white shadow-md p-4 relative flex justify-center">
        <i id="closeProductBtn" class="cursor-pointer fa-solid fa-rectangle-xmark absolute top-1 right-1 text-red-500 text-3xl"></i>
        <form action="" class="w-full p-4">
            <label for="productname" class="font-bold">sản phẩm</label>
            <input type="text" placeholder="nhập thương hiệu" class="w-full mt-2 text-md px-2 py-1 rounded-md placeholder:italic placeholder:text-gray-300"/>
            <label for="productdes" class="font-bold block">mô tả</label>
            <textarea name="productdes" class="p-1 w-full h-[200px] resize-none overflow-y-auto"></textarea>
            <label for="price">đơn giá (vnđ)</label>
            <input name="price" type="text" class="w-full mt-2 text-md px-2 py-1 rounded-md placeholder:italic placeholder:text-gray-300" placeholder="nhập vào đơn giá"/>
            <label for="image" class="block font-bold">hình ảnh</label>
            <button class="px-2 py-1 bg-blue-400 text-white mt-4 rounded-sm">thêm</button>
        </form>
    </div>
</div>