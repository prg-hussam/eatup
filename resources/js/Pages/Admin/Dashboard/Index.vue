<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import Welcome from "@/Layouts/Admin/Partials/Welcome.vue";
import Totals from "./Partials/Totals.vue";

defineProps({
    totals: Object,
});
</script>

<template>
    <Head :title="$t('admin.dashboard.dashboard')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.dashboard.dashboard')" />
        </template>
        <template #content>
            <Welcome />
            <Totals :totals="totals" />
        </template>
    </DashboardLayout>
</template>
