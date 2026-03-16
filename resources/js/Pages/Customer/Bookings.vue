<template>
    <Head :title="$t('front.customer.bookings.title')"/>
    <div class="container">
        <div class="row g-2 align-items-center mb-4">
            <div class="col">
                <h2 class="page-title">{{ $t('front.customer.bookings.title') }}</h2>
            </div>
        </div>

        <div class="card">
            <div class="card-table">
                <div class="card-header d-block">
                    <div class="row">
                        <h3 class="card-title mb-0">{{ $t('front.customer.bookings.title') }}</h3>
                        <p class="text-secondary m-0">{{ $t('front.customer.bookings.list') }}</p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                        <thead>
                        <tr>
                            <th>{{ $t('front.customer.bookings.table.ref') }}</th>
                            <th>{{ $t('front.customer.bookings.table.adults') }}</th>
                            <th>{{ $t('front.customer.bookings.table.children') }}</th>
                            <th>{{ $t('front.customer.bookings.table.check_in') }}</th>
                            <th>{{ $t('front.customer.bookings.table.check_out') }}</th>
                            <th>{{ $t('front.customer.bookings.table.status') }}</th>
                            <th>{{ $t('front.customer.bookings.table.total') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="table-tbody">
                        <tr v-for="booking in bookings" :key="booking.id" v-if="bookings.length">
                            <td>{{ booking.ref_number }}</td>
                            <td>{{ booking.adults }}</td>
                            <td>{{ booking.children }}</td>
                            <td>{{ booking.check_in }}</td>
                            <td>{{ booking.check_out }}</td>
                            <td>
                                <span class="badge" :class="displayStatus(booking.status).bgClass">
                                    {{ displayStatus(booking.status).label }}
                                </span>
                            </td>
                            <td>{{ money_format(booking.total_price) }}</td>
                            <td class="text-end" style="width: 100px">
                                <div class="dropdown" v-if="Object.values(booking.access).some(per => per)">
                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                            data-bs-toggle="dropdown" aria-expanded="true">
                                        {{ $t('front.customer.bookings.actions') }}
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                        <Link :href="route('bookings.success', booking.id)" class="dropdown-item"
                                              v-if="booking.access.show">
                                            <IconEye class="icon icon1"/>
                                            {{ $t('front.customer.bookings.show') }}
                                        </Link>
                                        <Link :href="route('bookings.payments.create', booking.id)"
                                              class="dropdown-item" v-if="booking.access.retry">
                                            <IconCreditCard class="icon icon1"/>
                                            {{ $t('front.customer.bookings.retry') }}
                                        </Link>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="7" class="text-center py-3 text-muted">
                                {{ $t('front.customer.bookings.not_found') }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {IconEye, IconCreditCard} from '@tabler/icons-vue';
import {useEnum} from "../../Composables/useEnum.js";
import {money_format} from "../../Utils/helper.js";

const props = defineProps({
    'bookings': Object,
    'statuses': Array,
});

const {
    display: displayStatus
} = useEnum(props.statuses)
</script>
