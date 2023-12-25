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
    id: "ingredients-table",
    resource: "ingredients",
    name: "admin.ingredients.ingredient",
    buttons: ["create"],
    emptyTableButtons: ["create"],
    searchOptions: {
        url: route("admin.ingredients.index"),
    },
    columns: [
        {
            name: "icon",
            label: "admin.ingredients.table.icon",
            component: Thumbnail,
            props: (record) => {
                return {
                    thumbnail: record.icon,
                };
            },
        },
        {
            name: "name",
            label: "admin.ingredients.table.name",
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
    <Head :title="$t('admin.ingredients.ingredients')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.ingredients.ingredients')">
                <BreadcrumbItem
                    active
                    :title="$t('admin.ingredients.ingredients')"
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
                            resource: $t('admin.ingredients.ingredients'),
                        }),
                    },
                ]"
                :actions="[
                    {
                        key: 'edit',
                        label: $t(`resource.edit`, {
                            resource: $t('admin.ingredients.ingredient'),
                        }),
                    },
                    {
                        key: 'destroy',
                        label: $t(`resource.delete`, {
                            resource: $t('admin.ingredients.ingredient'),
                        }),
                        hasPreviousDivider: true,
                        colored: true,
                    },
                ]"
            />
        </template>
    </DashboardLayout>
</template>
