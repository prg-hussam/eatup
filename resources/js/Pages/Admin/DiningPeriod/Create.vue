<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import CrudForm from "./Partials/CrudForm.vue";

defineProps({
    tabs: Object,
    diningPeriod: Object,
});
</script>
<template>
    <Head
        :title="
            $t('resource.create', {
                resource: $t('admin.dining_periods.dining_period'),
            })
        "
    />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    $t('resource.create', {
                        resource: $t('admin.dining_periods.dining_period'),
                    })
                "
            >
                <BreadcrumbItem
                    routeName="admin.dining_periods.index"
                    :title="$t('admin.dining_periods.dining_periods')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        $t('resource.create', {
                            resource: $t('admin.dining_periods.dining_period'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <CrudForm
                :tabs="tabs"
                action="store"
                :diningPeriod="diningPeriod"
            />
        </template>
    </DashboardLayout>
</template>
