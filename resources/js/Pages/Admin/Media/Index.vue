<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import FileManager from "./FileManager.vue";
</script>

<template>
    <Head :title="$t('admin.media.media')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.media.media')">
                <BreadcrumbItem active :title="$t('admin.media.media')" />
            </Breadcrumb>
        </template>
        <template #content>
            <FileManager />
        </template>
    </DashboardLayout>
</template>
