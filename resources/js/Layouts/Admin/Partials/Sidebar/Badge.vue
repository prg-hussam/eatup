<script setup>
defineProps({ badge: Object });
</script>

<template>
  <span class="badge badge-pill" :class="`bg-${badge.class}`" data-key="t-new">
    {{ badge.value }}
  </span>
</template>