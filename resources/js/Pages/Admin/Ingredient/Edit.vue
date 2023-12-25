<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import CrudForm from "./Partials/CrudForm.vue";

defineProps({
    tabs: Object,
    ingredient: Object,
});
</script>
<template>
    <Head
        :title="
            $t('resource.edit', {
                resource: $t('admin.ingredients.ingredient'),
            })
        "
    />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    $t('resource.edit', {
                        resource: $t('admin.ingredients.ingredient'),
                    })
                "
            >
                <BreadcrumbItem
                    routeName="admin.ingredients.index"
                    :title="$t('admin.ingredients.ingredients')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        $t('resource.edit', {
                            resource: $t('admin.ingredients.ingredient'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <CrudForm :tabs="tabs" :ingredient="ingredient" action="update" />
        </template>
    </DashboardLayout>
</template>
