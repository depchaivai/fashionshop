<x-mainpage>
    <x-slot name="myjs">
        <script>
            const flashsaleClock = document.querySelectorAll('.clocker');
            flashsaleClock.forEach(e => {
                let txtday = e.querySelector('div[x-text="days"]');
                let txthour = e.querySelector('div[x-text="hours"]');
                let txtminute = e.querySelector('div[x-text="minutes"]');
                let txtsecond = e.querySelector('div[x-text="seconds"]');
                let txtstatus = e.querySelector('span.status');
                let expire_day = e.getAttribute('expire');
                let from_day = e.getAttribute('from');
                let from_time = new Date(from_day).getTime();
                let expire_time = new Date(expire_day).getTime();
                let x = setInterval(function() {

                    // Get today's date and time
                    let now = new Date().getTime();
                    let distance = 0;
                    // Find the distance between now and the count down date
                    if (from_time > now) {
                        distance = from_time - now;
                        txtstatus.innerHTML = 'sắp diễn ra';
                    } else if (expire_time > now) {
                        distance = expire_time - now;
                        txtstatus.innerHTML = 'đang diễn ra';

                    }


                    // Time calculations for days, hours, minutes and seconds
                    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Display the result in the element with id="demo"
                    txtday.innerHTML = addZero(days);
                    txthour.innerHTML = addZero(hours);
                    txtminute.innerHTML = addZero(minutes);
                    txtsecond.innerHTML = addZero(seconds);

                    // If the count down is finished, write some text
                    if (distance < 0) {
                        clearInterval(x);
                        txtday.innerHTML = '00';
                        txthour.innerHTML = '00';
                        txtminute.innerHTML = '00';
                        txtsecond.innerHTML = '00';
                        window.location.reload();
                    }
                }, 1000);
            })
            const addZero = (num) => {
                if (parseInt(num) < 10) {
                    return `0${num}`;
                }
                return num;
            }
        </script>
    </x-slot>
    <div class="container">
        <div id="controls-carousel" class="relative" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="overflow-hidden relative pt-[35%] rounded-lg  ">
                <!-- Item 1 -->

                @foreach ($slides as $slide)
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ URL($slide->image) }}"
                            class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2" alt="...">
                    </div>
                @endforeach

            </div>
            <!-- Slider controls -->
            <button type="button"
                class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex justify-center items-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    <span class="hidden">Previous</span>
                </span>
            </button>
            <button type="button"
                class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex justify-center items-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="hidden">Next</span>
                </span>
            </button>
        </div>


        <div class="p">
            <span class="text-xl uppercase block py-1 px-2 font-bold mt-5">sản phẩm mới</span>
            <div class="grid grid-cols-5 gap-3 py-4">
                @foreach ($newps as $item)
                    <x-card :item="$item" />
                @endforeach
            </div>
        </div>
        @if(count($discountsp) > 0)
        <div class="p">
            <span class="text-xl uppercase block py-1 px-2 font-bold mt-5">đang giảm giá</span>
            <div class="grid grid-cols-5 gap-3 py-4">
                @foreach ($discountsp as $item)
                    <x-card :item="$item" />
                @endforeach
            </div>
        </div>
        @endif
        @foreach ($flashsales as $fs)
            @if ($fs->expire_day > Carbon\Carbon::now())
                <div class="clocker text-yellow-100 mb-5 " from="{{ $fs->from }}"
                    expire="{{ $fs->expire_day }}">
                    <div class=" h-full relative">

                        <img src="{{ URL($fs->banner) }}" alt="{{ $fs->title }}"
                            class="w-full h-[300px] object-cover">
                        <div class="absolute top-0 left-0 w-full py-4 bg-black/80 h-[300px]">
                            <span
                                class="text-3xl uppercase text-center mb-3 font-extralight block">{{ $fs->title }}</span>
                            <span class="status text-xl text-center mb-3 font-extralight block"></span>
                            
                            <span class="text-xl block text-center mb-3 font-extralight">từ ngày <b
                                    class="text-orange-500">{{ $fs->from }}</b> đến ngày <b
                                    class="text-orange-500">{{ $fs->expire_day }}</b></span>
                            <div class="text-6xl text-center flex w-full items-center justify-center">
                                <div class="text-2xl mr-1 font-extralight">in</div>
                                <div class="min-w-24 mx-1 p-2 bg-white text-yellow-500 rounded-lg">
                                    <div class="font-mono leading-none" x-text="days">00</div>
                                    <div class="font-mono uppercase text-sm leading-none">Days</div>
                                </div>
                                <div class="w-24 mx-1 p-2 bg-white text-yellow-500 rounded-lg">
                                    <div class="font-mono leading-none" x-text="hours">00</div>
                                    <div class="font-mono uppercase text-sm leading-none">Hours</div>
                                </div>
                                <div class="w-24 mx-1 p-2 bg-white text-yellow-500 rounded-lg">
                                    <div class="font-mono leading-none" x-text="minutes">00</div>
                                    <div class="font-mono uppercase text-sm leading-none">Minutes</div>
                                </div>
                                <div class="text-2xl mx-1 font-extralight">and</div>
                                <div class="w-24 mx-1 p-2 bg-white text-yellow-500 rounded-lg">
                                    <div class="font-mono leading-none" x-text="seconds">00</div>
                                    <div class="font-mono uppercase text-sm leading-none">Seconds</div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    @if (Carbon\Carbon::now('Asia/Ho_Chi_Minh') > $fs->from)
                        <div class="grid grid-cols-5 gap-3 py-4 text-black">
                            @foreach ($fs->allsale as $item)
                                <x-flashsalecard :discounts="$item->discount" :item="$item->product" />
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
    </div>

</x-mainpage>
