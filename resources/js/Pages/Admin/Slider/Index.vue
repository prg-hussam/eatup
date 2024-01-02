<script setup>
import { Head } from "@inertiajs/vue3";
import Table from "@/Shared/Admin/Table/Index.vue";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import FilterForm from "./Table/FilterForm.vue";
import { reactive } from "@vue/reactivity";

defineProps({
    records: Object,
    filters: Object,
});
const options = {
    id: "sliders-table",
    resource: "sliders",
    name: "admin.sliders.slider",
    buttons: ["create"],
    emptyTableButtons: ["create"],
    searchOptions: {
        url: route("admin.sliders.index"),
    },
    columns: [
        {
            name: "name",
            label: "admin.sliders.table.name",
        },
        {
            name: "created_at",
            label: "global.table.created_at",
        },
    ],
};
const filterForm = reactive({
    from: route().params.from || null,
    to: route().params.to || null,
});
</script>

<template>
    <Head :title="$t('admin.sliders.sliders')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.sliders.sliders')">
                <BreadcrumbItem active :title="$t('admin.sliders.sliders')" />
            </Breadcrumb>
        </template>
        <template #content>
            <Table
                :records="records"
                v-bind="options"
                :bulkActions="[
                    {
                        key: 'destroy',
                        label: $t(`resource.delete_selected`, {
                            resource: $t('admin.sliders.sliders'),
                        }),
                    },
                ]"
                :actions="[
                    {
                        key: 'edit',
                        label: $t(`resource.edit`, {
                            resource: $t('admin.sliders.slider'),
                        }),
                    },
                    {
                        key: 'destroy',
                        label: $t(`resource.delete`, {
                            resource: $t('admin.sliders.slider'),
                        }),
                        hasPreviousDivider: true,
                        colored: true,
                    },
                ]"
                :filterForm="filterForm"
            >
                <template #filter>
                    <FilterForm :form="filterForm" :filters="filters" />
                </template>
            </Table>
        </template>
    </DashboardLayout>
</template>
