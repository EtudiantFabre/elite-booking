<template>
    <Head :title="$t('admin.actions.create') + ' ' + $t('admin.room_types.title')"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title text-capitalize">{{ $t('admin.actions.create') }} {{ $t('admin.room_types.title') }}</h2>
        </div>
        <div class="col-auto ms-auto">
            <Link class="btn btn-1" :href="route('admin.roomTypes.index')">
                <IconArrowLeft class="icon"/>
                {{ $t('admin.actions.back') }}
            </Link>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header">{{ $t('admin.actions.create') }} {{ $t('admin.room_types.title') }}</div>
            <div class="card-body">
                <form id="createRoomTypes" method="post" @submit.prevent="handleCreateRoomType"
                      class="gap-inputs">
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                :label="$t('admin.room_types.name')"
                                v-model="form.name"
                                :error="form.errors.name"
                                required
                                :placeholder="$t('admin.room_types.placeholder.name')"/>
                        </div>

                        <div class="col-6">
                            <base-input
                                :label="$t('admin.room_types.slug')"
                                v-model="form.slug"
                                :error="form.errors.slug"
                                required
                                :placeholder="$t('admin.room_types.placeholder.slug')"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                :label="$t('admin.room_types.view')"
                                v-model="form.view"
                                :error="form.errors.view"
                                required
                                :placeholder="$t('admin.room_types.placeholder.view')"/>
                        </div>
                        <div class="col-6">
                            <base-input
                                :label="$t('admin.room_types.size')"
                                type="number"
                                min="1"
                                v-model="form.size"
                                :error="form.errors.size"
                                required
                                :placeholder="$t('admin.room_types.placeholder.size')"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <base-input
                                :label="$t('admin.room_types.max_adult')"
                                type="number"
                                min="1"
                                v-model="form.max_adult"
                                :error="form.errors.max_adult"
                                required
                                :placeholder="$t('admin.room_types.placeholder.max_adult')"/>
                        </div>
                        <div class="col-4">
                            <base-input
                                :label="$t('admin.room_types.max_children')"
                                type="number"
                                min="1"
                                v-model="form.max_children"
                                :error="form.errors.max_children"
                                required
                                :placeholder="$t('admin.room_types.placeholder.max_children')"/>
                        </div>
                        <div class="col-4">
                            <base-input
                                :label="$t('admin.room_types.max_guests')"
                                type="number"
                                min="1"
                                v-model="form.max_total_guests"
                                :error="form.errors.max_total_guests"
                                required
                                :placeholder="$t('admin.room_types.max_guests')"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                :label="$t('admin.room_types.price')"
                                type="number"
                                min="1"
                                v-model="form.price"
                                :error="form.errors.price"
                                required
                                :placeholder="$t('admin.room_types.placeholder.price')"/>
                        </div>
                        <div class="col-6">
                            <base-input
                                :label="$t('admin.room_types.extra_bed_price')"
                                type="number"
                                min="1"
                                v-model="form.extra_bed_price"
                                :error="form.errors.extra_bed_price"
                                required
                                :placeholder="$t('admin.room_types.placeholder.extra_bed_price')"/>
                        </div>
                    </div>
                    <div class="row">
                        <Repeater
                            :label="$t('admin.room_types.bed_types')"
                            v-model="form.bedTypes"
                            :errors="form.errors"
                            name="bedTypes"
                            :heads="[$t('admin.bed_types.title'), $t('admin.shared.quantity')]"
                            :default-row="{id: '', quantity: 1}">
                            <template #default="{ item, index }" :key="index">
                                <td>
                                    <select-box
                                        :placeholder="$t('admin.room_types.placeholder.choose_bed_type')"
                                        :options="bedTypes"
                                        v-model="item.id"
                                        :error="item.errors?.id">
                                    </select-box>
                                </td>
                                <td>
                                    <base-input
                                        type="number"
                                        min="1"
                                        v-model="item.quantity"
                                        :error="item.errors?.quantity"
                                        :placeholder="$t('admin.shared.quantity')"/>
                                </td>
                            </template>
                        </Repeater>
                    </div>
                    <div class="row">
                        <quill-editor
                            v-model="form.description"
                            :error="form.errors.description"
                            :label="$t('admin.rooms.description')"/>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <filepond-uploader
                                required
                                :label="$t('admin.room_types.main_image')"
                                v-model="form.mainImage"
                                :error="form.errors.mainImage"
                                :hasNeedReload="false"/>
                        </div>
                        <div class="col-6">
                            <multi-select
                                v-model="form.facilities"
                                :label="$t('admin.room_types.facilities')"
                                :options="facilities"
                                required
                                :error="form.errors.facilities || form.errors['facilities.0']"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <filepond-uploader
                            :label="$t('admin.room_types.gallery')"
                            v-model="form.gallery"
                            allow-multiple
                            allow-reorder
                            :max-files="128"
                            :error="form.errors.gallery"
                            :hasNeedReload="false"/>

                    </div>

                    <div class="row">
                        <base-switch
                            :label="$t('admin.room_types.active')"
                            v-model="form.status"
                            :rules="statusRules"/>
                    </div>
                </form>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary ms-auto" form="createRoomTypes">
                    <IconDeviceFloppy class="icon"/>
                    <span>{{ $t('admin.actions.save') }}</span>
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
import {defineProps, watch} from "vue"
import {IconDeviceFloppy, IconArrowLeft} from "@tabler/icons-vue";
import BaseInput from "../../../Components/BaseInput.vue";
import {slugify} from "../../../Utils/helper.js";
import {useForm, usePage} from "@inertiajs/vue3";
import FilepondUploader from "../../../Components/FilepondUploader.vue";
import QuillEditor from "../../../Components/QuillEditor.vue";
import MultiSelect from "../../../Components/MultiSelect.vue";
import Repeater from "../../../Components/Repeater.vue";
import SelectBox from "../../../Components/SelectBox.vue";
import BaseSwitch from "../../../Components/BaseSwitch.vue";
import {useEnum} from "../../../Composables/useEnum.js";

const page = usePage();

const props = defineProps({
    bedTypes: Object,
    facilities: Object,
    statuses: Array,
})

const {
    switch: statusRules,
    default: defaultStatus
} = useEnum(props.statuses)


const form = useForm({
    name: '',
    slug: '',
    view: '',
    size: '',
    max_adult: '',
    max_children: '',
    max_total_guests: '',
    price: '',
    extra_bed_price: '',
    facilities: [],
    bedTypes: [{
        id: '',
        quantity: 1,
    }],
    description: '',
    mainImage: [],
    gallery: [],
    status: defaultStatus,
});


watch(
    () => form.name,
    (value) => {
        form.slug = slugify(value);
    });


const handleCreateRoomType = () => {
    form.post(route('admin.roomTypes.store'), {
        onSuccess: () => window.location.reload(),
    });
}

</script>
