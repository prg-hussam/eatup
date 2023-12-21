<script setup>
import { computed } from "vue";
const props = defineProps({ method: String });
const color = computed(() => {
  switch (props.method) {
    case "POST":
      return "success";
    case "DELETE":
      return "danger";
    case "PUT":
      return "info";
    case "GET":
      return "primary";
    default:
      return "secondary";
  }
});
</script>

<template>
  <span class="badge" :class="`badge-soft-${color}`">{{ method }}</span>
</template>

