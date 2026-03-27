<template>
    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card overflow-auto" style="max-height: 400px">
        <div class="card">
            <div class="card-header d-flex">
                <h3 class="card-title">{{ $t('admin.notifications.title') }}</h3>
                <div class="btn-close ms-auto" data-bs-dismiss="dropdown"></div>
            </div>
            <div class="list-group list-group-flush list-group-hoverable">
                <div class="list-group-item" v-for="notification in notifications" :key="notification.id">
                    <div class="row align-items-center">
                        <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                        <div class="col text-truncate">
                            <a href="#" class="text-body d-block" @click.prevent="markAsRead(notification.id)">
                                {{ notification.data.title || 'Notification' }}
                            </a>
                            <div class="d-block text-secondary text-truncate mt-n1">
                                {{ notification.data.message || '' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="list-group-item-actions" @click.prevent="markAsRead(notification.id)">
                                <IconCheck class="icon text-muted icon-2" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="list-group-item py-4 text-center text-muted" v-if="notifications.length === 0">
                    {{ $t('admin.notifications.empty') || 'No unread notifications' }}
                </div>
            </div>
            <div class="card-body" v-if="notifications.length > 0">
                <div class="row">
                    <div class="col">
                        <a href="#" class="btn btn-2 w-100" @click.prevent="archiveAll"> {{ $t('admin.notifications.archive_all') }} </a>
                    </div>
                    <div class="col">
                        <a href="#" class="btn btn-2 w-100" @click.prevent="markAllAsRead"> {{ $t('admin.notifications.mark_all_as_read') }} </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { usePage, router } from "@inertiajs/vue3";
import { computed } from "vue";
import { IconCheck } from "@tabler/icons-vue";

const page = usePage();
const notifications = computed(() => page.props.auth.user.unreadNotifications);

const markAsRead = (id) => {
    router.post(route('admin.notifications.markAsRead', id), {}, {
        preserveScroll: true,
    });
};

const markAllAsRead = () => {
    router.post(route('admin.notifications.markAllAsRead'), {}, {
        preserveScroll: true,
    });
};

const archiveAll = () => {
    if (confirm('Are you sure you want to archive all notifications?')) {
        router.delete(route('admin.notifications.destroyAll'), {
            preserveScroll: true,
        });
    }
};
</script>
