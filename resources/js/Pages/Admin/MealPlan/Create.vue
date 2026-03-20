<template>
    <Modal :title="$t('admin.actions.create') + ' ' + $t('admin.meal_plans.title')" formId="createMealPlanForm">
        <form @submit.prevent="submitCreate" method="post" id="createMealPlanForm" class="gap-inputs">
            <div class="row">
                <BaseInput
                    :label="$t('admin.meal_plans.name')"
                    v-model="form.name"
                    :error="form.errors.name"
                    :placeholder="$t('admin.meal_plans.name').toLowerCase()"
                    required
                />
            </div>
            <div class="row">
                <BaseInput
                    :label="$t('admin.meal_plans.code')"
                    v-model="form.code"
                    :error="form.errors.code"
                    :placeholder="$t('admin.meal_plans.code').toLowerCase()"
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

            <div class="row">
                <BaseInput
                    :label="$t('admin.meal_plans.adult_price')"
                    type="number"
                    v-model="form.adult_price"
                    :error="form.errors.adult_price"
                    :placeholder="$t('admin.room_types.price').toLowerCase()"
                    required
                />
            </div>
            <div class="row">
                <BaseInput
                    :label="$t('admin.meal_plans.child_price')"
                    type="number"
                    v-model="form.child_price"
                    :error="form.errors.child_price"
                    :placeholder="$t('admin.room_types.price').toLowerCase()"
                    required
                />
            </div>
            <div class="row">
                <BaseInput
                    :label="$t('admin.meal_plans.infant_price')"
                    type="number"
                    v-model="form.infant_price"
                    :error="form.errors.infant_price"
                    :placeholder="$t('admin.room_types.price').toLowerCase()"
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
import BaseTextarea from "../../../Components/BaseTextarea.vue";

const form = useForm({
    name: '',
    code: '',
    description: '',
    adult_price: '',
    child_price: '',
    infant_price: '',
});

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.mealPlans.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
