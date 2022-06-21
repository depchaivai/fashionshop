<div id="addCatePopup" class="z-40 hidden w-screen h-screen bg-black/40 fixed top-0 left-0 justify-center items-center">
    <div class="w-[250px] bg-white shadow-md p-4 relative flex justify-center">
        <i id="closeCateBtn" class="cursor-pointer fa-solid fa-rectangle-xmark absolute top-1 right-1 text-red-500 text-3xl"></i>
        <form action="" method="post" class="full">
            <label for="cateName" class="font-bold">danh mục</label>
            <input id="cateName" type="text" name="catename" placeholder="nhập vào danh mục mới" class="w-full mt-2 text-md px-2 py-1 rounded-md placeholder:italic placeholder:text-gray-300"/>
            <label for="parent" class="font-bold mt-3 block">danh mục con của</label>
            <select id="cateParent" name="parent" id="parentCateSelect" class="px-2 py-1 block w-full">
                <option value="0">danh mục gốc</option>
                @foreach($allcate as $item)
                    @if($item->parent == 0)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endif
                @endforeach
            </select>
            <button id="callAddCateBtn" class="px-2 py-1 bg-blue-400 text-white mt-4 rounded-sm">thêm</button>
            <button id="callEditCateBtn" class="px-2 py-1 hidden bg-blue-400 text-white mt-4 rounded-sm">sửa</button>
        </form>
    </div>
</div>