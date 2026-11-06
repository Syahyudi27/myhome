@extends('layouts.master')
@section('title', 'Homi Home Page')
@section('content')
    <!-- Navigation Bar -->
    <x-nav-home />
    <!-- Header & Hero Search Section -->
    <header class="relative flex flex-col w-full h-[712px]">
        <div class="absolute w-full h-[650px] overflow-hidden">
            <img src="{{ asset('assets/images/backgrounds/hero-homi-image.webp') }}" class="w-full h-full object-cover"
                alt="hero image">
            <div class="absolute w-full h-full bg-tedja-black/10"></div>
        </div>

        <form action="{{ route('front.search') }}" method="GET"
            class="relative flex w-full max-w-[940px] rounded-xl p-5 gap-5 bg-white border border-tedja-border shadow-[0px_8px_30px_0px_#06092208] mx-auto mt-auto">
            <!-- Filter Lokasi -->
            <div class="flex flex-col w-full max-w-[241px] gap-2 h-[84px]">
                <p class="font-semibold">Lokasi</p>
                <label class="relative">
                    <select name="city" id="city_id"
                        class="appearance-none outline-none w-full rounded-xl ring-1 ring-tedja-black py-[14px] px-5 font-semibold invalid:font-normal focus:ring-2 focus:ring-tedja-blue transition-all duration-300"
                        required>
                        <option value="" hidden disabled selected>Pilih Lokasi</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <img src="{{ asset('assets/images/icons/arrow-down.svg') }}"
                        class="absolute size-5 transform -translate-y-1/2 top-1/2 right-5 pointer-events-none" alt="icon">
                </label>
            </div>

            <!-- Filter Kategori Properti -->
            <div class="flex flex-col w-full max-w-[232px] gap-2 h-[84px]">
                <p class="font-semibold">Property</p>
                <label class="relative">
                    <select name="category" id="category_id"
                        class="appearance-none outline-none w-full rounded-xl ring-1 ring-tedja-black py-[14px] px-5 font-semibold invalid:font-normal focus:ring-2 focus:ring-tedja-blue transition-all duration-300"
                        required>
                        <option value="" hidden disabled selected>Jenis Property</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <img src="{{ asset('assets/images/icons/arrow-down.svg') }}"
                        class="absolute size-5 transform -translate-y-1/2 top-1/2 right-5 pointer-events-none" alt="icon">
                </label>
            </div>

            <!-- Filter Tipe Listing -->
            <div class="flex flex-col w-full max-w-[227px] gap-2 h-[84px]">
                <p class="font-semibold">Dijual / Disewa</p>
                <label class="relative">
                    <select name="listing" id="listing_type"
                        class="appearance-none outline-none w-full rounded-xl ring-1 ring-tedja-black py-[14px] px-5 font-semibold invalid:font-normal focus:ring-2 focus:ring-tedja-blue transition-all duration-300"
                        required>
                        <option value="" hidden disabled selected>Dijual / Disewa</option>
                        @foreach ($listingtype as $listing)
                            <option value="{{ $listing->id }}">{{ $listing->name }}</option>
                        @endforeach
                    </select>
                    <img src="{{ asset('assets/images/icons/arrow-down.svg') }}"
                        class="absolute size-5 transform -translate-y-1/2 top-1/2 right-5 pointer-events-none" alt="icon">
                </label>
            </div>

            <button type="submit" class="group rounded-xl border py-[14px] px-5 flex items-center bg-tedja-blue2 mt-auto">
                <span class="font-semibold text-nowrap text-white">Cari Unit</span>
            </button>
        </form>
    </header>

    <!-- Popular Categories -->
    <section id="Popular-Categories" class="flex flex-col w-full mt-[70px] gap-[30px]">
        <div class="flex flex-col w-full max-w-[1280px] px-[75px] mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex flex-col gap-1">
                    <h2 class="font-bold text-[26px] leading-10">Popular Categories</h2>
                    <p>Temukan rumah sesuai kebutuhanmu</p>
                </div>
                <a href="#"
                    class="group rounded-full border border-tedja-black py-[14px] px-5 hover:bg-tedja-black flex items-center transition-all duration-300">
                    <span class="font-semibold group-hover:text-white transition-all duration-300">Explore All</span>
                </a>
            </div>
        </div>
        <div class="swiper w-full overflow-x-hidden">
            <div class="swiper-wrapper">
                @forelse ($categories as $category)
                    <div
                        class="swiper-slide !w-fit py-0.5 first-of-type:pl-[calc(((100%-1280px)/2)+75px)] last-of-type:pr-[calc(((100%-1280px)/2)+75px)]">
                        <a href="{{ route('front.category', $category->slug) }}" class="card">
                            <div
                                class="flex flex-col w-[240px] shrink-0 rounded-[30px] ring-1 ring-tedja-border bg-white p-[10px] gap-4 hover:ring-2 hover:ring-tedja-blue transition-all duration-300">
                                <div class="flex w-full h-[240px] overflow-hidden rounded-[30px]">
                                    <img src="{{ Storage::disk('public')->url($category->photo) }}"
                                        class="w-full h-full object-cover" alt="thumbnails">
                                </div>
                                <div class="flex flex-col gap-2 pb-[10px] pl-[10px]">
                                    <h3 class="font-bold text-lg">{{ $category->name }}</h3>
                                    <div class="flex items-center gap-[6px]">
                                        <img src="{{ asset('assets/images/icons/house-2.svg') }}" class="size-5 flex shrink-0"
                                            alt="icon">
                                        <p class="font-semibold text-sm">{{ $category->houses->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="px-[75px]">Belum ada kategori yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="Testimonials" class="flex flex-col w-full max-w-[1280px] px-[135px] gap-[31px] mx-auto my-[70px]">
        <div class="flex flex-col gap-1 text-center">
            <h2 class="font-bold text-[26px] leading-10">Happy Families</h2>
            <p>Kami hadir membuatmu bahagia</p>
        </div>
        <div id="Slider-Container" class="relative flex gap-[30px] w-[1010px] h-[650px] shrink-0 overflow-hidden">
            <div
                class="gradient absolute z-10 top-0 w-full h-[186px] bg-[linear-gradient(180deg,rgba(250,250,250,0)_0%,#FAFAFA_100%)] rotate-180">
            </div>
            <div
                class="gradient absolute z-10 bottom-0 w-full h-[100px] bg-[linear-gradient(180deg,rgba(250,250,250,0)_0%,#FAFAFA_100%)]">
            </div>
            <div class="slider slide-up w-[230px] h-max flex flex-col flex-nowrap shrink-0">
                <div class="h-max">
                    <div class="content flex flex-col gap-[30px] pt-[30px]">
                        <div
                            class="testimonial-card flex flex-col w-full rounded-[30px] border border-tedja-border bg-white p-4 gap-[14px]">
                            <div class="flex">
                                @for ($i = 0; $i < 5; $i++)
                                    <img src="{{ asset('assets/images/icons/Star 1.svg') }}" class="flex shrink-0" alt="star">
                                @endfor
                            </div>
                            <p class="font-semibold leading-[28px]">Awalnya takut dibawa kabur duitnya lalu dicoba kok malah
                                puas banget pokoknya mas</p>
                            <div class="flex items-center gap-[14px]">
                                <div class="flex size-[60px] rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/images/photos/profile.png') }}"
                                        class="w-full h-full object-cover" alt="photo profile">
                                </div>
                                <div>
                                    <p class="font-semibold">Sarina Dwi</p>
                                    <p class="text-sm text-tedja-secondary">House Designer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('after-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css">
@endpush

@push('after-scipts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/home.js') }}"></script>
@endpush