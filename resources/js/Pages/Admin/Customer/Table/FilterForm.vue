<script setup>
import Status from "@/Shared/Admin/Table/Filters/Status.vue";

defineProps({
    form: Object,
    filters: Object,
});
</script>

<template>
    <Status :form="form" />
</template>
