<script setup>
import SimpleBar from "simplebar-vue";
import Menu from "./Menu.vue";
import { ref } from "vue";
import { usePage, Link } from "@inertiajs/vue3";
import useGeneral from "@/Uses/general";

const removeOverlay = () => {
    let body = document.getElementsByTagName("body")[0];
    body.classList.remove("vertical-sidebar-enable");
};
const { appName } = useGeneral();
const sidebarLogo = ref(usePage().props.dashboard_sidebar_logo);
const sidebarIcon = ref(usePage().props.dashboard_sidebar_icon);
</script>

<template>
    <div>
        <div class="app-menu navbar-menu">
            <div class="navbar-brand-box">
                <Link v-if="sidebarLogo" href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img :src="sidebarIcon" alt="" height="22" />
                    </span>
                    <span class="logo-lg">
                        <img :src="sidebarLogo" alt="" height="17" />
                    </span>
                </Link>
                <h4 v-else class="text-white logo">{{ appName }}</h4>
                <button
                    type="button"
                    class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover"
                >
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <SimpleBar class="h-100">
                <Menu />
            </SimpleBar>
        </div>

        <div @click="removeOverlay" class="vertical-overlay" id="overlay"></div>
    </div>
</template>
