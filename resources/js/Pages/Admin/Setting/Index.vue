<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import Boxes from "@/Shared/Admin/Boxes/Index.vue";

defineProps({ boxes: Object });
</script>

<template>
    <Head :title="$t('admin.sidebar.system_settings')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.sidebar.system_settings')">
                <BreadcrumbItem active :title="$t('admin.sidebar.settings')" />
                <BreadcrumbItem
                    active
                    :title="$t('admin.sidebar.system_settings')"
                />
            </Breadcrumb>
        </template>
        <template #content> <Boxes :boxes="boxes" /> </template>
    </DashboardLayout>
</template>
