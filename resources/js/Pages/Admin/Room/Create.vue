<template>
    <Modal :title="$t('admin.actions.create') + ' ' + $t('admin.menu.rooms')" formId="createRoomForm">
        <form @submit.prevent="submitCreate" method="post" id="createRoomForm" class="gap-inputs">
            <div class="row">
                <BaseInput
                    type="number"
                    min="1"
                    :label="$t('admin.rooms.room_number')"
                    v-model="form.room_number"
                    :error="form.errors.room_number"
                    :placeholder="$t('admin.rooms.placeholder.room_number')"
                    required/>
            </div>
            <div class="row">
                <select-box
                    :label="$t('admin.rooms.type')"
                    :placeholder="$t('admin.rooms.placeholder.choose_type')"
                    v-model="form.room_type_id"
                    :options="roomTypes"
                    required
                    :error="form.errors.room_type_id" />
            </div>
            <div class="row">
                <BaseInput
                    type="number"
                    min="1"
                    :label="$t('admin.rooms.floor_number')"
                    v-model="form.floor_number"
                    :error="form.errors.floor_number"
                    :placeholder="$t('admin.rooms.placeholder.floor_number')"
                    required/>
            </div>
            <div class="row">
                <select-box
                    :label="$t('admin.rooms.status')"
                    v-model="form.status"
                    :options="statuses"
                    required
                    :error="form.errors.status" />
            </div>
            <div class="row">
                <select-box
                    :label="$t('admin.rooms.smoking_preference')"
                    v-model="form.smoking_preference"
                    :options="smoking"
                    required
                    :error="form.errors.smoking_preference" />
            </div>
        </form>
    </Modal>
</template>
<script setup lang="ts">
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";
import SelectBox from "../../../Components/SelectBox.vue";

const {defaultStatus, defaultSmoking} = defineProps({
    roomTypes: Object,
    statuses: Object,
    smoking: Object,
    defaultSmoking: String,
    defaultStatus: String,
})

const form = useForm({
    room_number: '',
    room_type_id: '',
    floor_number: '',
    status: defaultStatus,
    smoking_preference: defaultSmoking,
});

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.rooms.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
