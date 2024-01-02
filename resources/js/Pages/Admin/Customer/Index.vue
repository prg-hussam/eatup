<script setup>
import { Head } from "@inertiajs/vue3";
import Table from "@/Shared/Admin/Table/Index.vue";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import ActiveStatus from "@/Shared/Admin/Table/Partials/ActiveStatus.vue";
import FilterForm from "./Table/FilterForm.vue";
import { reactive } from "@vue/reactivity";

defineProps({
    records: Object,
    filters: Object,
});
const options = {
    id: "customers-table",
    resource: "customers",
    name: "admin.customers.customer",
    buttons: [],
    emptyTableButtons: [],
    searchOptions: {
        url: route("admin.customers.index"),
    },
    columns: [
        {
            name: "name",
            label: "admin.customers.table.name",
        },
        {
            name: "phone",
            label: "admin.customers.table.phone",
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
    from: route().params.from || null,
    to: route().params.to || null,
});
</script>

<template>
    <Head :title="$t('admin.customers.customers')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.customers.customers')">
                <BreadcrumbItem
                    active
                    :title="$t('admin.customers.customers')"
                />
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
                            resource: $t('admin.customers.customers'),
                        }),
                    },
                ]"
                :actions="[
                    {
                        key: 'show',
                        label: $t(`resource.show`, {
                            resource: $t('admin.customers.customer'),
                        }),
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
