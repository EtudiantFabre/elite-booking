<template>
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">{{ $t('front.header.amenities') }}</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li>
                        <Link :href="route('home')">{{ $t('front.header.home') }}</Link>
                    </li>
                    <li class="current">{{ $t('front.header.amenities') }}</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Amenities Section -->
    <section id="amenities-cards" class="amenities-cards section">
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
    </section>
</template>

<script setup>
</script>

<style scoped>
</style>
