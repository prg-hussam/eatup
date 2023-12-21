<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
  title: String,
  routeName: String,
  active: Boolean,
});
</script>

<template>
  <li :class="active ? 'active' : ''" class="breadcrumb-item">
    <span v-if="active">{{ title }}</span>
    <Link v-else :href="route(routeName)">{{ title }}</Link>
  </li>
</template>
