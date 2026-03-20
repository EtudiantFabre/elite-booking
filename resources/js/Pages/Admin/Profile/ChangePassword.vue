<template>
    <Head :title="$t('admin.shared.change_password')"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title text-capitalize">{{ $t('admin.shared.change_password') }}</h2>
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
            <div class="card-header">{{ $t('admin.shared.change_password') }}</div>
            <div class="card-body">
                <form id="createRoomTypes" method="post" @submit.prevent="handleForm"
                      class="gap-inputs">
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                type="password"
                                :label="$t('admin.shared.current_password')"
                                v-model="form.current_password"
                                :error="form.errors.current_password"
                                required
                                :placeholder="$t('admin.shared.current_password').toLowerCase()"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                type="password"
                                :label="$t('admin.shared.new_password')"
                                v-model="form.password"
                                :error="form.errors.password"
                                required
                                :placeholder="$t('admin.shared.new_password').toLowerCase()"/>
                        </div>
                        <div class="col-6">
                            <base-input
                                type="password"
                                :label="$t('admin.shared.password_confirmation')"
                                v-model="form.password_confirmation"
                                :error="form.errors.password_confirmation"
                                required
                                :placeholder="$t('admin.shared.password_confirmation').toLowerCase()"/>
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
import {useForm, usePage} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {IconDeviceFloppy, IconArrowLeft} from '@tabler/icons-vue';

const page = usePage();

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const handleForm = () => {
    form.post(route('admin.password.save'), {
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>
