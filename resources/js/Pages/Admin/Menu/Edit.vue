<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import CrudForm from "./Partials/CrudForm.vue";

defineProps({
    tabs: Object,
    role: Object,
    menu: Array,
});
</script>
<template>
    <Head :title="$t('resource.edit', { resource: $t('admin.menus.menu') })" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    $t('resource.edit', {
                        resource: $t('admin.menus.menu'),
                    })
                "
            >
                <BreadcrumbItem
                    routeName="admin.menus.index"
                    :title="$t('admin.menus.menus')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        $t('resource.edit', {
                            resource: $t('admin.menus.menu'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <CrudForm
                :tabs="tabs"
                :menu="menu"
                action="update"
                :permissionNames="permissionNames"
            />
        </template>
    </DashboardLayout>
</template>
