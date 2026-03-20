<template>
    <Modal :title="$t('admin.actions.create') + ' ' + $t('admin.roles.title')" formId="createRoleForm">
        <form @submit.prevent="submitCreate" method="post" id="createRoleForm">
            <div class="row">
                <BaseInput
                    :label="$t('admin.roles.name')"
                    v-model="form.name"
                    :error="form.errors.name"
                    :placeholder="$t('admin.roles.name').toLowerCase()"
                    required
                />
            </div>
        </form>
    </Modal>
</template>
<script setup>
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";

const form = useForm({
    name: ''
});

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.roles.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
