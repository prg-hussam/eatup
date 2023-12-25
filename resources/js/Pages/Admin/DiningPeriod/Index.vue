<script setup>
import { Head } from "@inertiajs/vue3";
import Table from "@/Shared/Admin/Table/Index.vue";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import { trans } from "laravel-vue-i18n";
import Thumbnail from "@/Shared/Admin/Table/Partials/Thumbnail.vue";
import ActiveStatus from "@/Shared/Admin/Table/Partials/ActiveStatus.vue";

defineProps({
    records: Object,
});
const options = {
    id: "dining_periods-table",
    resource: "dining_periods",
    name: "admin.dining_periods.dining_period",
    buttons: ["create"],
    emptyTableButtons: ["create"],
    searchOptions: {
        url: route("admin.dining_periods.index"),
    },
    columns: [
        {
            name: "icon",
            label: "admin.dining_periods.table.icon",
            component: Thumbnail,
            props: (record) => {
                return {
                    thumbnail: record.icon,
                };
            },
        },
        {
            name: "name",
            label: "admin.dining_periods.table.name",
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
            label: trans("global.table.created_at"),
        },
    ],
};
</script>

<template>
    <Head :title="$t('admin.dining_periods.dining_periods')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.dining_periods.dining_periods')">
                <BreadcrumbItem
                    active
                    :title="$t('admin.dining_periods.dining_periods')"
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
                            resource: $t('admin.dining_periods.dining_periods'),
                        }),
                    },
                ]"
                :actions="[
                    {
                        key: 'edit',
                        label: $t(`resource.edit`, {
                            resource: $t('admin.dining_periods.dining_period'),
                        }),
                    },
                    {
                        key: 'destroy',
                        label: $t(`resource.delete`, {
                            resource: $t('admin.dining_periods.dining_period'),
                        }),
                        hasPreviousDivider: true,
                        colored: true,
                    },
                ]"
            />
        </template>
    </DashboardLayout>
</template>
