<template>
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">{{ $t('front.success.title') }}</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li>
                        <Link :href="route('home')">{{ $t('front.header.home') }}</Link>
                    </li>
                    <li class="current">{{ $t('front.success.title') }}</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <section id="reservation-success" class="reservation-success section py-5">
        <div class="container" data-aos="fade-up">

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="success-card shadow-sm border-0 rounded-4 overflow-hidden">
                        <div class="card-header bg-success text-white text-center py-4">
                            <div class="success-icon-wrapper mb-2">
                                <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="mb-0">{{ $t('front.success.title') }}</h2>
                            <p class="mb-0 opacity-75">{{ $t('front.success.message') }}</p>
                        </div>

                        <div class="card-body p-4 p-md-5">
                            <div class="row g-4 mb-4">
                                <div class="col-md-12">
                                    <h4 class="section-title-sm border-bottom pb-2 mb-3">{{ $t('front.success.booking_details') }}</h4>
                                    <div class="row g-3">
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="detail-item">
                                                <span class="text-muted d-block small">{{ $t('front.success.ref_number') }}</span>
                                                <span class="fw-bold">#{{ booking.ref_number }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="detail-item">
                                                <span class="text-muted d-block small">{{ $t('front.success.guest_name') }}</span>
                                                <span class="fw-bold">{{ booking.customer.full_name }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="detail-item">
                                                <span class="text-muted d-block small">{{ $t('front.booking.check_in') }}</span>
                                                <span class="fw-bold">{{ moment(booking.check_in).format('ddd, MMM D, Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="detail-item">
                                                <span class="text-muted d-block small">{{ $t('front.booking.check_out') }}</span>
                                                <span class="fw-bold">{{ moment(booking.check_out).format('ddd, MMM D, Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="detail-item">
                                                <span class="text-muted d-block small">{{ $t('front.success.meal_plan') }}</span>
                                                <span class="fw-bold">{{ booking.mealPlan.name }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="detail-item">
                                                <span class="text-muted d-block small">{{ $t('front.success.status') }}</span>
                                                <span :class="`badge ${displayStatus(booking.status).bgClass}`">
                                                    {{ displayStatus(booking.status).label }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="detail-item">
                                                <span class="text-muted d-block small">{{ $t('front.success.payment_status') }}</span>
                                                <span :class="`badge ${displayPaymentStatus(booking.payment_status).bgClass}`">
                                                    {{ displayPaymentStatus(booking.payment_status).label }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="detail-item">
                                                <span class="text-muted d-block small">{{ $t('front.success.deposit') }}</span>
                                                <span class="fw-bold text-success">{{ money_format(booking.deposit_amount) }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="detail-item">
                                                <span class="text-muted d-block small">{{ $t('front.success.smoking') }}</span>
                                                <span :class="`badge ${displaySmoking(booking.smoking_preference).bgClass}`">
                                                    {{ displaySmoking(booking.smoking_preference).label }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="detail-item">
                                                <span class="text-muted d-block small">{{ $t('front.success.created_at') }}</span>
                                                <span class="fw-bold">{{ moment(booking.created_at).format('MMM D, Y HH:mm') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12" v-if="booking.special_requests">
                                            <div class="detail-item">
                                                <span class="text-muted d-block small">{{ $t('front.success.special_requests') }}</span>
                                                <p class="mb-0 fst-italic">{{ booking.special_requests }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-12" v-if="booking.payments && booking.payments.length">
                                    <h4 class="section-title-sm border-bottom pb-2 mb-3">{{ $t('front.success.payment_details') }}</h4>
                                    <div class="table-responsive">
                                        <table class="table table-vcenter card-table table-striped">
                                            <thead>
                                            <tr>
                                                <th>{{ $t('front.success.amount') }}</th>
                                                <th>Type</th>
                                                <th>{{ $t('front.success.method') }}</th>
                                                <th>{{ $t('front.success.status') }}</th>
                                                <th>{{ $t('front.success.date') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="payment in booking.payments">
                                                <td>{{ money_format(payment.amount) }}</td>
                                                <td>
                                                    <span class="badge" :class="displayType(payment.type).bgClass">
                                                        {{ displayType(payment.type).label }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge" :class="displayMethod(payment.payment_method).bgClass">
                                                        {{ displayMethod(payment.payment_method).label }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge" :class="displayPayStatus(payment.status).bgClass">
                                                        {{ displayPayStatus(payment.status).label }}
                                                    </span>
                                                </td>
                                                <td>{{ payment.paid_at }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <h4 class="section-title-sm border-bottom pb-2 mb-3">{{ $t('front.success.room_details') }}</h4>
                                    <div class="table-responsive">
                                        <table class="table table-vcenter card-table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Room Number</th>
                                                <th>Floor</th>
                                                <th>{{ $t('front.success.smoking') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="room in booking.rooms">
                                                <td>{{ room.room_number }}</td>
                                                <td>{{ room.floor_number }}</td>
                                                <td>
                                                    <span class="badge" :class="displaySmoking(room.smoking_preference).bgClass">
                                                        {{ displaySmoking(room.smoking_preference).label }}
                                                    </span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <div class="d-flex flex-wrap justify-content-center gap-3">
                                    <Link :href="route('home')" class="btn btn-outline-success px-4 py-2 rounded-pill">
                                        <i class="bi bi-house-door me-2"></i> {{ $t('front.success.back_home') }}
                                    </Link>
                                    <Link :href="route('customer.bookings.index')" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                                        <i class="bi bi-calendar-check me-2"></i> {{ $t('front.success.view_bookings') }}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Booking Section -->
</template>

<script setup>
import {diffDays, money_format} from "../../Utils/helper.js";
import moment from "moment";
import {usePage} from "@inertiajs/vue3";
import {useEnum} from "../../Composables/useEnum.js";


const {props: {auth: {customer}}} = usePage();
const props = defineProps({
    roomType: Object,
    booking: Object,
    charges: Array,
    statuses: Array,
    bookingPayments: Array,
    smokings: Array,
    types: Array,
    methods: Array,
    paymentStatuses: Array,
});

const {display: displayCharge} = useEnum(props.charges)
const {display: displayStatus} = useEnum(props.statuses)
const {display: displayPaymentStatus} = useEnum(props.bookingPayments)
const {display: displaySmoking} = useEnum(props.smokings)
const {display: displayType} = useEnum(props.types)
const {display: displayMethod} = useEnum(props.methods)
const {display: displayPayStatus} = useEnum(props.paymentStatuses)


</script>

<style scoped>
</style>

