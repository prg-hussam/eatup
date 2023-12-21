<script setup>
defineProps({
  type: {
    type: String,
    default: "submit",
  },
  title: String,
  loading: Boolean,
  icon: String,
});
</script>

<template>
  <button
    :type="type"
    :disabled="loading"
    class="btn btn-load btn-primary"
    :class="{ 'btn-label': icon }"
  >
    <div class="d-flex align-items-center">
      <div v-if="icon" class="flex-shrink-0">
        <i class="label-icon align-middle fs-16 me-2" :class="icon"></i>
      </div>
      <div class="flex-grow-1" :class="{ 'me-2': loading }">
        {{ title }}
      </div>
      <span v-if="loading" class="spinner-border flex-shrink-0" role="status">
        <span class="visually-hidden">Loading...</span>
      </span>
    </div>
  </button>
</template>

