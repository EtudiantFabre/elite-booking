<template>
    <header class="navbar navbar-expand-md d-print-none">
        <div class="container-xl">
            <!-- BEGIN NAVBAR TOGGLER -->
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbar-menu"
                aria-controls="navbar-menu"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- END NAVBAR TOGGLER -->
            <!-- BEGIN NAVBAR LOGO -->
            <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <Link :href="route('admin.dashboard')">
                    <i class="bi bi-building" style="font-size: 28px;"></i> <span
                    class="bold h4">Elite Booking</span>
                </Link>
            </div>
            <Settings />
        </div>
    </header>
</template>

<script setup>

import Settings from "./Settings.vue";
</script>
