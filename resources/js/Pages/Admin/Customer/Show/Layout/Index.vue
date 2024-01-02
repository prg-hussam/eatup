<script setup>
import { Link } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import Tabs from "./Tabs.vue";
defineProps({
    shared: Object,
});
</script>

<template>
    <Head
        :title="
            trans('resource.edit', {
                resource: trans('modules.customers.customer'),
            })
        "
    />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb
                :title="
                    trans('resource.show', {
                        resource: trans('modules.customers.customer'),
                    })
                "
            >
                <BreadcrumbItem
                    routeName="platform.customers.index"
                    :title="trans('modules.customers.customers')"
                />
                <BreadcrumbItem
                    active
                    :title="
                        trans('resource.show', {
                            resource: trans('modules.customers.customer'),
                        })
                    "
                />
            </Breadcrumb>
        </template>
        <template #content>
            <Tabs :shared="shared" />
            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content text-muted">
                        <div class="tab-pane fade show active" role="tabpanel">
                            <slot />
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </DashboardLayout>
</template>
