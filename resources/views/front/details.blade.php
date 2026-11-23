@extends('layouts.master')
@section('title', ($houseDetails->name ?? 'Property Detail') . ' - Homi')
@section('content')
    <!-- Navigation Bar -->
    <x-nav-home />

    <div class="mt-[164px] flex flex-col gap-4 text-center items-center">
        <h1 class="font-bold text-4xl leading-[54px]">
            {{ $houseDetails->name }}
        </h1>
        <div class="flex items-center justify-center gap-5">
            <div class="flex items-center gap-[6px]">
                <img src="{{ asset('assets/images/icons/location.svg') }}" class="size-6 flex shrink-0" alt="location icon">
                <p class="font-semibold">
                    {{ $houseDetails->city?->name ?? 'Lokasi tidak tersedia' }}
                </p>
            </div>
            <div class="flex items-center gap-[6px]">
                <img src="{{ asset('assets/images/icons/security-user.svg') }}" class="size-6 flex shrink-0"
                    alt="certified icon">
                <p class="font-semibold">Certified Developer</p>
            </div>
        </div>
    </div>

    <section id="Gallery" class="flex gap-5 w-full max-w-[1280px] h-[450px] px-[75px] mt-[50px] mx-auto">
        <button type="button" data-image="{{ Storage::url($houseDetails->thumbnail) }}"
            class="show-modal-btn relative group flex w-full h-[450px] rounded-[30px] overflow-hidden">
            <img src="{{ Storage::url($houseDetails->thumbnail) }}" class="w-full h-full object-cover"
                alt="{{ $houseDetails->name }} thumbnail">
            <div
                class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 group-hover:opacity-100 transition-all duration-300">
                <img src="{{ asset('assets/images/icons/eye-white-fill.svg') }}" class="size-[50px]" alt="view icon">
            </div>
        </button>

        @if($houseDetails->photos && $houseDetails->photos->isNotEmpty())
            <div class="grid grid-cols-2 gap-5 w-[450px] shrink-0">
                @foreach($houseDetails->photos->take(4) as $photo)
                    <button type="button" data-image="{{ Storage::url($photo->photo) }}"
                        class="show-modal-btn relative group flex size-[215px] shrink-0 rounded-[22px] overflow-hidden">
                        <img src="{{ Storage::url($photo->photo) }}" class="w-full h-full object-cover"
                            alt="{{ $houseDetails->name }} detail">
                        <div
                            class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <img src="{{ asset('assets/images/icons/eye-white-fill.svg') }}" class="size-[50px]" alt="view icon">
                        </div>
                    </button>
                @endforeach
            </div>
        @endif
    </section>

    <section id="specs" class="w-full max-w-[1280px] px-[75px] mt-[30px] mx-auto">
        <div class="flex items-center justify-between rounded-[20px] border border-tedja-border py-5 px-[30px] bg-white">
            <div class="flex flex-col w-fit gap-3">
                <p class="text-sm text-tedja-secondary">Bedroom</p>
                <div class="flex items-center gap-[6px]">
                    <img src="{{ asset('assets/images/icons/slider-vertical.svg') }}" class="size-6 flex shrink-0"
                        alt="bedroom icon">
                    <p class="font-semibold">{{ $houseDetails->bedroom }} Bedroom</p>
                </div>
            </div>
            <div class="h-[60px] border border-tedja-border"></div>
            <div class="flex flex-col w-fit gap-3">
                <p class="text-sm text-tedja-secondary">Bathroom</p>
                <div class="flex items-center gap-[6px]">
                    <img src="{{ asset('assets/images/icons/slider-vertical.svg') }}" class="size-6 flex shrink-0"
                        alt="bathroom icon">
                    <p class="font-semibold">{{ $houseDetails->bathroom }} Bathroom</p>
                </div>
            </div>
            <div class="h-[60px] border border-tedja-border"></div>
            <div class="flex flex-col w-fit gap-3">
                <p class="text-sm text-tedja-secondary">Certificate</p>
                <div class="flex items-center gap-[6px]">
                    <img src="{{ asset('assets/images/icons/note-favorite.svg') }}" class="size-6 flex shrink-0"
                        alt="certificate icon">
                    <p class="font-semibold">{{ $houseDetails->certificate }}</p>
                </div>
            </div>
            <div class="h-[60px] border border-tedja-border"></div>
            <div class="flex flex-col w-fit gap-3">
                <p class="text-sm text-tedja-secondary">Land Area</p>
                <div class="flex items-center gap-[6px]">
                    <img src="{{ asset('assets/images/icons/maximize-3.svg') }}" class="size-6 flex shrink-0"
                        alt="land area icon">
                    <p class="font-semibold">{{ $houseDetails->land_area }} M²</p>
                </div>
            </div>
            <div class="h-[60px] border border-tedja-border"></div>
            <div class="flex flex-col w-fit gap-3">
                <p class="text-sm text-tedja-secondary">Building Area</p>
                <div class="flex items-center gap-[6px]">
                    <img src="{{ asset('assets/images/icons/building-3.svg') }}" class="size-6 flex shrink-0"
                        alt="building area icon">
                    <p class="font-semibold">{{ $houseDetails->building_area }} M²</p>
                </div>
            </div>
            <div class="h-[60px] border border-tedja-border"></div>
            <div class="flex flex-col w-fit gap-3">
                <p class="text-sm text-tedja-secondary">Electric Power</p>
                <div class="flex items-center gap-[6px]">
                    <img src="{{ asset('assets/images/icons/flash.svg') }}" class="size-6 flex shrink-0"
                        alt="electric icon">
                    <p class="font-semibold">{{ $houseDetails->electric }} Watt</p>
                </div>
            </div>
        </div>
    </section>

    <section id="Details" class="w-full flex gap-[30px] max-w-[1280px] px-[75px] my-[50px] mx-auto">
        <div class="flex flex-col gap-[30px] w-full">
            <div id="About" class="flex flex-col gap-[14px]">
                <h2 class="font-semibold text-[22px] leading-[33px]">About Project</h2>
                <p class="leading-8">{{ $houseDetails->about }}</p>
            </div>
            <div id="Nearby-Facilities" class="flex flex-col gap-[14px]">
                <h2 class="font-semibold text-[22px] leading-[33px]">Nearby Facilities</h2>
                <div class="grid grid-cols-4 gap-5">
                    <div class="flex flex-col min-h-[140px] rounded-[20px] border border-tedja-border p-5 gap-5 bg-white">
                        <img src="{{ asset('assets/images/icons/hospital-red.svg') }}" class="size-8 flex shrink-0"
                            alt="hospital icon">
                        <p class="font-semibold">Public Hospital</p>
                    </div>
                    <div class="flex flex-col min-h-[140px] rounded-[20px] border border-tedja-border p-5 gap-5 bg-white">
                        <img src="{{ asset('assets/images/icons/shop-orange.svg') }}" class="size-8 flex shrink-0"
                            alt="restaurant icon">
                        <p class="font-semibold">All Best Restaurants</p>
                    </div>
                    <div class="flex flex-col min-h-[140px] rounded-[20px] border border-tedja-border p-5 gap-5 bg-white">
                        <img src="{{ asset('assets/images/icons/security-user-purple.svg') }}" class="size-8 flex shrink-0"
                            alt="security icon">
                        <p class="font-semibold">Professional Securities</p>
                    </div>
                    <div class="flex flex-col min-h-[140px] rounded-[20px] border border-tedja-border p-5 gap-5 bg-white">
                        <img src="{{ asset('assets/images/icons/shopping-bag-green.svg') }}" class="size-8 flex shrink-0"
                            alt="mall icon">
                        <p class="font-semibold">Shopping Mall</p>
                    </div>
                    <div class="flex flex-col min-h-[140px] rounded-[20px] border border-tedja-border p-5 gap-5 bg-white">
                        <img src="{{ asset('assets/images/icons/cards-green.svg') }}" class="size-8 flex shrink-0"
                            alt="financial icon">
                        <p class="font-semibold">Financial Center</p>
                    </div>
                    <div class="flex flex-col min-h-[140px] rounded-[20px] border border-tedja-border p-5 gap-5 bg-white">
                        <img src="{{ asset('assets/images/icons/buildings-blue.svg') }}" class="size-8 flex shrink-0"
                            alt="business icon">
                        <p class="font-semibold">Central Business</p>
                    </div>
                    <div class="flex flex-col min-h-[140px] rounded-[20px] border border-tedja-border p-5 gap-5 bg-white">
                        <img src="{{ asset('assets/images/icons/book-cyan.svg') }}" class="size-8 flex shrink-0"
                            alt="school icon">
                        <p class="font-semibold">International Schools</p>
                    </div>
                </div>
            </div>
            <div id="Location" class="flex flex-col gap-[14px]">
                <h2 class="font-semibold text-[22px] leading-[33px]">Strategic Location</h2>
                <div class="overflow-hidden w-full h-[320px] rounded-[20px] border border-tedja-border">
                    <div id="my-map-display" class="h-full w-full max-w-none bg-none">
                        @if($houseDetails->city?->name && config('services.google_maps.key'))
                            <iframe class="h-full w-full border-0" loading="lazy" allowfullscreen
                                src="https://www.google.com/maps/embed/v1/place?q={{ urlencode($houseDetails->city->name) }}&key={{ config('services.google_maps.key') }}">
                            </iframe>
                        @else
                            <div class="flex items-center justify-center h-full bg-gray-100 text-tedja-secondary">
                                Peta lokasi tidak tersedia
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Kontak Agen / Pemilik -->
        <div class="flex flex-col w-[400px] shrink-0 h-fit rounded-[30px] border border-tedja-border p-5 gap-5 bg-white">
            <p class="font-bold text-[38px] leading-[57px] text-center text-tedja-blue">
                Rp {{ number_format($houseDetails->price ?? 0, 0, ',', '.') }}
            </p>
            <hr class="border-tedja-border">
            <!-- Profil Agen / Pemilik -->
            <div class="flex items-center gap-[14px] pb-4 border-b border-tedja-border">
                <div class="size-[60px] rounded-full overflow-hidden shrink-0 border border-tedja-border bg-gray-100">
                    @php
                        $agentPhoto = $houseDetails->user?->photo ?? $houseDetails->user?->avatar;
                    @endphp
                    @if($agentPhoto)
                        <img src="{{ Storage::url($agentPhoto) }}" class="w-full h-full object-cover"
                            alt="{{ $houseDetails->user->name }}">
                    @else
                        <!-- Fallback foto default jika user belum upload avatar -->
                        <img src="{{ asset('assets/images/icons/default-avatar.svg') }}" class="w-full h-full object-cover"
                            alt="Default Avatar">
                    @endif
                </div>
                <div class="flex flex-col gap-1">
                    <p class="font-bold text-lg leading-tight">
                        {{ $houseDetails->user?->name ?? 'Official Marketing' }}
                    </p>
                    <p class="text-sm text-tedja-secondary">
                        {{ $houseDetails->user?->role_label ?? 'Property Advisor' }}
                    </p>
                </div>
            </div>
            
            <!-- Kartu Tombol WhatsApp -->
            @php
                $waNumber = preg_replace('/[^0-9]/', '', $houseDetails->user?->phone ?? $houseDetails->Agent ?? '');
                if (str_starts_with($waNumber, '0')) {
                    $waNumber = '62' . substr($waNumber, 1);
                }
            @endphp
            <div
                class="group flex items-center justify-between rounded-[20px] ring-1 ring-tedja-border p-4 bg-white hover:ring-2 hover:ring-tedja-blue transition-all duration-300">
                <div class="flex items-center gap-[14px]">
                    <div class="flex items-center w-[71px] h-[50px] shrink-0 overflow-hidden">
                        <img src="{{ asset('assets/images/logos/logo-wa.svg') }}" class="w-full h-full object-contain"
                            alt="WhatsApp logo">
                    </div>
                    <div>
                        <p class="font-semibold">WhatsApp</p>
                        <p class="text-xs text-tedja-secondary">Fast Response</p>
                    </div>
                </div>
                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo ' . ($houseDetails->user?->name ?? '') . ', saya tertarik dengan properti ' . $houseDetails->name . ' (Rp ' . number_format($houseDetails->price ?? 0, 0, ',', '.') . '). Bisa info lebih lanjut?') }}"
                    target="_blank" rel="noopener noreferrer"
                    class="rounded-full py-[6px] px-3 bg-tedja-green font-semibold text-sm opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-300">
                    Chat WhatsApp
                </a>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div id="Gallery-Modal" class="fixed inset-0 items-center justify-center bg-tedja-black/50 flex z-30 hidden">
        <div id="Modal-Content" class="rounded-[50px] flex flex-col gap-5 py-[40px] px-5">
            <div class="flex max-w-[900px] max-h-[600px] overflow-hidden rounded-[20px]">
                <img id="Modal-Image" src="{{ Storage::url($houseDetails->thumbnail) }}"
                    class="object-contain max-h-[600px]" alt="Property Preview">
            </div>
            <button type="button" id="closeModal"
                class="px-5 mx-auto py-[14px] !w-fit bg-tedja-red rounded-full font-semibold text-white cursor-pointer">
                Close
            </button>
        </div>
    </div>
    <x-footer />
@endsection

@push('after-scripts')
    <script src="{{ asset('js/gallery.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
@endpush