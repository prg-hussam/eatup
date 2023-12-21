<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import Details from "./Partials/Details.vue";
import Properties from "./Partials/Properties.vue";

const props = defineProps({
    activityLog: Object,
    properties: Object,
});
</script>

<template>
    <Head
        :title="
            $t('resource.show', {
                resource: $t('admin.activity_log.activity_log'),
            })
        "
    />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    $t('resource.show', {
                        resource: $t('admin.activity_log.activity_log'),
                    })
                "
            >
                <BreadcrumbItem
                    routeName="admin.activity_log.index"
                    :title="$t('admin.activity_log.activity_logs')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        $t('resource.show', {
                            resource: $t('admin.activity_log.activity_log'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <div class="row">
                <div class="col-12">
                    <Details :record="activityLog" />
                    <Properties :properties="properties" />
                </div>
            </div>
        </template>
    </DashboardLayout>
</template>
