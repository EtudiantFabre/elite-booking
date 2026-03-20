<template>
    <Modal :title="$t('admin.actions.create') + ' ' + $t('admin.cancellation_rules.title')" formId="createCancellationRuleForm">
        <form @submit.prevent="submitCreate" method="post" id="createCancellationRuleForm" class="gap-inputs">
            <div class="row">
                <BaseInput
                    type="number"
                    :label="$t('admin.cancellation_rules.days_before') + ' (min)'"
                    v-model="form.min_days_before"
                    :error="form.errors.min_days_before"
                    placeholder="0"
                    required
                />
            </div>
            <div class="row">
                <BaseInput
                    type="number"
                    :label="$t('admin.cancellation_rules.days_before') + ' (max)'"
                    v-model="form.max_days_before"
                    :error="form.errors.max_days_before"
                    placeholder="1"
                    required
                />
            </div>
            <div class="row">
                <BaseInput
                    type="number"
                    :label="$t('admin.cancellation_rules.percentage')"
                    v-model="form.penalty_percent"
                    :error="form.errors.penalty_percent"
                    placeholder="10"
                    required
                />
            </div>
            <div class="row">
                <BaseTextarea
                    :label="$t('admin.meal_plans.description')"
                    v-model="form.description"
                    :error="form.errors.description"
                    :placeholder="$t('admin.meal_plans.description').toLowerCase()"
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
import BaseTextarea from "../../../Components/BaseTextarea.vue";

const form = useForm({
    min_days_before: '',
    max_days_before: '',
    penalty_percent: '',
    description: '',
});

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.cancellationRules.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
