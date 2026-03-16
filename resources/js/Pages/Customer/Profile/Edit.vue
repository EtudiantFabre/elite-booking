<template>
    <div class="container">
        <Head :title="$t('front.customer.profile.edit_title')"/>
        <div class="row g-2 align-items-center mb-2">
            <div class="col">
                <h2 class="page-title text-capitalize">{{ $t('front.customer.profile.edit_title') }}</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-header">{{ $t('front.customer.profile.edit_title') }}</div>
            <div class="card-body">
                <form id="createRoomTypes" method="post" @submit.prevent="handleForm"
                      class="gap-inputs">
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                :label="$t('front.customer.profile.first_name')"
                                v-model="form.first_name"
                                :error="form.errors.first_name"
                                required
                                :placeholder="$t('front.customer.profile.placeholders.first_name')"/>
                        </div>

                        <div class="col-6">
                            <base-input
                                :label="$t('front.customer.profile.last_name')"
                                v-model="form.last_name"
                                :error="form.errors.last_name"
                                required
                                :placeholder="$t('front.customer.profile.placeholders.last_name')"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                :label="$t('front.customer.profile.mobile')"
                                v-model="form.mobile"
                                :error="form.errors.mobile"
                                :placeholder="$t('front.customer.profile.placeholders.mobile')"/>
                        </div>

                        <div class="col-6">
                            <select-box
                                :label="$t('front.customer.profile.national')"
                                :placeholder="$t('front.customer.profile.placeholders.national')"
                                :options="countries"
                                v-model="form.national_id"
                                :error="form.errors.national_id">
                            </select-box>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                type="date"
                                :label="$t('front.customer.profile.birthdate')"
                                v-model="form.birthdate"
                                :error="form.errors.birthdate"
                                :placeholder="$t('front.customer.profile.placeholders.mobile')"/>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-label">{{ $t('front.customer.profile.sex') }}</div>
                            <RadioButton v-model="form.sex" :options="selectSexes"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <filepond-uploader
                                :label="$t('front.customer.profile.avatar')"
                                v-model="form.avatar"
                                :error="form.errors.avatar"
                                :hasNeedReload="false"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary ms-auto" form="createRoomTypes">
                    <IconDeviceFloppy class="icon"/>
                    <span>{{ $t('front.customer.profile.save') }}</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {defineProps} from "vue"
import {useForm, usePage} from "@inertiajs/vue3";
import FilepondUploader from "../../../Components/FilepondUploader.vue";
import BaseInput from "../../../Components/BaseInput.vue";
import RadioButton from "../../../Components/RadioButton.vue";
import {useEnum} from "../../../Composables/useEnum.js";
import {IconDeviceFloppy} from '@tabler/icons-vue';
import SelectBox from "../../../Components/SelectBox.vue";

const page = usePage();

const {customer, sexes} = defineProps({
    customer: Object,
    sexes: Array,
    countries: Object,
})

const {select: selectSexes} = useEnum(sexes);

const form = useForm({
    first_name: customer.first_name,
    last_name: customer.last_name,
    sex: customer.sex ?? '',
    avatar: customer.avatar,
    national_id: customer.national?.id ?? '',
    mobile: customer.mobile ?? '',
    birthdate: customer.birthdate ?? '',
});

const handleForm = () => {
    form.put(route('customer.profile.update'));
}
</script>
