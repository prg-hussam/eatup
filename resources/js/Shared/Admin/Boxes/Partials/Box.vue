<script setup>
import BoxIcon from "./BoxIcon.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  box: Object,
});

const onClickBox = () => {
  if (props.box.is_ajax) {
    router.visitInModal(props.box.url);
  } else if (!props.box.is_open_new_tab) {
    router.get(props.box.url);
  } else {
    window.open(props.box.url, "_blank");
  }
};
</script>
<template>
  <div
    v-if="box.is_authorize"
    @click="onClickBox"
    class="col-xxl-3 col-lg-6"
    role="button"
  >
    <div class="card card-body text-center">
      <BoxIcon :icon="box.icon" />
      <h4 class="card-title">{{ $t(box.label) }}</h4>
      <p class="card-text text-muted text-truncate">
        {{ $t(box.description) }}
      </p>
    </div>
  </div>
</template>