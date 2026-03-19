<template>
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">{{ $t('front.header.about') }}</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li>
                        <Link :href="route('home')">{{ $t('front.header.home') }}</Link>
                    </li>
                    <li class="current">{{ $t('front.header.about') }}</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- About Section -->
    <section id="about-home" class="about-home section">
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
                                <div class="stat-number">185</div>
                                <div class="stat-label">{{ $t('front.home.luxury_rooms') }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">98%</div>
                                <div class="stat-label">{{ $t('front.home.guest_satisfaction') }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">30</div>
                                <div class="stat-label">{{ $t('front.home.years_experience') }}</div>
                            </div>
                        </div><!-- End Stats Row -->

                        <div class="about-actions">
                            <Link :href="route('roomTypes.index')" class="btn-secondary">{{ $t('front.home.view_rooms') }}</Link>
                        </div>
                    </div>
                </div><!-- End About Content -->

                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <div class="about-images">
                        <div class="main-image">
                            <img src="/resources/images/showcase-8.webp" alt="Grandview Resort Main View"
                                 class="img-fluid">
                        </div>
                        <div class="secondary-image">
                            <img src="/resources/images/room-12.webp" alt="Luxury Suite Interior" class="img-fluid">
                        </div>
                        <div class="experience-badge">
                            <div class="badge-content">
                                <span class="badge-number">30+</span>
                                <span class="badge-text" v-html="$t('front.home.years_experience').replace(' ', '<br>')"></span>
                            </div>
                        </div>
                    </div>
                </div><!-- End About Images -->
            </div>
        </div>
    </section>
</template>

<script setup>
</script>

<style scoped>
</style>
