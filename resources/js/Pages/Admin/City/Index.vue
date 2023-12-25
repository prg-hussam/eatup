<script setup>
import { Head } from "@inertiajs/vue3";
import Table from "@/Shared/Admin/Table/Index.vue";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import ActiveStatus from "@/Shared/Admin/Table/Partials/ActiveStatus.vue";

defineProps({
    records: Object,
});
const options = {
    id: "cities-table",
    resource: "cities",
    name: "admin.cities.city",
    buttons: ["create"],
    emptyTableButtons: ["create"],
    searchOptions: {
        url: route("admin.cities.index"),
    },
    columns: [
        {
            name: "id",
            label: "#",
        },
        {
            name: "name",
            label: "admin.cities.table.name",
        },
        {
            name: "province",
            label: "admin.cities.table.province",
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
    <Head :title="$t('admin.cities.cities')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.cities.cities')">
                <BreadcrumbItem active :title="$t('admin.cities.cities')" />
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
                            resource: $t('admin.cities.cities'),
                        }),
                    },
                ]"
                :actions="[
                    {
                        key: 'edit',
                        label: $t(`resource.edit`, {
                            resource: $t('admin.cities.city'),
                        }),
                    },
                    {
                        key: 'destroy',
                        label: $t(`resource.delete`, {
                            resource: $t('admin.cities.city'),
                        }),
                        hasPreviousDivider: true,
                        colored: true,
                    },
                ]"
            />
        </template>
    </DashboardLayout>
</template>
