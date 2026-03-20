<template>
    <Head :title="$t('admin.cancellation_rules.title')" />
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">{{ $t('admin.cancellation_rules.title') }}</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

                <button v-if="access.createCancellationRule" class="btn btn-primary btn-5 d-none d-sm-inline-block"
                        @click="openModal = !openModal">
                    <IconPlus class="icon icon-2"/>
                    {{ $t('admin.actions.new_record') }}
                </button>
            </div>
            <!-- BEGIN MODAL -->
            <!-- END MODAL -->
        </div>
    </div>

    <div class="card">
        <div class="card-table">
            <div class="card-header">
                <div class="row w-full">
                    <div class="col">
                        <h3 class="card-title mb-0">{{ $t('admin.cancellation_rules.title') }}</h3>
                        <p class="text-secondary m-0">{{ $t('admin.messages.list_of', {resource: $t('admin.menu.cancellation_rules').toLowerCase()}) }}</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                    <thead>
                    <tr>
                        <th class="w-1"></th>
                        <th>
                            {{ $t('admin.cancellation_rules.days_before') + ' (min)' }}
                        </th>
                        <th>
                            {{ $t('admin.cancellation_rules.days_before') + ' (max)' }}
                        </th>
                        <th>
                            {{ $t('admin.cancellation_rules.percentage') }}
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                        <tr v-for="cancellationRule in cancellationRules" :key="cancellationRule.id">
                            <td>
                                <input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox"
                                       aria-label="Select invoice" value="true">
                            </td>
                            <td>{{ cancellationRule.min_days_before }}</td>
                            <td>{{ cancellationRule.max_days_before }}</td>
                            <td>%{{ cancellationRule.penalty_percent }}</td>
                            <td class="text-end">
                                <div class="dropdown" v-if="Object.values(cancellationRule.access).some(per => per)">
                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                            data-bs-toggle="dropdown" aria-expanded="true">
                                        {{ $t('admin.actions.actions') }}
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                        <button class="dropdown-item align-middle"
                                                @click="openEditModal(cancellationRule)"
                                                v-if="cancellationRule.access.edit">
                                            <IconEdit class="icon icon1"/>
                                            {{ $t('admin.actions.edit') }}
                                        </button>
                                        <button class="dropdown-item"
                                                @click="() => confirmDelete(route('admin.cancellationRules.destroy', cancellationRule.id))"
                                                v-if="cancellationRule.access.delete">
                                            <IconTrash class="icon icon1"/>
                                            {{ $t('admin.actions.delete') }}
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <Create v-if="openModal && !editingCancelRule"/>
    <Update v-if="openModal && editingCancelRule" :cancellationRule="editingCancelRule"/>
</template>

<script setup>
import {provide, ref} from "vue";
import Create from "./Create.vue";
import {IconEdit, IconTrash, IconPlus} from '@tabler/icons-vue';
import Update from "./Update.vue";
import {useConfirm} from "../../../Composables/useConfirm.js";

const confirmDelete = useConfirm();

defineProps({
    cancellationRules: Object,
    access: Object,
});

let editingCancelRule = ref(null);
let openModal = ref(false);

provide("closeModal", () => {
    openModal.value = false
    if(editingCancelRule) editingCancelRule.value = null
});

const openEditModal = (cancellationRule) => {
    editingCancelRule.value = cancellationRule;
    openModal.value = true
}

</script>
