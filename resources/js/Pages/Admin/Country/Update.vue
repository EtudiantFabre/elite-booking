<template>
    <Modal :title="$t('admin.actions.edit') + ' ' + $t('admin.countries.title')" formId="editCountryForm">
        <form @submit.prevent="submitEdit" method="post" id="editCountryForm" class="gap-inputs">
            <div class="row">
                <BaseInput
                    :label="$t('admin.countries.name')"
                    v-model="form.name"
                    :error="form.errors.name"
                    :placeholder="$t('admin.countries.name').toLowerCase()"
                    required
                />
            </div>
            <div class="row">
                <BaseInput
                    :label="$t('admin.countries.short')"
                    v-model="form.short"
                    :error="form.errors.short"
                    :placeholder="$t('admin.countries.short').toLowerCase()"
                    required
                />
            </div>
        </form>
    </Modal>
</template>
<script setup >
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";


const {country} = defineProps({
    country: Object,
})

const form = useForm({
    name: country.name,
    short: country.short,
});


const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.countries.update', country.id), {
        onSuccess: () => closeModal()
    })
}

</script>
