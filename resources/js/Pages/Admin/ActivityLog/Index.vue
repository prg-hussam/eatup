<script setup>
import { Head } from "@inertiajs/vue3";
import Table from "@/Shared/Admin/Table/Index.vue";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import ActiveStatus from "@/Shared/Admin/Table/Partials/ActiveStatus.vue";
import LogType from "./Table/LogType.vue";
import FilterForm from "./Table/FilterForm.vue";
import HttpMethod from "./Table/HttpMethod.vue";
import Agent from "./Table/Agent.vue";
import { reactive } from "vue";

defineProps({
    records: Object,
    filters: Object,
});

const options = {
    id: "activityLog-table",
    resource: "activity_log",
    name: "admin.activity_log.activity_log",
    buttons: [],
    bulkActions: [],
    searchOptions: {
        url: route("admin.activity_log.index"),
    },
    columns: [
        {
            name: "causer",
            label: "admin.activity_log.table.causer",
        },
        {
            name: "log_type",
            label: "admin.activity_log.table.log_type",
            component: LogType,
            props: (record) => {
                return {
                    type: record.log_type,
                    action: record.action,
                };
            },
        },
        {
            name: "ip",
            label: "admin.activity_log.table.ip",
        },
        {
            name: "agent",
            label: "admin.activity_log.table.agent",
            component: Agent,
            props: (record) => {
                return {
                    agent: record.agent,
                };
            },
        },
        {
            name: "description",
            label: "admin.activity_log.table.description",
        },
        {
            name: "http_method",
            label: "admin.activity_log.table.http_method",
            component: HttpMethod,
            props: (record) => {
                return {
                    method: record.http_method,
                };
            },
        },
        {
            name: "created_at",
            label: "admin.activity_log.table.log_date",
        },
    ],
};

const filterForm = reactive({
    log_types: route().params.log_types || null,
    ip: route().params.ip || null,
    http_methods: route().params.http_methods || null,
    causer_name: route().params.causer_name || null,
    from: route().params.from || null,
    to: route().params.to || null,
});
</script>

<template>
    <Head :title="$t('admin.activity_log.activity_logs')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.activity_log.activity_logs')">
                <BreadcrumbItem
                    active
                    :title="$t('admin.activity_log.activity_logs')"
                />
            </Breadcrumb>
        </template>
        <template #content>
            <Table
                :records="records"
                v-bind="options"
                :actions="[
                    {
                        key: 'show',
                        label: $t(`resource.show`, {
                            resource: $t('admin.activity_log.activity_log'),
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
