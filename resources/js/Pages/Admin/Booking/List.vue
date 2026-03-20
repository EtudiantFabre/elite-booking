<template>
    <Head :title="$t('admin.menu.bookings')"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">{{ $t('admin.menu.bookings') }}</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

                <Link :href="route('admin.bookings.create')" class="btn btn-primary btn-5 d-none d-sm-inline-block"
                      v-if="access.createBookings"
                      @click="openModal = !openModal">
                    <IconPlus class="icon icon-2"/>
                    {{ $t('admin.actions.new_record') }}
                </Link>
            </div>
            <!-- BEGIN MODAL -->
            <!-- END MODAL -->
        </div>
    </div>

    <div class="card">
        <div class="card-table">
            <div class="card-header d-block">
                <div class="row">
                    <h3 class="card-title mb-0">{{ $t('admin.menu.bookings') }}</h3>
                    <p class="text-secondary m-0">{{ $t('admin.messages.list_of', {resource: $t('admin.menu.bookings').toLowerCase()}) }}</p>
                </div>
                <div class="row mt-3">
                    <div class="col-3">
                        <select-box
                            :placeholder="$t('admin.bookings.all_customers')"
                            v-model="filters.customer_id"
                            :options="customers"/>
                    </div>
                    <div class="input-group input-group-flat w-auto col-2">
                        <input id="advanced-table-search" type="number"
                               :placeholder="$t('admin.bookings.ref_number')"
                               class="form-control" autocomplete="off" v-model="filters.ref_number">
                    </div>
                    <div class="input-group input-group-flat w-auto col-2">
                        <input id="advanced-table-search" type="number"
                               :placeholder="$t('admin.rooms.room_number')"
                               class="form-control" autocomplete="off" v-model="filters.room_number">
                    </div>
                    <div class="col-2">
                        <DatePicker
                            v-model="filters.check_in"
                            :placeholder="$t('admin.bookings.check_in')"
                            range multi-calendars
                            :time-config="{ enableTimePicker: false }"
                        />
                    </div>
                    <div class="col-2">
                        <DatePicker
                            v-model="filters.check_out"
                            :placeholder="$t('admin.bookings.check_out')"
                            range multi-calendars
                            :time-config="{ enableTimePicker: false }"
                        />
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">
                        <select-box
                            :placeholder="$t('admin.bookings.all_payment_status')"
                            v-model="filters.payment_status"
                            :options="selectPaymentStatuses"/>
                    </div>
                    <div class="col-2">
                        <select-box
                            :placeholder="$t('admin.bookings.all_status')"
                            v-model="filters.status"
                            :options="selectStatuses"/>
                    </div>
                    <Link :href="route('admin.bookings.index')" class="btn btn-primary w-auto">
                        <IconRestore class="icon m-0"/>
                    </Link>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                    <thead>
                    <tr>
                        <th class="w-1"></th>
                        <sort-head name="ref_number" v-model="sorts" :label="$t('admin.bookings.ref_number')"/>
                        <sort-head name="full_name" v-model="sorts" :label="$t('admin.bookings.guest')"/>
                        <th>{{ $t('admin.bookings.guests') }}</th>
                        <SortHead name="check_in" v-model="sorts" :label="$t('admin.bookings.check_in')"/>
                        <SortHead name="check_out" v-model="sorts" :label="$t('admin.bookings.check_out')"/>
                        <th>{{ $t('admin.bookings.rooms') }}</th>
                        <SortHead name="total_price" v-model="sorts" :label="$t('admin.bookings.total_price')"/>
                        <SortHead name="deposit_amount" v-model="sorts" :label="$t('admin.bookings.paid_amount')"/>
                        <SortHead name="status" v-model="sorts" :label="$t('admin.bookings.status')"/>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                    <tr v-for="booking in bookings.data" :key="booking.id">
                        <td>
                            <input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox"
                                   aria-label="Select invoice" value="true">
                        </td>
                        <td>{{ booking.ref_number }}</td>
                        <td>{{ booking.customer.full_name }}</td>
                        <td>{{ booking.adults }} - {{ booking.children }}</td>
                        <td>{{ booking.check_in }}</td>
                        <td>{{ booking.check_out }}</td>
                        <td>
                            <span :title="booking.rooms.map(r => r.room_number).join(', ')">
                                {{ booking.rooms.length }} {{ booking.rooms.length === 1 ? $t('admin.bookings.room') : $t('admin.bookings.rooms') }}
                            </span>
                        </td>
                        <td>{{ money_format(booking.total_price) }}</td>
                        <td>{{ money_format(booking.deposit_amount) }}</td>
                        <td>
                            <span class="badge" :class="displayStatus(booking.status).bgClass">
                                {{ displayStatus(booking.status).label }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="dropdown" v-if="Object.values(booking.access).some(per => per)">
                                <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                        data-bs-toggle="dropdown" aria-expanded="true">
                                    {{ $t('admin.actions.actions') }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                     <Link :href="route('admin.bookings.show', booking.id)" class="dropdown-item"
                                          v-if="booking.access.show">
                                        <IconEye class="icon icon1"/>
                                        {{ $t('admin.actions.view') }}
                                    </Link>
                                    <Link :href="route('admin.bookings.payments.index', booking.id)"
                                          class="dropdown-item" v-if="booking.access.payments">
                                        <IconCreditCard class="icon icon1"/>
                                        {{ $t('admin.menu.payments') }}
                                    </Link>
                                    <button @click="() => confirmCheck(route('admin.bookings.checkin', booking.id), 'check_in', booking.customer.full_name)"
                                            class="dropdown-item"
                                            v-if="booking.access.checkIn">
                                        <IconDoorEnter class="icon icon1"/>
                                        {{ $t('admin.dashboard.check_in') }}
                                    </button>
                                    <Link @click="() => confirmCheck(route('admin.bookings.checkout', booking.id), 'check_out', booking.customer.full_name)"
                                          class="dropdown-item"
                                          v-if="booking.access.checkOut">
                                        <IconDoorExit class="icon icon1"/>
                                        {{ $t('admin.dashboard.check_out') }}
                                    </Link>
                                    <button type="button" @click="openCancelModal(booking)"
                                          class="dropdown-item"
                                          v-if="booking.access.cancel">
                                        <IconCalendarX class="icon icon1"/>
                                        {{ $t('admin.actions.cancel') }}
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <select class="form-select w-auto" v-model="limit" @change="syncFilters">
                    <option value="15" selected>15 {{ $t('admin.shared.records') }}</option>
                    <option value="25">25 {{ $t('admin.shared.records') }}</option>
                    <option value="50">50 {{ $t('admin.shared.records') }}</option>
                    <option value="100">100 {{ $t('admin.shared.records') }}</option>
                </select>
                <Pagination :links="bookings.meta.links"/>
            </div>
        </div>
    </div>
    <Cancel v-if="editingBooking" :booking="editingBooking"/>
</template>

<script setup>
import {provide, ref, toRaw, watch} from "vue";
import {debounce} from "@tabler/core/dist/libs/list.js/src/utils/events.js";
import {router, usePage} from "@inertiajs/vue3";
import {useTrans} from "../../../Composables/useTrans.js";
import Pagination from "../../../Shared/Admin/Pagination.vue";
import {IconPlus, IconEye, IconCreditCard, IconDoorEnter, IconDoorExit, IconRestore, IconCalendarX} from '@tabler/icons-vue';
import SortHead from "../../../Components/SortHead.vue";
import {useEnum} from "../../../Composables/useEnum.js";
import Swal from "sweetalert2";
import SelectBox from "../../../Components/SelectBox.vue";
import DatePicker from "../../../Components/DatePicker.vue";
import {money_format} from "../../../Utils/helper.js";
import Cancel from "./Cancel.vue";
const page = usePage();
const { t } = useTrans();

const props = defineProps({
    'bookings': Object,
    'smokingPreferences': Array,
    'customers': Object,
    'statuses': Array,
    'filters': Object,
    'sorts': String,
    'limit': Number,
    'access': Object,
    'paymentStatuses': Array,
});

const {
    select: selectStatuses,
    display: displayStatus
} = useEnum(props.statuses)

const {
    select: selectPaymentStatuses,
} = useEnum(props.paymentStatuses)

const editingBooking = ref(null);

provide("closeModal", () => {
    if(editingBooking) editingBooking.value = null
});

const openCancelModal = (booking) => {
    editingBooking.value = booking;
}


const confirmCheck = (url, action, customer) => {
    Swal.fire({
        title:  t(`admin.bookings.confirm_action`, {action: t(`admin.dashboard.${action}`)}),
        html: `<div style="text-align: left">${t(`admin.bookings.confirm_check_msg`, {action: t(`admin.dashboard.${action}`).toLowerCase(), customer: customer})}</div>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: t(`admin.bookings.yes_action_now`, {action: t(`admin.dashboard.${action}`)}),
        cancelButtonText: t('admin.actions.cancel'),
    }).then((result) => {
        if (result.isConfirmed) {
            router.post(url)
        }
    })
}

const filters = ref(props.filters);
const sorts = ref(props.sorts);
const limit = ref(props.limit)

watch(filters, debounce(() => {
    syncFilters()
}, 300), {
    deep: true
})


watch(sorts, () => syncFilters());

const syncFilters = () => {
    router.get(route('admin.bookings.index'), {
        sorts: sorts.value,
        limit: limit.value,
        filters: toRaw(filters.value)
    }, {
        preserveState: true,
        replace: true
    })
}

</script>
