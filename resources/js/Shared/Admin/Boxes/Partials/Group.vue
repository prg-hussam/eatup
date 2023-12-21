<script setup>
import Box from "./Box.vue";
defineProps({
  title: String,
  boxes: Array,
});
</script>
<template>
  <div class="row">
    <div class="col-12">
      <div class="justify-content-between d-flex align-items-center mt-3 mb-4">
        <h5 class="mb-0 pb-1 text-decoration-underline">{{ $t(title) }}</h5>
      </div>
    </div>
  </div>
  <div class="row">
    <Box v-for="box in boxes" :key="box.name" :box="box" />
  </div>
</template>