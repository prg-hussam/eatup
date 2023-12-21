<script setup>
import { computed } from "vue";
const props = defineProps({ type: String, action: String });
const color = computed(() => {
  switch (props.action) {
    case "store":
      return "success";
    case "destroy":
      return "danger";
    case "update":
      return "info";
    case "login":
      return "primary";
    case "logout":
      return "warning";
    default:
      return "primary";
  }
});
</script>

<template>
  <span class="badge" :class="`badge-soft-${color}`">{{ type }}</span>
</template>

