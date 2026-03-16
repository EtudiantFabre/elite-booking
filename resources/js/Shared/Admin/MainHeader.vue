<template>
    <header class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="navbar">
                <div class="container-xl">
                    <div class="row flex-column flex-md-row flex-fill align-items-center">
                        <div class="col">
                            <!-- BEGIN NAVBAR MENU -->
                            <ul class="navbar-nav">
                                <li class="nav-item" v-for="link in links"
                                    :class="{'dropdown': link.items !== undefined,'active': checkLinkIsActive(link)}">
                                    <Link class="nav-link" :href="route(link.routeName)"
                                          v-if="link.items === undefined">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <Component :is="link.icon" class="icon"/>
                                        </span>
                                        <span class="nav-link-title"> {{ $t(link.name) }}</span>
                                    </Link>

                                    <a
                                        v-if="link.items !== undefined"
                                        class="nav-link dropdown-toggle"
                                        href="#navbar-base"
                                        data-bs-toggle="dropdown"
                                        data-bs-auto-close="outside"
                                        role="button"
                                        aria-expanded="false"
                                    >
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <Component :is="link.icon" class="icon"/>
                                        </span>
                                        <span class="nav-link-title"> {{ $t(link.name) }} </span>
                                    </a>
                                    <div class="dropdown-menu" v-if="link.items !== undefined">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                <Link class="dropdown-item"
                                                      v-for="item in link.items"
                                                      :href="route(item.routeName)">
                                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                        <Component v-if="item.icon" :is="item.icon" class="icon"/>
                                                    </span>
                                                    <span class="nav-link-title"> {{ $t(item.name) }} </span>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <!-- END NAVBAR MENU -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
<script setup lang="ts">
import {
    IconHome, IconUsers, IconUser,
    IconShieldLock, IconBuildingSkyscraper,
    IconWorld, IconBed, IconClipboardData, IconSofa, IconBuildingBurjAlArab, IconMeat,
    IconScale, IconUserCircle, IconCalendarWeek, IconCalendarCheck, IconBrandMastercard
} from "@tabler/icons-vue"
import {usePage} from '@inertiajs/vue3'
import {h} from "vue";

const page = usePage();

const links = [
    {
        name: "admin.menu.home",
        icon: h(IconHome),
        routeName: 'admin.dashboard',
    },
    {
        name: "admin.menu.people",
        icon: h(IconUsers),
        items: [
            {
                name: "admin.menu.users",
                routeName: 'admin.users.index',
                icon: h(IconUser)
            },
            {
                name: "admin.menu.customers",
                routeName: 'admin.customers.index',
                icon: h(IconUserCircle)
            },
            {
                name: "admin.menu.roles",
                routeName: 'admin.roles.index',
                icon: h(IconShieldLock)
            }
        ]
    },
    {
        name: "admin.menu.hotel",
        icon: h(IconBuildingSkyscraper),
        items: [
            {
                name: "admin.menu.countries",
                routeName: 'admin.countries.index',
                icon: h(IconWorld)
            },
            {
                name: "admin.menu.bed_types",
                routeName: 'admin.bedTypes.index',
                icon: h(IconBed)
            },
            {
                name: "admin.menu.facilities",
                routeName: 'admin.facilities.index',
                icon: h(IconClipboardData)
            },
            {
                name: "admin.menu.room_types",
                routeName: 'admin.roomTypes.index',
                icon: h(IconSofa)
            },
            {
                name: "admin.menu.rooms",
                routeName: 'admin.rooms.index',
                icon: h(IconBuildingBurjAlArab)
            },
            {
                name: "admin.menu.meal_plans",
                routeName: 'admin.mealPlans.index',
                icon: h(IconMeat)
            },
            {
                name: "admin.menu.cancellation_rules",
                routeName: 'admin.cancellationRules.index',
                icon: h(IconScale)
            }
        ]
    },
    {
        name: "admin.menu.reservation",
        icon: h(IconCalendarWeek),
        items: [
            {
                name: "admin.menu.bookings",
                routeName: 'admin.bookings.index',
                icon: h(IconCalendarCheck)
            },
            {
                name: "admin.menu.payments",
                routeName: 'admin.payments.index',
                icon: h(IconBrandMastercard)
            },
        ]
    }
]

const checkLinkIsActive = (link) => {
    return page.url === route(link.routeName, {}, false) ||
        link.items?.some(item => route(item.routeName, {}, false) === page.url)
}
</script>
