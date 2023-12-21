<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const errors = computed(() => usePage().props.errors);
const hasErrors = computed(() => Object.keys(errors.value).length > 0);
</script>

<template>
  <div v-if="hasErrors">
    <div
      class="
        alert alert-danger alert-top-border alert-dismissible
        shadow
        fade
        show
        mb-2
      "
    >
      {{ Object.values(errors)[0] }}
    </div>
  </div>
</template>
