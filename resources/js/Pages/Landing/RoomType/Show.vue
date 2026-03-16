<template>
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">{{ $t('front.room_details.title') }}</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><Link :href="route('home')">{{ $t('front.header.home') }}</Link></li>
                    <li><Link :href="route('roomTypes.index')">{{ $t('front.rooms.title') }}</Link></li>
                    <li class="current">{{ $t('front.room_details.title') }}</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Room Details Section -->
    <section id="room-details" class="room-details section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <!-- Room Header with Image and Basic Info -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-7" data-aos="fade-right" data-aos-delay="200">
                    <div class="room-header-image">
                        <img :src="roomType.mainImage[0].url" :alt="roomType.name" class="img-fluid rounded">
                        <div class="room-badge">
                            <span class="text-white">{{ roomType.view }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" data-aos="fade-left" data-aos-delay="300">
                    <div class="room-header-content">
                        <div class="room-rating mb-3">
                            <span class="rating-score">4.8</span>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <span class="reviews-count">({{ $t('front.booking.reviews', { count: 127 }) }})</span>
                        </div>
                        <h1 class="room-title">{{ roomType.name}}</h1>
                        <p class="room-tagline" v-html="roomType.short_description"></p>
                        <div class="room-capacity mb-4">
                            <div class="capacity-item">
                                <i class="bi bi-people"></i>
                                <span>{{ $t('front.booking.up_to_guests', { count: roomType.max_total_guests }) }}</span>
                            </div>
                            <div class="capacity-item">
                                <i class="bi bi-grid"></i>
                                <span>{{ roomType.size }} m²</span>
                            </div>
                            <div class="capacity-item">
                                <i class="bi bi-house"></i>
                                <span v-text="roomType.bedTypes.map(rt => rt.name).join(' + ')"></span>
                            </div>
                        </div>
                        <div class="room-price">
                            <span class="price-amount">{{ money_format(roomType.price) }}</span>
                            <span class="price-period">{{ $t('front.room_details.per_night') }}</span>
                        </div>
                        <Link :href="route('bookings.create', {filters, roomType: roomType.slug})" class="btn btn-book-now">{{ $t('front.room_details.book_now') }}</Link>
                    </div>
                </div>
            </div>

            <!-- Room Gallery -->
            <div class="room-gallery mb-5" v-if="roomType.gallery">
                <h3 class="section-subtitle mb-4" >{{ $t('front.room_details.gallery') }}</h3>
                <div class="gallery-carousel swiper init-swiper" data-aos="fade-up" data-aos-delay="200">
                    <swiper
                        :slides-per-view="1"
                        :space-between="20"
                        loop
                        :autoplay="{'delay': 3000 }"
                        centered-slides
                        :speed="600"
                        :breakpoints="{
                        '576': {
                        'slidesPerView': 2,
                        'centeredSlides': false
                        },
                        '768': {
                        'slidesPerView': 3,
                        'centeredSlides': false
                        },
                        '992': {
                        'slidesPerView': 4,
                        'centeredSlides': false
                        },
                        '1200': {
                        'slidesPerView': 4,
                        'centeredSlides': false
                        }
                    }">
                        <swiper-slide class="swiper-slide" v-for="(gallery, index) in roomType.gallery">
                            <div class="gallery-item">
                                <a :href="gallery.url"
                                   class="gallery-overlay glightbox"
                                   :data-gallery="`room-gallery-${roomType.id}`"
                                   :data-glightbox="`title: Image ${index + 1}`">
                                    <img :src="getMediaUrl(gallery, 'set')" :alt="roomType.name" class="img-fluid"
                                         loading="lazy">
                                </a>
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>

            <!-- Room Description -->
            <div class="row mb-5">
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="room-description" v-html="roomType.description">
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="highlight-box">
                        <div class="highlight-icon">
                            <i class="bi bi-star"></i>
                        </div>
                        <h4>{{ $t('front.room_details.premium_experience') }}</h4>
                        <p>"The most beautiful suite we've ever stayed in. The ocean view is absolutely breathtaking and the attention to detail is remarkable."</p>
                        <div class="quote-author">
                            <span>- Sarah M., Verified Guest</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amenities and Features -->
            <div class="room-amenities mb-5" data-aos="fade-up" data-aos-delay="200">
                <h3 class="section-subtitle mb-4">{{ $t('front.room_details.amenities') }}</h3>
                <div class="grid gap-5" style="--bs-columns: 3;">
                    <div class="g-col-3 w-full" v-for="facility in roomType.facilities">
                        <i class="bi bi-check2 text-success me-1" style="font-size: 18px" />
                        <span>{{ facility.name }}</span>
                    </div>
                </div>
            </div>

            <!-- Tabbed Information -->
            <div class="room-tabs mb-5" data-aos="fade-up" data-aos-delay="200">
                <ul class="nav nav-tabs" id="room-detailsRoomTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="room-details-policies-tab" data-bs-toggle="tab" data-bs-target="#room-details-policies" type="button" role="tab">{{ $t('front.room_details.tabs.policies') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="room-details-location-tab" data-bs-toggle="tab" data-bs-target="#room-details-location" type="button" role="tab">{{ $t('front.room_details.tabs.location') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="room-details-services-tab" data-bs-toggle="tab" data-bs-target="#room-details-services" type="button" role="tab">{{ $t('front.room_details.tabs.services') }}</button>
                    </li>
                </ul>
                <div class="tab-content" id="room-detailsRoomTabsContent">
                    <div class="tab-pane fade show active" id="room-details-policies" role="tabpanel">
                        <div class="tab-content-wrapper">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6>{{ $t('front.room_details.tabs.check_in_out') }}</h6>
                                    <p>{{ $t('front.room_details.tabs.check_in_time') }}<br>{{ $t('front.room_details.tabs.check_out_time') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6>{{ $t('front.room_details.tabs.cancellation') }}</h6>
                                    <p>{{ $t('front.room_details.tabs.cancellation_policy') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6>{{ $t('front.room_details.tabs.pets') }}</h6>
                                    <p>{{ $t('front.room_details.tabs.pets_policy') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="room-details-location" role="tabpanel">
                        <div class="tab-content-wrapper">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ $t('front.room_details.tabs.nearby_attractions') }}</h6>
                                    <ul>
                                        <li>{{ $t('front.room_details.tabs.attractions_list.beach') }}</li>
                                        <li>{{ $t('front.room_details.tabs.attractions_list.marina') }}</li>
                                        <li>{{ $t('front.room_details.tabs.attractions_list.historic') }}</li>
                                        <li>{{ $t('front.room_details.tabs.attractions_list.shopping') }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ $t('front.room_details.tabs.transportation') }}</h6>
                                    <ul>
                                        <li>{{ $t('front.room_details.tabs.transport_list.shuttle') }}</li>
                                        <li>{{ $t('front.room_details.tabs.transport_list.parking') }}</li>
                                        <li>{{ $t('front.room_details.tabs.transport_list.public') }}</li>
                                        <li>{{ $t('front.room_details.tabs.transport_list.rental') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="room-details-services" role="tabpanel">
                        <div class="tab-content-wrapper">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6>{{ $t('front.room_details.tabs.concierge') }}</h6>
                                    <p>{{ $t('front.room_details.tabs.concierge_desc') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6>{{ $t('front.room_details.tabs.room_service') }}</h6>
                                    <p>{{ $t('front.room_details.tabs.room_service_desc') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6>{{ $t('front.room_details.tabs.housekeeping') }}</h6>
                                    <p>{{ $t('front.room_details.tabs.housekeeping_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Booking CTA -->
            <div class="booking-cta" data-aos="fade-up" data-aos-delay="200">
                <div class="booking-card">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h4>{{ $t('front.room_details.cta_title') }}</h4>
                            <p>{{ $t('front.room_details.cta_desc') }}</p>
                        </div>
                        <div class="col-lg-4 text-center text-lg-end">
                            <div class="price-display">
                                <span class="price">{{ money_format(roomType.price) }}</span>
                                <span class="period">{{ $t('front.room_details.per_night') }}</span>
                            </div>
                            <Link :href="route('bookings.create', {filters, roomType: roomType.slug})" class="btn btn-primary btn-lg">{{ $t('front.room_details.check_availability') }}</Link>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section><!-- /Room Details Section -->
</template>

<script setup>
import {Swiper, SwiperSlide} from "swiper/vue";
import {getMediaUrl, money_format} from "../../../Utils/helper.js";
import {onMounted, onUpdated} from "vue";
import GLightbox from "glightbox";
import 'glightbox/dist/css/glightbox.min.css'


defineProps({
    roomType: Object,
    filters: Object,
})
let lightbox = null;
onMounted(() => {
    // initialize glightbox once
    lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        autoplayVideos: false,
    })
})

// if swiper re-renders (e.g. reactive update)
onUpdated(() => {
    lightbox.reload()
})
</script>
