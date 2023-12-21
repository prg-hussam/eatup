<script setup>
defineProps({
  title: String,
});
</script>

<template>
  <h5 class="modal-title" id="boxModalLabel">
    {{ title }}
  </h5>
  <button
    type="button"
    class="btn-close"
    data-bs-dismiss="modal"
    aria-label="Close"
  ></button>
</template>