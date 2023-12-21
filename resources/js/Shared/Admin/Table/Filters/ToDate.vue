
<script setup>
import DateTimePicker from "@/Shared/Form/DateTimePicker.vue";
defineProps({
  form: Object,
});
</script>

<template>
  <DateTimePicker :label="$t('global.to_date')" v-model="form.to" name="to" />
</template>



