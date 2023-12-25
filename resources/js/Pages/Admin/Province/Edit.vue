<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import CrudForm from "./Partials/CrudForm.vue";

defineProps({
    tabs: Object,
    role: Object,
    province: Array,
});
</script>
<template>
    <Head
        :title="
            $t('resource.edit', { resource: $t('admin.provinces.province') })
        "
    />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    $t('resource.edit', {
                        resource: $t('admin.provinces.province'),
                    })
                "
            >
                <BreadcrumbItem
                    routeName="admin.provinces.index"
                    :title="$t('admin.provinces.provinces')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        $t('resource.edit', {
                            resource: $t('admin.provinces.province'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <CrudForm
                :tabs="tabs"
                :province="province"
                action="update"
                :permissionNames="permissionNames"
            />
        </template>
    </DashboardLayout>
</template>
