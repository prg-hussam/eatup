<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import CrudForm from "./Partials/CrudForm.vue";

defineProps({
    tabs: Object,
    slider: Object,
});
</script>
<template>
    <Head
        :title="$t('resource.create', { resource: $t('admin.sliders.slider') })"
    />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    $t('resource.create', {
                        resource: $t('admin.sliders.slider'),
                    })
                "
            >
                <BreadcrumbItem
                    routeName="admin.sliders.index"
                    :title="$t('admin.sliders.sliders')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        $t('resource.create', {
                            resource: $t('admin.sliders.slider'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <CrudForm :tabs="tabs" action="store" :slider="slider" />
        </template>
    </DashboardLayout>
</template>
