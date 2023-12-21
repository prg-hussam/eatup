<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import CrudForm from "./Partials/CrudForm.vue";

defineProps({
    tabs: Object,
    user: Object,
});
</script>
<template>
    <Head :title="$t('resource.edit', { resource: $t('admin.users.user') })" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    $t('resource.edit', { resource: $t('admin.users.user') })
                "
            >
                <BreadcrumbItem
                    routeName="admin.users.index"
                    :title="$t('admin.users.users')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        $t('resource.edit', {
                            resource: $t('admin.users.user'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <CrudForm :tabs="tabs" :user="user" action="update" />
        </template>
    </DashboardLayout>
</template>
