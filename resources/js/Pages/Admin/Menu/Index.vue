<script setup>
import { Head } from "@inertiajs/vue3";
import Table from "@/Shared/Admin/Table/Index.vue";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import ActiveStatus from "@/Shared/Admin/Table/Partials/ActiveStatus.vue";
import DefaultCol from "./Table/Default.vue";

defineProps({
    records: Object,
});
const options = {
    id: "menus-table",
    resource: "menus",
    name: "admin.menus.menu",
    buttons: ["create"],
    emptyTableButtons: ["create"],
    searchOptions: {
        url: route("admin.menus.index"),
    },
    columns: [
        {
            name: "name",
            label: "admin.menus.table.name",
        },
        {
            name: "default",
            label: "admin.menus.table.is_default",
            component: DefaultCol,
            props: (record) => {
                return {
                    isDefault: record.is_default,
                };
            },
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
</script>

<template>
    <Head :title="$t('admin.menus.menus')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.menus.menus')">
                <BreadcrumbItem active :title="$t('admin.menus.menus')" />
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
                            resource: $t('admin.menus.menus'),
                        }),
                    },
                ]"
                :actions="[
                    {
                        key: 'edit',
                        label: $t(`resource.edit`, {
                            resource: $t('admin.menus.menu'),
                        }),
                    },
                    {
                        key: 'destroy',
                        label: $t(`resource.delete`, {
                            resource: $t('admin.menus.menu'),
                        }),
                        hasPreviousDivider: true,
                        colored: true,
                    },
                ]"
            />
        </template>
    </DashboardLayout>
</template>
