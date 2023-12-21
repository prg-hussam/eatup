<script setup>
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";

defineProps({
    title: String,
});
</script>

<template>
    <div
        class="page-title-box d-sm-flex align-items-center justify-content-between"
    >
        <h4 class="mb-sm-0">{{ title }}</h4>
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <BreadcrumbItem
                    routeName="admin.dashboard.index"
                    :title="$t('admin.dashboard.dashboard')"
                />
                <slot />
            </ol>
        </div>
    </div>
</template>
