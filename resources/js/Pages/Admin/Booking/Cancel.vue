<template>
    <Modal :title="$t('admin.actions.cancel') + ' ' + $t('admin.menu.bookings') + ' #' + booking.ref_number" formId="cancelForm">
        <form @submit.prevent="submitForm" method="post" id="cancelForm" class="gap-inputs">
            <div>
                <div class="d-flex align-items-end gap-2 mb-2">
                    <div class="flex-grow-1">
                        <BaseInput
                            :label="$t('admin.payments.amount')"
                            v-model="form.amount"
                            :error="form.errors.amount"
                            :placeholder="$t('admin.payments.amount').toLowerCase()"
                            :disabled="!is_editing_amount"
                            required
                        />
                    </div>
                    <button type="button"
                            @click="is_editing_amount=true"
                            class="btn btn-success">
                        <IconCalculator class="icon"/>
                        {{ $t('admin.bookings.adjust_fee') }}
                    </button>
                    <button type="button" class="btn btn-warning" @click="form.amount = initial_amount; is_editing_amount=false">
                        <IconRefresh class="icon m-0"/>
                    </button>
                </div>
                <p v-if="penalty_percent === 0">
                    {{ $t('admin.bookings.free_cancel_msg') }}
                </p>
                <p v-else>
                    {{ $t('admin.bookings.penalty_msg', {percent: penalty_percent}) }}
                </p>
            </div>
            <div class="row">
                <base-textarea
                    :label="$t('admin.bookings.description')"
                    :placeholder="$t('admin.bookings.description').toLowerCase()"
                    v-model="form.description"
                    :error="form.errors.description">
                </base-textarea>
            </div>
            <div class="mt-3 p-3 rounded border">
                <p class="fw-bold mb-2">{{ $t('admin.actions.cancel') }} {{ $t('admin.dashboard.overview') }}</p>

                <p class="mb-1">
                    <strong>{{ $t('admin.bookings.total_price') }}:</strong>
                    {{ money_format(booking.total_price) }}
                </p>

                <p class="mb-1" v-if="penalty_percent > 0">
                    <strong>{{ $t('admin.bookings.penalty') }} ({{ penalty_percent }}%):</strong>
                    {{ money_format(form.amount) }}
                </p>

                <p class="mb-0">
                    <strong>{{ $t('admin.bookings.refund') }}:</strong>
                    {{ money_format(booking.total_price - form.amount) }}
                </p>
            </div>
        </form>
    </Modal>
</template>
<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import {useTrans} from "../../../Composables/useTrans.js";
import {inject, onMounted, ref, watch} from "vue";
import BaseTextarea from "../../../Components/BaseTextarea.vue";
import BaseInput from "../../../Components/BaseInput.vue";
import Modal from "../../../Components/Modal.vue";
import {IconCalculator, IconRefresh} from '@tabler/icons-vue';
import Swal from "sweetalert2";
import {money_format} from "../../../Utils/helper.js";
const page = usePage();
const { t } = useTrans();

const {booking} = defineProps({
    booking: Object
})

const form = useForm({
    amount: '',
    description: '',
});

const closeModal = inject('closeModal');

const is_editing_amount = ref(false)
const penalty_percent = ref(null)
const initial_amount = ref(null)

onMounted(() => {
    axios.get(route('admin.bookings.cancellationFee', booking.id))
        .then(res => {
            const data = res.data;
            form.amount = data.amount;
            initial_amount.value = form.amount
        })
})

const submitForm = () => {
    Swal.fire({
        title: t('admin.messages.confirm_delete_title'),
        text: t('admin.bookings.cancel_confirm_msg', {amount: money_format(form.amount)}),
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: t('admin.bookings.yes_cancel'),
        cancelButtonText: t('admin.bookings.no_back'),
    }).then((result) => {
        if (result.isConfirmed) {
            form.post(route('admin.bookings.cancel', booking.id), {
                onSuccess: () => closeModal()
            })
        }
    });
}

watch(() => form.amount, (value) => {
    let val = +value;
    if (val === 0) penalty_percent.value = 0

    const percentage = val / booking.total_price * 100;
    penalty_percent.value = Math.round(percentage);
});

</script>
