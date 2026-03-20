<template>
    <Head :title="$t('admin.shared.profile')"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title text-capitalize">{{ $t('admin.shared.edit_profile') }}</h2>
        </div>
        <div class="col-auto ms-auto">
            <Link class="btn btn-1" :href="route('admin.dashboard')">
                <IconArrowLeft class="icon"/>
                {{ $t('admin.actions.back') }}
            </Link>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header">{{ $t('admin.shared.edit_profile') }}</div>
            <div class="card-body">
                <form id="createRoomTypes" method="post" @submit.prevent="handleForm"
                      class="gap-inputs">
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                :label="$t('admin.users.first_name')"
                                v-model="form.first_name"
                                :error="form.errors.first_name"
                                required
                                :placeholder="$t('admin.users.first_name').toLowerCase()"/>
                        </div>

                        <div class="col-6">
                            <base-input
                                :label="$t('admin.users.last_name')"
                                v-model="form.last_name"
                                :error="form.errors.last_name"
                                required
                                :placeholder="$t('admin.users.last_name').toLowerCase()"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <filepond-uploader
                                :label="$t('admin.shared.avatar')"
                                v-model="form.avatar"
                                :error="form.errors.avatar"
                                :hasNeedReload="false"/>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-label">{{ $t('admin.users.sex') }}</div>
                            <RadioButton v-model="form.sex" :options="selectSexes"/>
                        </div>
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
import {defineProps} from "vue"
import {useForm, usePage} from "@inertiajs/vue3";
import FilepondUploader from "../../../Components/FilepondUploader.vue";
import BaseInput from "../../../Components/BaseInput.vue";
import RadioButton from "../../../Components/RadioButton.vue";
import {useEnum} from "../../../Composables/useEnum.js";
import {IconDeviceFloppy, IconArrowLeft} from '@tabler/icons-vue';

const page = usePage();

const {user, sexes} = defineProps({
    user: Object,
    sexes: Array
})

const {select: selectSexes} = useEnum(sexes);

const form = useForm({
    first_name: user.first_name,
    last_name: user.last_name,
    sex: user.sex,
    avatar: user.avatar,
});

const handleForm = () => {
    form.put(route('admin.profile.update'));
}
</script>
