<script setup>
import { Head } from "@inertiajs/vue3";
import Table from "@/Shared/Admin/Table/Index.vue";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import ActiveStatus from "@/Shared/Admin/Table/Partials/ActiveStatus.vue";
import Thumbnail from "@/Shared/Admin/Table/Partials/Thumbnail.vue";
import { reactive } from "@vue/reactivity";
import FilterForm from "./Table/FilterForm.vue";
defineProps({
    records: Object,
    filters: Object,
});
const options = {
    id: "meals-table",
    resource: "meals",
    name: "admin.meals.meal",
    buttons: ["create"],
    emptyTableButtons: ["create"],
    searchOptions: {
        url: route("admin.meals.index"),
    },
    columns: [
        {
            name: "thumbnail",
            label: "admin.meals.table.thumbnail",
            component: Thumbnail,
            props: (record) => {
                return {
                    thumbnail: record.thumbnail,
                };
            },
        },

        {
            name: "name",
            label: "admin.meals.table.name",
        },
        {
            name: "category",
            label: "admin.meals.table.category",
        },
        {
            name: "type_text",
            label: "admin.meals.table.type",
        },

        {
            name: "calories",
            label: "admin.meals.table.calories",
        },

        {
            name: "status",
            label: "global.table.status",
            component: ActiveStatus,
            props: (record) => {
                return {
                    status: record.is_active,
                };
            },
        },

        {
            name: "created_at",
            label: "global.table.created_at",
        },
    ],
};

const filterForm = reactive({
    statuses: route().params.statuses || null,
    categories: route().params.categories || null,
    diningPeriods: route().params.diningPeriods || null,
    types: route().params.types || null,
    from: route().params.from || null,
    to: route().params.to || null,
});
</script>

<template>
    <Head :title="$t('admin.meals.meals')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.meals.meals')">
                <BreadcrumbItem active :title="$t('admin.meals.meals')" />
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
                            resource: $t('admin.meals.meals'),
                        }),
                    },
                ]"
                :actions="[
                    {
                        key: 'edit',
                        label: $t(`resource.edit`, {
                            resource: $t('admin.meals.meal'),
                        }),
                    },
                    {
                        key: 'show',
                        label: $t(`resource.show`, {
                            resource: $t('admin.meals.meal'),
                        }),
                        visitModal: true,
                    },
                    {
                        key: 'destroy',
                        label: $t(`resource.delete`, {
                            resource: $t('admin.meals.meal'),
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
