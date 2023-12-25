<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import CrudForm from "./Partials/CrudForm.vue";

defineProps({
    tabs: Object,
    role: Object,
    category: Array,
});
</script>
<template>
    <Head
        :title="
            $t('resource.edit', { resource: $t('admin.categories.category') })
        "
    />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    $t('resource.edit', {
                        resource: $t('admin.categories.category'),
                    })
                "
            >
                <BreadcrumbItem
                    routeName="admin.categories.index"
                    :title="$t('admin.categories.categories')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        $t('resource.edit', {
                            resource: $t('admin.categories.category'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <CrudForm
                :tabs="tabs"
                :category="category"
                action="update"
                :permissionNames="permissionNames"
            />
        </template>
    </DashboardLayout>
</template>
