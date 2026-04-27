<template>
    <!-- Hotel Hero Section -->
    <section id="hotel-hero" class="hotel-hero section hotel-hero-bg">
        <div class="hero-content w-full">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <div class="hero-text aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                            <h1 class="text-white">{{ $t('front.home.hero_title') }}</h1>
                            <p class="hero-subtitle text-white">{{ $t('front.home.hero_subtitle') }}</p>
                            <div class="hero-actions aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                                <Link :href="route('roomTypes.index')" class="btn btn-origin p-5 py-3 mx-3" style="border-radius: 50px !important;">{{ $t('front.home.book_stay') }}</Link>
                                <Link :href="route('amenities')" class="btn btn-outline-light p-5 py-3" style="border-radius: 50px">{{ $t('front.home.explore_amenities') }}</Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-5">
                    <div class="col-lg-10">
                        <div class="booking-card aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                            <form class="booking-form php-email-form" @submit.prevent="submitForm" method="get">
                                <div class="row align-items-end g-3">
                                    <div class="col-md-3">
                                        <label for="checkin" class="form-label">{{ $t('front.home.check_in') }}</label>
                                        <input type="date" v-model="form.check_in" class="form-control" id="checkin" :min="currentDate()"
                                               required="">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="checkout" class="form-label">{{ $t('front.home.check_out') }}</label>
                                        <input type="date" v-model="form.check_out" class="form-control" id="checkout" :min="addDays(Date.now(), 1)"
                                               required="">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="guests" class="form-label">{{ $t('front.home.guests') }}</label>
                                        <div class="border bg-white rounded px-4 position-relative cursor-pointer" style="padding: 0.75rem;">
                                            <div class="d-flex justify-content-between flex-grow-1" @click="showGuests = !showGuests">
                                                <i class="bi bi-people-fill"
                                                   style="font-size: 1rem;font-weight: 400;line-height: 1.5;color: #6e7174;">
                                                </i>
                                                <div>
                                                    {{form.adults}} {{ $t('front.home.adults') }}
                                                </div>
                                                <div>
                                                    {{form.children}} {{ $t('front.home.children') }}
                                                </div>
                                                <div>
                                                    {{form.rooms}} {{ $t('front.home.room') }}
                                                </div>
                                                <i class="bi bi-chevron-down mt-1" style="font-size: 13px;font-weight: 700;line-height: 1.2;"></i>
                                            </div>
                                            <div class="border shadow position-absolute w-full bg-white rounded p-4 d-flex flex-column gap-3"
                                                 style="left: 0; top: 53px;" v-if="showGuests">
                                                <div>
                                                    <label for="adults" class="form-label">{{ $t('front.home.adults') }}</label>
                                                    <input type="number" min="1" v-model="form.adults" class="form-control" id="adults" required="">
                                                </div>
                                                <div>
                                                    <label for="children" class="form-label">{{ $t('front.home.children') }}</label>
                                                    <input type="number" min="0" v-model="form.children" class="form-control" id="children" required="">
                                                </div>
                                                <div>
                                                    <label for="room" class="form-label">{{ $t('front.home.room') }}</label>
                                                    <input type="number" min="1" v-model="form.rooms" class="form-control" id="room" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-origin">
                                            <i class="bi bi-search"></i>
                                            <span class="mx-2">{{ $t('front.home.search') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-4">
                    <div class="col-lg-10">
                        <div class="hotel-highlights aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                            <div class="row text-center">
                                <div class="col-6 col-md-3">
                                    <div class="highlight-item">
                                        <i class="bi bi-wifi"></i>
                                        <div>{{ $t('front.home.free_wifi') }}</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="highlight-item">
                                        <i class="bi bi-p-circle"></i>
                                        <div>{{ $t('front.home.free_parking') }}</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="highlight-item">
                                        <i class="bi bi-cup-hot"></i>
                                        <div>{{ $t('front.home.room_service') }}</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="highlight-item">
                                        <i class="bi bi-water"></i>
                                        <div>{{ $t('front.home.swimming_pool') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section><!-- /Hotel Hero Section -->


    <!-- About Home Section -->
    <section id="about-home" class="about-home section light-background">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4 align-items-center">

                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                    <div class="about-content">
                        <h2>{{ $t('front.home.welcome_title') }}</h2>
                        <p class="lead">{{ $t('front.home.welcome_subtitle') }}</p>
                        <p>{{ $t('front.home.welcome_p1') }}</p>
                        <p>{{ $t('front.home.welcome_p2') }}</p>

                        <div class="stats-row">
                            <div class="stat-item">
                                <div class="stat-number">240</div>
                                <div class="stat-label">{{ $t('front.home.luxury_rooms') }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">99%</div>
                                <div class="stat-label">{{ $t('front.home.guest_satisfaction') }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">37</div>
                                <div class="stat-label">{{ $t('front.home.years_experience') }}</div>
                            </div>
                        </div><!-- End Stats Row -->

                        <div class="about-actions">
                            <Link :href="route('about')" class="btn-primary">{{ $t('front.home.our_story') }}</Link>
                            <Link :href="route('roomTypes.index')" class="btn-secondary">{{ $t('front.home.view_rooms') }}</Link>
                        </div>
                    </div>
                </div><!-- End About Content -->

                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <div class="about-images">
                        <div class="main-image">
                            <img src="/resources/images/showcase-8.webp" alt="Elite Booking — Vue Principale"
                                 class="img-fluid">
                        </div>
                        <div class="secondary-image">
                            <img src="/resources/images/room-12.webp" alt="Suite de Luxe Elite Booking" class="img-fluid">
                        </div>
                        <div class="experience-badge">
                            <div class="badge-content">
                                <span class="badge-number">37+</span>
                                <span class="badge-text" v-html="$t('front.home.years_experience').replace(' ', '<br>')"></span>
                            </div>
                        </div>
                    </div>
                </div><!-- End About Images -->

            </div>

        </div>

    </section><!-- /About Home Section -->


    <!-- Rooms Showcase Section -->
    <section id="rooms-showcase" class="rooms-showcase section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <span class="description-title">{{ $t('front.home.rooms_title') }}</span>
            <h2>{{ $t('front.home.rooms_title') }}</h2>
            <p>{{ $t('front.home.rooms_desc') }}</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-3">
                <a class="col-lg-3 col-sm-6 d-inline-block" :href="route('roomTypes.show', roomType.slug)" v-for="roomType in roomTypes">
                    <div class="minimal-room-card">
                        <div class="room-image">
                            <img :src="roomType.mainImage[0]?.url" alt="Classic Room" class="img-fluid">
                            <div class="hover-overlay">
                                <a href="room-details.html" class="view-room">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="room-summary">
                            <h5>{{ roomType.name}}</h5>
                            <div class="price-tag">{{ money_format(roomType.price) }}<span>{{ $t('front.home.per_night') }}</span></div>
                            <div class="basic-amenities">
                                <i class="bi bi-wifi"></i>
                                <i class="bi bi-tv"></i>
                                <i class="bi bi-telephone"></i>
                            </div>
                        </div>
                    </div>
                </a><!-- End Minimal Room -->
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="600">
                <Link :href="route('roomTypes.index')" class="explore-all-link">
                    <span>{{ $t('front.home.explore_all') }}</span>
                    <i class="bi bi-arrow-right"></i>
                </Link>
            </div>

        </div>

    </section><!-- /Rooms Showcase Section -->

    <!-- Amenities Cards Section -->
    <section id="amenities-cards" class="amenities-cards section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <span class="description-title">{{ $t('front.home.amenities_title') }}</span>
            <h2>{{ $t('front.home.amenities_title') }}</h2>
            <p>{{ $t('front.home.amenities_desc') }}</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-5">

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="/resources/images/showcase-8.webp" alt="Wireless Internet" class="img-fluid">
                            <div class="facility-overlay">
                                <i class="bi bi-wifi"></i>
                            </div>
                        </div>
                        <div class="facility-info">
                            <h4>{{ $t('front.home.high_speed_internet') }}</h4>
                            <p>{{ $t('front.home.high_speed_internet_desc') }}</p>
                            <div class="facility-features">
                                <span><i class="bi bi-check-circle"></i> {{ $t('front.home.available_24_7') }}</span>
                                <span><i class="bi bi-check-circle"></i> {{ $t('front.home.high_speed') }}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Facility Card -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="150">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="/resources/images/showcase-8.webp" alt="Swimming Pool" class="img-fluid">
                            <div class="facility-overlay">
                                <i class="bi bi-droplet"></i>
                            </div>
                        </div>
                        <div class="facility-info">
                            <h4>{{ $t('front.home.rooftop_pool') }}</h4>
                            <p>{{ $t('front.home.rooftop_pool_desc') }}</p>
                            <div class="facility-features">
                                <span><i class="bi bi-check-circle"></i> {{ $t('front.home.heated_pool') }}</span>
                                <span><i class="bi bi-check-circle"></i> {{ $t('front.home.city_views') }}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Facility Card -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="/resources/images/showcase-8.webp" alt="Valet Parking" class="img-fluid">
                            <div class="facility-overlay">
                                <i class="bi bi-car-front"></i>
                            </div>
                        </div>
                        <div class="facility-info">
                            <h4>{{ $t('front.home.valet_parking') }}</h4>
                            <p>{{ $t('front.home.valet_parking_desc') }}</p>
                            <div class="facility-features">
                                <span><i class="bi bi-check-circle"></i> {{ $t('front.home.secure') }}</span>
                                <span><i class="bi bi-check-circle"></i> {{ $t('front.home.valet_service') }}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Facility Card -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="/resources/images/showcase-8.webp" alt="Fitness Center" class="img-fluid">
                            <div class="facility-overlay">
                                <i class="bi bi-heart-pulse"></i>
                            </div>
                        </div>
                        <div class="facility-info">
                            <h4>{{ $t('front.home.fitness_center') }}</h4>
                            <p>{{ $t('front.home.fitness_center_desc') }}</p>
                            <div class="facility-features">
                                <span><i class="bi bi-check-circle"></i> {{ $t('front.home.access_24_7') }}</span>
                                <span><i class="bi bi-check-circle"></i> {{ $t('front.home.personal_training') }}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Facility Card -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="/resources/images/showcase-8.webp" alt="Fine Dining" class="img-fluid">
                            <div class="facility-overlay">
                                <i class="bi bi-cup-hot"></i>
                            </div>
                        </div>
                        <div class="facility-info">
                            <h4>{{ $t('front.home.fine_dining') }}</h4>
                            <p>{{ $t('front.home.fine_dining_desc') }}</p>
                            <div class="facility-features">
                                <span><i class="bi bi-check-circle"></i> {{ $t('front.home.fine_dining_feature') }}</span>
                                <span><i class="bi bi-check-circle"></i> {{ $t('front.home.wine_selection') }}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Facility Card -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="350">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="/resources/images/showcase-8.webp" alt="Spa Services" class="img-fluid">
                            <div class="facility-overlay">
                                <i class="bi bi-flower1"></i>
                            </div>
                        </div>
                        <div class="facility-info">
                            <h4>{{ $t('front.home.luxury_spa') }}</h4>
                            <p>{{ $t('front.home.luxury_spa_desc') }}</p>
                            <div class="facility-features">
                                <span><i class="bi bi-check-circle"></i> {{ $t('front.home.full_service') }}</span>
                                <span><i class="bi bi-check-circle"></i> {{ $t('front.home.wellness_programs') }}</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Facility Card -->

            </div>

        </div>

    </section><!-- /Amenities Cards Section -->


    <!-- Gallery Showcase Section -->
    <section id="gallery-showcase" class="gallery-showcase section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

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
                        'slidesPerView': 5,
                        'centeredSlides': false
                        }
                    }">
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/bg-hero.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/bg-hero.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>

                </swiper>
            </div>

            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="300">
                <Link href="#" class="btn btn-gallery">
                    <i class="bi bi-collection me-2"></i>{{ $t('front.home.discover_gallery') }}
                </Link>
            </div>

        </div>

    </section><!-- /Gallery Showcase Section -->

</template>

<script setup>
import {Swiper, SwiperSlide} from 'swiper/vue';
import 'swiper/css';
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import {addDays, currentDate, money_format} from "../../Utils/helper.js";

defineProps({
    'roomTypes': Array
})

const showGuests = ref(false)

const  form = useForm({
    'check_in': '',
    'check_out': '',
    'adults': 2,
    'children': 0,
    'rooms': 1,
})

const submitForm = () => {
    form.transform(data => ({
        'filters': data
    })).get(route('roomTypes.index'))
}

</script>

<style scoped>
.form-control {
    padding: 0.75rem;
}

.btn-origin {
    padding: 0.75rem
}
</style>
