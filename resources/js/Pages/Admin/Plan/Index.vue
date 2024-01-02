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
    id: "plans-table",
    resource: "plans",
    name: "admin.plans.plan",
    buttons: ["create"],
    emptyTableButtons: ["create"],
    searchOptions: {
        url: route("admin.plans.index"),
    },
    columns: [
        {
            name: "name",
            label: "admin.plans.table.name",
        },
        {
            name: "duration",
            label: "admin.plans.table.duration",
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
    <Head :title="$t('admin.plans.plans')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.plans.plans')">
                <BreadcrumbItem active :title="$t('admin.plans.plans')" />
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
                            resource: $t('admin.plans.plans'),
                        }),
                    },
                ]"
                :actions="[
                    {
                        key: 'edit',
                        label: $t(`resource.edit`, {
                            resource: $t('admin.plans.plan'),
                        }),
                    },
                    {
                        key: 'destroy',
                        label: $t(`resource.delete`, {
                            resource: $t('admin.plans.plan'),
                        }),
                        hasPreviousDivider: true,
                        colored: true,
                    },
                ]"
            />
        </template>
    </DashboardLayout>
</template>
