<script setup>
import MultiSelect from "@/Shared/Form/MultiSelect.vue";
import Status from "@/Shared/Admin/Table/Filters/Status.vue";

defineProps({
    form: Object,
    filters: Object,
});
</script>

<template>
    <MultiSelect
        :label="$t('admin.users.filters.roles')"
        v-model="form.roles"
        :options="filters.roles"
        name="roles"
        multiple
    />
    <Status :form="form" />
</template>
