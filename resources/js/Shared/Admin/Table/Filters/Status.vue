
<script setup>
import MultiSelect from "@/Shared/Form/MultiSelect.vue";
defineProps({
  form: Object,
});
</script>
<template>
  <MultiSelect
    :label="$t('global.statuses')"
    v-model="form.statuses"
    :options="[
      { id: 1, name: $t('global.active') },
      { id: 0, name: $t('global.inactive') },
    ]"
    name="statuses"
    multiple
  />
</template>



