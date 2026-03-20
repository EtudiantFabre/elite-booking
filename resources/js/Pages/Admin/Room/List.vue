<template>
    <Head :title="$t('admin.rooms.title')"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">{{ $t('admin.rooms.title') }}</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

                <button class="btn btn-primary btn-5 d-none d-sm-inline-block"
                        v-if="access.createRoom"
                        @click="openModal = !openModal">
                    <IconPlus class="icon icon-2"/>
                    {{ $t('admin.actions.new_record') }}
                </button>
            </div>
            <!-- BEGIN MODAL -->
            <!-- END MODAL -->
        </div>
    </div>

    <div class="card">
        <div class="card-table">
            <div class="card-header d-block">
                <div class="row">
                    <h3 class="card-title mb-0">{{ $t('admin.rooms.title') }}</h3>
                    <p class="text-secondary m-0">{{ $t('admin.messages.list_of', {resource: $t('admin.menu.rooms').toLowerCase()}) }}</p>
                </div>
                <div class="row mt-3">
                    <div class="input-group input-group-flat w-auto col-2">
                        <input id="advanced-table-search" type="number"
                               :placeholder="$t('admin.rooms.room_number')"
                               class="form-control" autocomplete="off" v-model="filters.room_number">
                    </div>
                    <div class="input-group input-group-flat w-auto col-2">
                        <input id="advanced-table-search" type="number"
                               :placeholder="$t('admin.rooms.floor_number')"
                               class="form-control" autocomplete="off" v-model="filters.floor_number">
                    </div>
                    <div class="col-3">
                        <select-box
                            :placeholder="$t('admin.rooms.all_room_type')"
                            v-model="filters.room_type_id"
                            :options="roomTypes"/>
                    </div>
                    <div class="col-2">
                        <select-box
                            :placeholder="$t('admin.rooms.all_status')"
                            v-model="filters.status"
                            :options="statuses"/>
                    </div>
                    <div class="col-2">
                        <select-box
                            :placeholder="$t('admin.rooms.all_smoking')"
                            v-model="filters.smoking_preference"
                            :options="smoking"/>
                    </div>
                    <Link :href="route('admin.rooms.index')" class="btn btn-primary w-auto">
                        <IconRestore class="icon m-0"/>
                    </Link>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                    <thead>
                    <tr>
                        <th class="w-1"></th>
                        <sort-head name="room_number" v-model="sorts" :label="$t('admin.rooms.room_number')"/>
                        <sort-head name="type.name" v-model="sorts" :label="$t('admin.rooms.type')"/>
                        <SortHead name="floor_number" v-model="sorts" :label="$t('admin.rooms.floor_number')"/>
                        <SortHead name="status" v-model="sorts" :label="$t('admin.rooms.status')"/>
                        <SortHead name="smoking_preference" v-model="sorts" :label="$t('admin.rooms.smoking_preference')"/>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                    <tr v-for="room in rooms.data" :key="room.id">
                        <td>
                            <input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox"
                                   aria-label="Select invoice" value="true">
                        </td>
                        <td>{{ room.room_number }}</td>
                        <td>{{ room.type.name }}</td>
                        <td>{{ room.floor_number }}</td>
                        <td>
                            <span class="badge" :class="displayStatus(room.status).bgClass">
                                {{ displayStatus(room.status).label }}
                            </span>
                        </td>
                        <td>
                            <span class="badge" :class="displaySmoking(room.smoking_preference).bgClass">
                                {{ displaySmoking(room.smoking_preference).label }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="dropdown" v-if="Object.values(room.access).some(per => per)">
                                <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                        data-bs-toggle="dropdown" aria-expanded="true">
                                    {{ $t('admin.actions.actions') }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                    <button class="dropdown-item align-middle"
                                            @click="openEditModal(room)"
                                            v-if="room.access.edit">
                                        <IconEdit class="icon icon1"/>
                                        {{ $t('admin.actions.edit') }}
                                    </button>
                                    <button class="dropdown-item" v-if="room.access.delete"
                                            @click="() => confirmDelete(route('admin.rooms.destroy', room.id))">
                                        <IconTrash class="icon icon1"/>
                                        {{ $t('admin.actions.delete') }}
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
                <Pagination :links="rooms.meta.links"/>
            </div>
        </div>
    </div>
    <Create v-if="openModal && !editingRoom"
            v-bind="{roomTypes, statuses, smoking, defaultSmoking, defaultStatus}"/>
    <Update v-if="openModal && editingRoom"
            :room="editingRoom"
            v-bind="{roomTypes, smoking, statuses}"/>
</template>

<script setup>
import {provide, ref, toRaw, watch} from "vue";
import {debounce} from "@tabler/core/dist/libs/list.js/src/utils/events.js";
import {router} from "@inertiajs/vue3";
import Pagination from "../../../Shared/Admin/Pagination.vue";
import Create from "./Create.vue";
import {IconEdit, IconTrash, IconPlus, IconSearch, IconRestore} from '@tabler/icons-vue';
import Update from "./Update.vue";
import {useConfirm} from "../../../Composables/useConfirm.js";
import SortHead from "../../../Components/SortHead.vue";
import {useEnum} from "../../../Composables/useEnum.js";
import SelectBox from "../../../Components/SelectBox.vue";

const props = defineProps({
    'roomTypes': Object,
    'rooms': Object,
    statuses: Array,
    smokingPreferences: Array,
    'filters': Object,
    'sorts': String,
    'limit': Number,
    'access': Object,
});

const confirmDelete = useConfirm();
const {
    select: statuses,
    default: defaultStatus,
    display: displayStatus
} = useEnum(props.statuses)


const {
    select: smoking,
    default: defaultSmoking,
    display: displaySmoking
} = useEnum(props.smokingPreferences)

let editingRoom = ref(null);
let openModal = ref(false);
const filters = ref(props.filters);
const sorts = ref(props.sorts);
const limit = ref(props.limit)


provide("closeModal", () => {
    openModal.value = false
    if (editingRoom) editingRoom.value = null
});

const openEditModal = (room) => {
    editingRoom.value = room;
    openModal.value = true
}

watch(filters, debounce(() => {
    syncFilters()
}, 300), {
    deep: true
})


watch(sorts, () => syncFilters());

const syncFilters = () => {
    router.get(route('admin.rooms.index'), {
        sorts: sorts.value,
        limit: limit.value,
        filters: toRaw(filters.value)
    }, {
        preserveState: true,
        replace: true
    })
}

</script>
