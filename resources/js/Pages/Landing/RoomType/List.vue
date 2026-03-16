<template>
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">{{ $t('front.rooms.title') }}</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li>
                        <Link :href="route('home')">{{ $t('front.header.home') }}</Link>
                    </li>
                    <li class="current">{{ $t('front.rooms.title') }}</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Rooms 2 Section -->
    <section id="rooms-2" class="rooms-2 section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="room-filters" data-aos="fade-up" data-aos-delay="200">
                <form class="booking-form php-email-form" @submit.prevent="submitForm" method="get">
                    <div class="row align-items-end g-3">
                        <div class="col-md-3">
                            <label for="checkin" class="form-label">{{ $t('front.booking.check_in') }}</label>
                            <input type="date" v-model="form.check_in" class="form-control"  id="checkin" :min="currentDate()"
                                   required="">
                        </div>
                        <div class="col-md-3">
                            <label for="checkout" class="form-label">{{ $t('front.booking.check_out') }}</label>
                            <input type="date" v-model="form.check_out" class="form-control" id="checkout"  :min="addDays(Date.now(), 1)"
                                   required="">
                        </div>
                        <div class="col-md-4">
                            <label for="guests" class="form-label">{{ $t('front.booking.guests') }}</label>
                            <div class="border bg-white rounded px-4 position-relative cursor-pointer"
                                 style="padding: .75rem;">
                                <div class="d-flex justify-content-between flex-grow-1"
                                     @click="showGuests = !showGuests">
                                    <i class="bi bi-people-fill"
                                       style="font-size: 1rem;font-weight: 400;line-height: 1.5;color: #6e7174;">
                                    </i>
                                    <div>
                                        {{ $t('front.booking.adults_count', { count: form.adults }) }}
                                    </div>
                                    <div>
                                        {{ $t('front.booking.children_count', { count: form.children }) }}
                                    </div>
                                    <div>
                                        {{ $t('front.booking.rooms_count', { count: form.rooms }) }}
                                    </div>
                                    <i class="bi bi-chevron-down mt-1"
                                       style="font-size: 13px;font-weight: 700;line-height: 1.2"></i>
                                </div>
                                <div
                                    class="border shadow position-absolute w-full bg-white rounded p-4 d-flex flex-column gap-3"
                                    style="left: 0; top: 53px; z-index: 9" v-if="showGuests">
                                    <div>
                                        <label for="adults" class="form-label">{{ $t('front.booking.adults') }}</label>
                                        <input type="number" min="1" v-model="form.adults" class="form-control"
                                               id="adults" required="">
                                    </div>
                                    <div>
                                        <label for="children" class="form-label">{{ $t('front.booking.children') }}</label>
                                        <input type="number" min="0" v-model="form.children" class="form-control"
                                               id="children" required="">
                                    </div>
                                    <div>
                                        <label for="room" class="form-label">{{ $t('front.booking.room') }}</label>
                                        <input type="number" min="1" v-model="form.rooms" class="form-control" id="room"
                                               required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-origin">
                                <i class="bi bi-search"></i>
                                <span class="mx-2">{{ $t('front.rooms.search') }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <InfiniteScroll data="roomTypes">
                <div class="rooms-grid" data-aos="fade-up" data-aos-delay="300">
                    <div class="row g-4">
                        <div class="col-xl-4 col-lg-6" v-for="roomType in roomTypes.data">
                            <div class="room-card">
                                <div class="room-image">
                                    <img :src="getMediaUrl(roomType.mainImage[0], 'thumb')"
                                         :alt="roomType.name" class="img-fluid">
                                    <div class="room-features">
                                        <span class="feature-badge ocean">{{ roomType.view }}</span>
                                    </div>
                                </div>
                                <div class="room-content">
                                    <div class="room-header">
                                        <h3>{{ roomType.name }}</h3>
                                        <div class="room-rating">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                    <p class="room-description" v-html="roomType.short_description"></p>
                                    <div class="room-amenities">
                                        <span><i class="bi bi-people"></i> {{ $t('front.booking.up_to_guests', { count: roomType.max_total_guests }) }}</span>
                                        <span><i class="bi bi-wifi"></i> {{ $t('front.rooms.wifi')}}</span>
                                        <span><i class="bi bi-tv"></i> {{ $t('front.rooms.tv') }}</span>
                                    </div>
                                    <div class="room-footer">
                                        <div class="room-price">
                                            <span class="price-from">{{ $t('front.rooms.from') }}</span>
                                            <span class="price-amount">{{ money_format(roomType.price) }}</span>
                                            <span class="price-period">{{ $t('front.rooms.per_night_slash') }}</span>
                                        </div>
                                        <Link :href="route('roomTypes.show', {
                                            roomType: roomType.slug,
                                            filters
                                        })" class="btn-room-details">
                                            {{ $t('front.rooms.view_details') }}
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Room Card -->
                    </div>
                </div>
            </InfiniteScroll>
        </div>

    </section><!-- /Rooms 2 Section -->
</template>

<script setup>
import {addDays, currentDate, getMediaUrl, money_format} from "../../../Utils/helper.js";
import {ref} from "vue";
import {InfiniteScroll, useForm} from "@inertiajs/vue3";

const {filters} = defineProps({
    roomTypes: Object,
    filters: Object
})

const showGuests = ref(false)

const form = useForm({
    'check_in': filters?.check_in,
    'check_out': filters?.check_out,
    'adults': filters?.adults ?? 2,
    'children': filters?.children ?? 0,
    'rooms': filters?.rooms ?? 1,
})

const submitForm = () => {
    form.transform(data => ({
        filters: data,
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
