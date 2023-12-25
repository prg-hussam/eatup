<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import CrudForm from "./Partials/CrudForm.vue";

defineProps({
    tabs: Object,
    role: Object,
    city: Array,
});
</script>
<template>
    <Head :title="$t('resource.edit', { resource: $t('admin.cities.city') })" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    $t('resource.edit', {
                        resource: $t('admin.cities.city'),
                    })
                "
            >
                <BreadcrumbItem
                    routeName="admin.cities.index"
                    :title="$t('admin.cities.cities')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        $t('resource.edit', {
                            resource: $t('admin.cities.city'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <CrudForm
                :tabs="tabs"
                :city="city"
                action="update"
                :permissionNames="permissionNames"
            />
        </template>
    </DashboardLayout>
</template>
