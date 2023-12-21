<script setup>
import { Head } from "@inertiajs/vue3";
import Table from "@/Shared/Admin/Table/Index.vue";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import ActiveStatus from "@/Shared/Admin/Table/Partials/ActiveStatus.vue";
import ColName from "./Table/Name.vue";
import Roles from "./Table/Roles.vue";
import FilterForm from "./Table/FilterForm.vue";
import { reactive } from "@vue/reactivity";

defineProps({
    records: Object,
    filters: Object,
});
const options = {
    id: "users-table",
    resource: "users",
    name: "admin.users.user",
    buttons: ["create"],
    emptyTableButtons: ["create"],
    searchOptions: {
        url: route("admin.users.index"),
    },
    columns: [
        {
            name: "name",
            label: "admin.users.table.name",
            component: ColName,
            props: (record) => {
                return {
                    user: record,
                };
            },
        },
        {
            name: "roles",
            label: "admin.users.table.roles",
            component: Roles,
            props: (record) => {
                return {
                    roles: record.roles,
                };
            },
        },
        {
            name: "email",
            label: "admin.users.table.email",
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
    roles: route().params.roles || null,
    from: route().params.from || null,
    to: route().params.to || null,
});
</script>

<template>
    <Head :title="$t('admin.users.users')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.users.users')">
                <BreadcrumbItem active :title="$t('admin.users.users')" />
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
                            resource: $t('admin.users.users'),
                        }),
                    },
                ]"
                :actions="[
                    {
                        key: 'edit',
                        label: $t(`resource.edit`, {
                            resource: $t('admin.users.user'),
                        }),
                    },
                    {
                        key: 'destroy',
                        label: $t(`resource.delete`, {
                            resource: $t('admin.users.user'),
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
