<template>
    <Modal :title="$t('admin.actions.edit') + ' ' + $t('admin.meal_plans.title')" formId="editMealPlanForm">
        <form @submit.prevent="submitEdit" method="post" id="editMealPlanForm" class="gap-inputs">
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
<script setup lang="ts">
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";
import BaseTextarea from "../../../Components/BaseTextarea.vue";

const {mealPlan} = defineProps({
    mealPlan: Object
})

const form = useForm({
    name: mealPlan.name,
    code: mealPlan.code,
    description: mealPlan.description,
    adult_price: mealPlan.adult_price,
    child_price: mealPlan.child_price,
    infant_price: mealPlan.infant_price
});

const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.mealPlans.update', mealPlan.id), {
        onSuccess: () => closeModal()
    })
}

</script>
