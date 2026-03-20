<template>
    <Modal :title="$t('admin.actions.edit') + ' ' + $t('admin.roles.title')" formId="editRolesForm">
        <form @submit.prevent="submitEdit" method="post" id="editRolesForm">
            <div class="row">
                <BaseInput
                    :label="$t('admin.roles.name')"
                    v-model="form.name"
                    :error="form.errors.name"
                    :placeholder="$t('admin.roles.name').toLowerCase()"
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

const {role} = defineProps({
    role: Object
})

const form = useForm({
    name: role.name,
});

const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.roles.update', role.id), {
        onSuccess: () => closeModal()
    })
}

</script>
