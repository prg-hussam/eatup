<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import CrudForm from "./Partials/CrudForm.vue";

defineProps({
    tabs: Object,
    coupon: Object,
});
</script>
<template>
    <Head
        :title="$t('resource.create', { resource: $t('admin.coupons.coupon') })"
    />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    $t('resource.create', {
                        resource: $t('admin.coupons.coupon'),
                    })
                "
            >
                <BreadcrumbItem
                    routeName="admin.coupons.index"
                    :title="$t('admin.coupons.coupons')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        $t('resource.create', {
                            resource: $t('admin.coupons.coupon'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <CrudForm :tabs="tabs" action="store" :coupon="coupon" />
        </template>
    </DashboardLayout>
</template>
