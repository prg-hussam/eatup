<script setup>
defineProps({
  status: Boolean,
});
</script>

<template>
  <span :class="status ? 'text-success' : 'text-danger'">
    <i
      class="mdi fs-17 align-middle"
      :class="
        status
          ? 'mdi-checkbox-marked-circle-outline'
          : 'mdi-close-circle-outline'
      "
    ></i
    >&nbsp;
    {{ $t("global." + (status ? "active" : "inactive")) }}
  </span>
</template>
