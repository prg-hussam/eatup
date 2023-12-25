<script setup>
import MultiSelect from "@/Shared/Form/MultiSelect.vue";
import Status from "@/Shared/Admin/Table/Filters/Status.vue";

defineProps({
    form: Object,
    filters: Object,
});
</script>

<template>
    <Status :form="form" />
    <MultiSelect
        :label="$t('admin.meals.filters.categories')"
        v-model="form.categories"
        :options="filters.categories"
        name="categories"
        multiple
    />
    <MultiSelect
        :label="$t('admin.meals.filters.dining_periods')"
        v-model="form.diningPeriods"
        :options="filters.diningPeriods"
        name="diningPeriods"
        multiple
    />
    <MultiSelect
        :label="$t('admin.meals.filters.types')"
        v-model="form.types"
        :options="filters.types"
        name="types"
        multiple
    />
</template>
