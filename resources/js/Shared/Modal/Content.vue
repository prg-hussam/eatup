<script setup>
defineProps({
  modalBodyPadding0: Boolean,
});
</script>

<template>
  <div class="modal-content">
    <div v-if="$slots.header" class="modal-header">
      <slot name="header" />
    </div>
    <div
      v-if="$slots.body"
      class="modal-body"
      :class="{ 'p-0': modalBodyPadding0 }"
    >
      <slot name="body" />
    </div>
    <div v-if="$slots.footer" class="modal-footer">
      <slot name="footer" />
    </div>
  </div>
</template>