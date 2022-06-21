<x-dashboard.adminlayout>
    <x-slot name="myjs">
        <script>
            const ulProduct = document.querySelector('#ulProduct');
            const productInput = document.querySelector('input[name="product"]');
            const bodydis = document.querySelector('#bodydis');
            const addFsBtn = document.querySelector('#addFsBtn');
            const titleInput = document.querySelector('input[name="title"]');
            const bannerinput = document.querySelector('input[name="banner"]');
            const startInput = document.querySelector('input[name="start"]');
            const endInput = document.querySelector('input[name="end"]');
            const preBanner = document.querySelector('#preBanner');
            bannerinput.addEventListener('change',(e)=>{
                if (e.target.files.length <= 0) {
                    return
                }
                let newsrc = window.URL.createObjectURL(e.target.files[0]);
                preBanner.innerHTML = '';
                const newimgString = `<div class = "flex w-full">
                        <div class="w-[120px]"></div>
                        <img src="${newsrc}" alt="preBanner" class="w-[calc(100%_-_120px)] h-[100px] object-cover">
                    </div>`;
                preBanner.insertAdjacentHTML('beforeend', newimgString);
            })

            let timer;
            
            addFsBtn.addEventListener('click', ()=>{
                let _token = $('meta[name="csrf-token"]').attr('content');
                let title = titleInput.value;
                let start = startInput.value;
                let end = endInput.value;
                let pdata = [];
                let all_product = document.querySelectorAll('.productRow input[name="discount"]');
                all_product.forEach(e=>{
                    pdata.push({
                        product_id: e.getAttribute('p-id'),
                        discount: e.value
                    })
                })
                let json_pdata = JSON.stringify(pdata);
                let formData = new FormData();
                formData.append('title',title);
                formData.append('start',start);
                formData.append('end',end);
                formData.append('pdata',json_pdata);
                formData.append('_token',_token);
                if (bannerinput.files.length > 0) {
                    formData.append('banner',bannerinput.files[0]);
                }
                
                $.ajax({
                    url: '/dashboard/callajax/fs/add', // <-- point to server-side PHP script 
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,                        
                    type: 'post',
                    success: (res)=>{
                        console.log(res);
                        if (res.success) {
                            alert('thêm thành công');
                        }
                    },
                    error: (error)=>{
                        alert('lôi');
                    }
                });
            })
            const debounce = function(fn, d) {
                if (timer) {
                    clearTimeout(timer);
                }

                timer = setTimeout(fn, d);
            }
            productInput.addEventListener('keyup', e=>{
                debounce(()=>getListProduct(e.target.value),1000);
            })
            const getListProduct = (text) => {
                let _token = $('meta[name="csrf-token"]').attr('content');
                if (text.length <= 0) {
                    ulProduct.innerHTML = '';
                    return
                }
                let pdata = [];
                let all_product = document.querySelectorAll('.productRow input[name="discount"]');
                all_product.forEach(e=>{
                    pdata.push(e.getAttribute('p-id'));
                })
                console.log(pdata);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': _token
                    },
                    url: "/callajax/getproductnotin/"+text,
                    type: "POST",
                    data: {
                        pids: JSON.stringify(pdata)
                    },
                    success: function(response) {
                        ulProduct.innerHTML = '';
                        response.forEach(e => {
                            let newli = document.createElement('li');
                            newli.className =
                                'flex w-full cursor-pointer hover:bg-blue-300 p-2 items-center'
                            let newImg = document.createElement('img');
                            newImg.src = public_path + '/' + e.image;
                            newImg.className = "w-[40px] h-[40px] ml-2 object-cover";
                            let newSpan = document.createElement('span');
                            newSpan.className = "block font-bold px-2";
                            newSpan.innerHTML = e.name;
                            newli.appendChild(newImg);
                            newli.appendChild(newSpan);
                            ulProduct.appendChild(newli);
                            newli.addEventListener('click', () => showMore(e));

                        })
                    },
                    error: function(error) {
                        console.log(error);
                        alert('xay ra loi');
                    }
                })
            }
            
            const showMore = (product) => {
                productInput.value='';
                ulProduct.innerHTML='';
                let publicimg = public_path + '/' + product.image;
                const newtdString = `
                        <tr class="productRow">
                                    <td>
                                        <div class="flex items-center">
                                            <img src="${publicimg}" class="w-[50px] h-[60px] object-cover">
                                            <span class="ml-2">${product.name}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <input p-id="${product.id}" name="discount" type="number" max="100" min="0" class="p-1 border-0 rounded-md shadow-inner" value="0">
                                    </td>
                                    <td>
                                        %
                                    </td>
                        </tr>
                `;
                bodydis.insertAdjacentHTML('beforeend', newtdString);
            }
            
        </script>
    </x-slot>
    <div class="w-full p-4">
        <span class="px-2 py-1 font-bold text-2xl block"><i class="fa-solid fa-plus mr-2"></i>tạo flash sale</span>
        <div class="mt-5">
            <div class="w-full p-10 max-w-[700px]">

                    <div class="mb-6 flex items-center">
                        <label for="title" class="block  font-medium text-gray-900 dark:text-gray-300 w-[120px]">tiêu
                            đề</label>
                        <input type="text" id="title" name="title"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[calc(100%_-_120px)] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            required>
                    </div>
                    <div class="mb-6 flex items-center">
                        <label for="image"
                            class="block font-medium text-gray-900 dark:text-gray-300 w-[120px]">banner</label>
                        <input name="banner"
                            class="block w-[calc(100%_-_120px)] text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            aria-describedby="user_avatar_help" id="banner" type="file">
                    </div>
                    <div id="preBanner" class="mb-6 flex">
                    </div>
                    <div date-rangepicker="" class="mb-6 flex items-center">
                        <label for="time" class="block font-medium text-gray-900 dark:text-gray-300 w-[120px]">thời
                            gian</label>
                        <div class="flex w-[calc(100%_-_120px)] items-center">
                            <div class="relative w-[calc(50%-24px)]">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input name="start" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 datepicker-input"
                                    placeholder="Select date start">
                            </div>
                            <span class="w-12 text-center text-gray-500">to</span>
                            <div class="relative w-[calc(50%-24px)]">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input name="end" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 datepicker-input"
                                    placeholder="Select date end">
                            </div>
                        </div>

                    </div>
                    <div class="mb-6 flex items-center relative">
                        <label for="product" class="block font-medium text-gray-900 dark:text-gray-300 w-[120px]">sản
                            phẩm</label>
                        <input type="text" id="product" name="product"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[calc(100%_-_120px)] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            >
                        <ul id="ulProduct"
                            class="absolute top-[50px] bg-slate-100 right-0 w-[calc(100%_-_120px)] bg-white">

                        </ul>
                    </div>
                    <div class="mb-6 flex">
                        <label for="discount" class="block font-medium text-gray-900 dark:text-gray-300 w-[120px]">giảm
                            giá</label>
                        <table class="table table-striped w-[calc(100%_-_120px)] text-sm">
                            <tr class="font-bold capitalize text-blue-500">
                                <td>sản phẩm</td>
                                <td>giảm giá</td>
                                <td>đơn vị</td>
                                </tr>
                                <tbody id="bodydis">
                                    
                                </tbody>
                        </table>
                    </div>
                    <div class="w-full flex justify-center"><button
                            class="my-4 px-3 py-1 text-white bg-green-400" id = "addFsBtn">thêm</button></div>

            </div>
        </div>
    </div>
</x-dashboard.adminlayout>
