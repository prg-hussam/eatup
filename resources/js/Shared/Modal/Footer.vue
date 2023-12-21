<script setup>
import LoadingButton from "@/Shared/Form/LoadingButton.vue";
defineProps({
  loading: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  saveTitle: String,
});
</script>

<template>
  <button type="button" class="btn btn-light" data-bs-dismiss="modal">
    {{ $t("global.buttons.cancel") }}
  </button>
  <LoadingButton
    class="btn-primary"
    :title="saveTitle || $t('global.buttons.save')"
    :loading="loading"
    :disabled="disabled || loading"
  />
</template>