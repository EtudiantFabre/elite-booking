<template>
    <Modal :title="$t('admin.actions.edit') + ' ' + $t('admin.bed_types.title')" formId="editBedTypesForm">
        <form @submit.prevent="submitEdit" method="post" id="editBedTypesForm">
            <div class="mb-3">
                <BaseInput
                    :label="$t('admin.bed_types.name')"
                    v-model="form.name"
                    :error="form.errors.name"
                    :placeholder="$t('admin.bed_types.name')"
                    required
                />
            </div>
            <div class="mb-3">
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
<script setup lang="ts">
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";

const {bedType} = defineProps({
    bedType: Object
})

const form = useForm({
    name: bedType.name,
    capacity: bedType.capacity,
});

const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.bedTypes.update', bedType.id), {
        onSuccess: () => closeModal()
    })
}

</script>
