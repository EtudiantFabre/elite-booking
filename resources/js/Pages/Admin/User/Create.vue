<template>
    <Modal :title="$t('admin.actions.create') + ' ' + $t('admin.menu.users')" formId="createUserForm">
        <form @submit.prevent="submitCreate" method="post" id="createUserForm" class="gap-inputs">
            <div class="row">
                <div class="col-lg-6">
                    <BaseInput
                        :label="$t('admin.users.first_name')"
                        v-model="form.first_name"
                        :error="form.errors.first_name"
                        :placeholder="$t('admin.users.first_name').toLowerCase()"
                        required
                    />
                </div>
                <div class="col-lg-6">
                    <BaseInput
                        :label="$t('admin.users.last_name')"
                        v-model="form.last_name"
                        :error="form.errors.last_name"
                        :placeholder="$t('admin.users.last_name').toLowerCase()"
                        required
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <BaseInput
                        :label="$t('admin.users.email')"
                        type="email"
                        v-model="form.email"
                        :error="form.errors.email"
                        :placeholder="$t('admin.users.email').toLowerCase()"
                        required
                    />
                </div>
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
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <SelectBox v-model="form.roles"
                               :options="roles"
                               name="roles"
                               :error="form.errors.roles || form.errors['roles.0']"
                               multiple=""
                               :label="$t('admin.users.select_roles')">
                    </SelectBox>
                </div>
                <div class="col-lg-6">
                    <div class="form-label">{{ $t('admin.users.sex') }}</div>
                    <RadioButton v-model="form.sex" :options="sexes"/>
                </div>
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
import SelectBox from "../../../Components/SelectBox.vue";


defineProps({
    'roles': Object,
    'sexes': Object
});

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    sex: '',
    roles: [],
});


const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.users.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
