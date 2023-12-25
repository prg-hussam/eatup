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
    id: "provinces-table",
    resource: "provinces",
    name: "admin.provinces.province",
    buttons: ["create"],
    emptyTableButtons: ["create"],
    searchOptions: {
        url: route("admin.provinces.index"),
    },
    columns: [
        {
            name: "id",
            label: "#",
        },
        {
            name: "name",
            label: "admin.provinces.table.name",
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
    <Head :title="$t('admin.provinces.provinces')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.provinces.provinces')">
                <BreadcrumbItem
                    active
                    :title="$t('admin.provinces.provinces')"
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
                            resource: $t('admin.provinces.provinces'),
                        }),
                    },
                ]"
                :actions="[
                    {
                        key: 'edit',
                        label: $t(`resource.edit`, {
                            resource: $t('admin.provinces.province'),
                        }),
                    },
                    {
                        key: 'destroy',
                        label: $t(`resource.delete`, {
                            resource: $t('admin.provinces.province'),
                        }),
                        hasPreviousDivider: true,
                        colored: true,
                    },
                ]"
            />
        </template>
    </DashboardLayout>
</template>
