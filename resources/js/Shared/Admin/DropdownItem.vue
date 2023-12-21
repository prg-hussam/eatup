
<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
  title: String,
  icon: String,
  href: String,
  as: {
    type: String,
    default: "a",
  },
});
</script>

<template>
  <Link v-if="as == 'a'" class="dropdown-item" :href="href">
    <i :class="icon" class="text-muted fs-16 align-middle me-1"></i>
    <span class="align-middle">{{ title }}</span>
  </Link>

  <button v-else-if="as == 'button'" type="submit" class="dropdown-item">
    <i :class="icon" class="text-muted fs-16 align-middle me-1"></i>
    <span class="align-middle">{{ title }}</span>
  </button>
</template>
