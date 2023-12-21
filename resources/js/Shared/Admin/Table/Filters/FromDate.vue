
<script setup>
import DateTimePicker from "@/Shared/Form/DateTimePicker.vue";
defineProps({
  form: Object,
});
</script>

<template>
  <DateTimePicker
    :label="$t('global.from_date')"
    v-model="form.from"
    name="from"
  />
</template>



