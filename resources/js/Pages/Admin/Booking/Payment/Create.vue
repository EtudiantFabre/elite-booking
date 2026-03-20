<template>
    <Modal :title="$t('admin.payments.new')" formId="createPaymentForm">
        <form @submit.prevent="submitCreate" method="post" id="createPaymentForm" class="gap-inputs">
            <div class="row">
                <BaseInput
                    :label="$t('admin.payments.amount')"
                    v-model="form.amount"
                    :error="form.errors.amount"
                    :placeholder="$t('admin.payments.amount').toLowerCase()"
                    required
                />
            </div>
            <div class="row">
                <select-box
                    :label="$t('admin.payments.payment_method')"
                    :placeholder="$t('admin.payments.all_payment_method')"
                    :options="selectMethods"
                    v-model="form.payment_method"
                    :error="form.errors.payment_method"
                    required>
                </select-box>
            </div>
            <div class="row">
                <select-box
                    :label="$t('admin.payments.status')"
                    :placeholder="$t('admin.payments.all_status')"
                    :options="selectStatuses"
                    v-model="form.status"
                    :error="form.errors.status"
                    required>
                </select-box>
            </div>
            <div class="row">
                <div class="row">
                    <BaseInput
                        :label="$t('admin.payments.reference')"
                        v-model="form.reference"
                        :error="form.errors.reference"
                        :placeholder="$t('admin.payments.reference').toLowerCase()"
                        />
                </div>
            </div>
            <div class="row">
                <base-textarea
                    :label="$t('admin.payments.note')"
                    :placeholder="$t('admin.payments.note').toLowerCase()"
                    v-model="form.note"
                    :error="form.errors.note">
                </base-textarea>
            </div>
        </form>
    </Modal>
</template>
<script setup>
import {useForm} from "@inertiajs/vue3";
import {inject} from "vue";
import Modal from "../../../../Components/Modal.vue";
import BaseInput from "../../../../Components/BaseInput.vue";
import SelectBox from "../../../../Components/SelectBox.vue";
import BaseTextarea from "../../../../Components/BaseTextarea.vue";

const {booking_id, defaultStatus} = defineProps({
    'booking_id': Number,
    selectMethods: Object,
    selectStatuses: Object,
    defaultStatus: String,
})

const form = useForm({
    amount: '',
    payment_method: '',
    status: defaultStatus,
    reference: '',
    note: '',
});

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.bookings.payments.store', booking_id), {
        onSuccess: () => closeModal()
    })
}

</script>
