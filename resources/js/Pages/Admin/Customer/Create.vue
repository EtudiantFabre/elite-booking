<template>
    <Modal :title="$t('admin.actions.create') + ' ' + $t('admin.menu.customers')" formId="createCustomerForm">
        <form @submit.prevent="submitCreate" method="post" id="createCustomerForm" class="gap-inputs">
            <div class="row">
                <div class="col-lg-6">
                    <BaseInput
                        :label="$t('admin.customers.first_name')"
                        v-model="form.first_name"
                        :error="form.errors.first_name"
                        :placeholder="$t('admin.customers.first_name').toLowerCase()"
                        required
                    />
                </div>
                <div class="col-lg-6">
                    <BaseInput
                        :label="$t('admin.customers.last_name')"
                        v-model="form.last_name"
                        :error="form.errors.last_name"
                        :placeholder="$t('admin.customers.last_name').toLowerCase()"
                        required
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <BaseInput
                        :label="$t('admin.customers.email')"
                        type="email"
                        v-model="form.email"
                        :error="form.errors.email"
                        :placeholder="$t('admin.customers.email').toLowerCase()"
                        required
                    />
                </div>
                <div class="col-lg-6">
                    <BaseInput
                        :label="$t('admin.customers.mobile')"
                        v-model="form.mobile"
                        :error="form.errors.mobile"
                        :placeholder="$t('admin.customers.mobile').toLowerCase()"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <BaseInput
                        :label="$t('admin.users.password')"
                        type="password"
                        v-model="form.password"
                        :error="form.errors.password"
                        :placeholder="$t('admin.users.password').toLowerCase()"
                        required
                    />
                </div>
                <div class="col-lg-6">
                    <div class="form-label">{{ $t('admin.users.sex') }}</div>
                    <RadioButton v-model="form.sex" :options="sexes"/>
                </div>
            </div>
            <div class="row px-2">
                <base-switch
                    :label="$t('admin.customers.status')"
                    v-model="form.status"
                    :rules="statuses"/>
            </div>
        </form>
    </Modal>
</template>
<script setup lang="ts">
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject, defineProps} from "vue";
import RadioButton from "../../../Components/RadioButton.vue";
import BaseSwitch from "../../../Components/BaseSwitch.vue";


const {defaultStatus} = defineProps({
    'sexes': Object,
    'statuses': Object,
    'defaultStatus': String,
});

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    mobile: '',
    password: '',
    sex: '',
    status: defaultStatus,
});


const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.customers.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
