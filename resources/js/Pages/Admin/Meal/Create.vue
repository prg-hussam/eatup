<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import CrudForm from "./Partials/CrudForm.vue";

defineProps({
    tabs: Object,
    meal: Object,
});
</script>
<template>
    <Head
        :title="$t('resource.create', { resource: $t('admin.meals.meal') })"
    />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    $t('resource.create', {
                        resource: $t('admin.meals.meal'),
                    })
                "
            >
                <BreadcrumbItem
                    routeName="admin.meals.index"
                    :title="$t('admin.meals.meals')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        $t('resource.create', {
                            resource: $t('admin.meals.meal'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <CrudForm :tabs="tabs" action="store" :meal="meal" />
        </template>
    </DashboardLayout>
</template>
