<script setup>
defineProps({
  label: String,
  asterisk: Boolean,
  error: String,
});
</script>

<template>
  <label v-if="label" class="form-label" :class="error ? 'text-danger' : ''">
    {{ label }}
    <span v-if="asterisk" class="text-danger">&#42;</span>
  </label>
</template>
