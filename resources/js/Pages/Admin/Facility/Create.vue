<template>
    <Modal :title="$t('admin.actions.create') + ' ' + $t('admin.facilities.title')" formId="createFacilityForm">
        <form @submit.prevent="submitCreate" method="post" id="createFacilityForm" class="gap-inputs">
            <div class="row">
                <BaseInput
                    :label="$t('admin.facilities.name')"
                    v-model="form.name"
                    :error="form.errors.name"
                    :placeholder="$t('admin.facilities.name')"
                    required
                />
            </div>
            <div class="row">
                <FilepondUploader v-model="form.icon" :label="$t('admin.shared.icon') || 'Icon'"/>
            </div>
        </form>
    </Modal>
</template>
<script setup>
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";
import FilepondUploader from "../../../Components/FilepondUploader.vue";

const form = useForm({
    name: '',
    icon: [],
});

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.facilities.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
