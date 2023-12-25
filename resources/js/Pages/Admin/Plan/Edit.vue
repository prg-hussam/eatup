<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import CrudForm from "./Partials/CrudForm.vue";

defineProps({
    tabs: Object,
    role: Object,
    plan: Array,
});
</script>
<template>
    <Head :title="$t('resource.edit', { resource: $t('admin.plans.plan') })" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    $t('resource.edit', {
                        resource: $t('admin.plans.plan'),
                    })
                "
            >
                <BreadcrumbItem
                    routeName="admin.plans.index"
                    :title="$t('admin.plans.plans')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        $t('resource.edit', {
                            resource: $t('admin.plans.plan'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <CrudForm
                :tabs="tabs"
                :plan="plan"
                action="update"
                :permissionNames="permissionNames"
            />
        </template>
    </DashboardLayout>
</template>
