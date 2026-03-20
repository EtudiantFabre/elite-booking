<template>
    <Modal :title="$t('admin.actions.create') + ' ' + $t('admin.bed_types.title')" formId="createBedTypeForm">
        <form @submit.prevent="submitCreate" method="post" id="createBedTypeForm" class="gap-inputs">
            <div class="row">
                <BaseInput
                    :label="$t('admin.bed_types.name')"
                    v-model="form.name"
                    :error="form.errors.name"
                    :placeholder="$t('admin.bed_types.name')"
                    required
                />
            </div>
            <div class="row">
                <BaseInput
                    :label="$t('admin.bed_types.capacity')"
                    type="number"
                    min="1"
                    max="2"
                    v-model="form.capacity"
                    :error="form.errors.capacity"
                    :placeholder="$t('admin.bed_types.capacity')"
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
    name: '',
    capacity: '',
});

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.bedTypes.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
