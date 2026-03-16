<template>
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">{{ $t('front.failed.title') }}</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li>
                        <Link :href="route('home')">{{ $t('front.header.home') }}</Link>
                    </li>
                    <li class="current">{{ $t('front.failed.title') }}</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <section id="reservation-failed" class="reservation-failed section py-5">
        <div class="container" data-aos="fade-up">

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="failed-card shadow-sm border-0 rounded-4 overflow-hidden">
                        <div class="card-header bg-danger text-white text-center py-4">
                            <div class="failed-icon-wrapper mb-2">
                                <i class="bi bi-x-circle-fill" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="mb-0">{{ $t('front.failed.title') }}</h2>
                            <p class="mb-0 opacity-75">{{ $t('front.failed.message') }}</p>
                        </div>

                        <div class="card-body p-4 p-md-5 text-center">
                            <div class="error-details bg-light p-4 rounded-3 mb-4">
                                <h4 class="h6 text-uppercase text-muted fw-bold mb-3">{{ $t('front.failed.error_details') }}</h4>
                                <div class="row g-2 justify-content-center">
                                    <div class="col-auto">
                                        <span class="text-muted small">{{ $t('front.failed.ref_number') }}:</span>
                                        <span class="fw-bold ms-1">#{{ booking.ref_number }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                <Link :href="route('checkout.show', {booking: booking.ref_number})" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-arrow-clockwise me-2"></i> {{ $t('front.failed.retry') }}
                                </Link>
                                <Link :href="route('home')" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                                    <i class="bi bi-house-door me-2"></i> {{ $t('front.success.back_home') }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
defineProps({
    booking: Object
})
</script>
