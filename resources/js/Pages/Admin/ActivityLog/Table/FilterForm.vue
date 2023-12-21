<script setup>
import MultiSelect from "@/Shared/Form/MultiSelect.vue";
import Input from "@/Shared/Form/Input.vue";

defineProps({
    form: Object,
    filters: Object,
});
</script>

<template>
    <MultiSelect
        :label="$t('admin.activity_log.filters.log_types')"
        v-model="form.log_types"
        :options="filters.logTypes"
        name="log-types"
        multiple
    />
    <Input
        v-model="form.ip"
        :label="$t('admin.activity_log.filters.ip')"
        name="ip"
    />
    <MultiSelect
        :label="$t('admin.activity_log.filters.http_methods')"
        v-model="form.http_methods"
        :options="filters.httpMethods"
        name="https-methods"
        multiple
    />
    <Input
        v-model="form.causer_name"
        :label="$t('admin.activity_log.filters.causer_name')"
        name="causer-name"
    />
</template>
