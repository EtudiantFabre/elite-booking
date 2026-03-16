<template>
    <div class="container">
        <Head :title="$t('front.customer.profile.change_password')"/>
        <div class="row g-2 align-items-center mb-2">
            <div class="col">
                <h2 class="page-title text-capitalize">{{ $t('front.customer.profile.change_password') }}</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-header">{{ $t('front.customer.profile.change_password') }}</div>
            <div class="card-body">
                <form id="createRoomTypes" method="post" @submit.prevent="handleForm"
                      class="gap-inputs">
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                type="password"
                                :label="$t('front.customer.profile.current_password')"
                                v-model="form.current_password"
                                :error="form.errors.current_password"
                                required
                                :placeholder="$t('front.customer.profile.placeholders.current_password')"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                type="password"
                                :label="$t('front.customer.profile.password')"
                                v-model="form.password"
                                :error="form.errors.password"
                                required
                                :placeholder="$t('front.customer.profile.placeholders.password')"/>
                        </div>
                        <div class="col-6">
                            <base-input
                                type="password"
                                :label="$t('front.customer.profile.password_confirmation')"
                                v-model="form.password_confirmation"
                                :error="form.errors.password_confirmation"
                                required
                                :placeholder="$t('front.customer.profile.placeholders.password_confirmation')"/>
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
    form.post(route('customer.password.save'), {
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>
