<template>
    <Modal :title="$t('admin.actions.edit') + ' ' + $t('admin.menu.users')" formId="editUserForm">
        <form @submit.prevent="submitEdit" method="post" id="editUserForm"  class="gap-inputs">
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
                        type= "email"
                        v-model="form.email"
                        :error="form.errors.email"
                        :placeholder="$t('admin.users.email').toLowerCase()"
                        required
                    />
                </div>
                <div class="col-lg-6">
                    <BaseInput
                        :label="$t('admin.users.password')"
                        type= "password"
                        v-model="form.password"
                        :error="form.errors.password"
                        :placeholder="$t('admin.users.password').toLowerCase()"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <SelectBox v-model="form.roles"
                               :options="roles"
                               name="roles"
                               :errors="form.errors"
                               multiple=""
                               :label="$t('admin.users.select_roles')">
                    </SelectBox>
                </div>
                <div class="col-lg-6">
                    <div class="form-label">{{ $t('admin.users.sex') }}</div>
                    <RadioButton v-model="form.sex" :options="sexes" />
                </div>
            </div>
        </form>
    </Modal>
</template>
<script setup lang="ts">
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";
import RadioButton from "../../../Components/RadioButton.vue";
import SelectBox from "../../../Components/SelectBox.vue";


const {user} = defineProps({
    user: Object,
    roles: Object,
    sexes: Object
})

const form = useForm({
    first_name: user.first_name,
    last_name: user.last_name,
    email: user.email,
    password: '',
    sex: user.sex,
    roles: user.roles.map(role => role.id)
});

const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.users.update', user.id), {
        onSuccess: () => closeModal()
    })
}

</script>
