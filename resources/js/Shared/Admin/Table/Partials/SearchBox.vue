<script setup>
import { ref, watch } from "vue";

defineProps({
  options: Object,
  loading: Boolean,
});

const emits = defineEmits(["search"]);
const searchText = ref(route().params?.search);

watch(
  () => searchText.value,
  (show, prevShow) => {
    emits("search", { searchText });
  }
);
</script>

<template>
  <div class="search-box">
    <div v-if="loading" class="overview">
      <span class="spinner-border text-primary" role="status"> </span>
    </div>
    <input
      v-model="searchText"
      type="text"
      class="form-control"
      :placeholder="
        options.searchPlaceholder || $t('global.search_placeholder')
      "
    />
    <i class="mdi mdi-magnify search-icon"></i>
  </div>
</template>

<style scoped>
.search-box {
  position: relative;
}

.overview {
  position: absolute;
  right: 10px;
  top: 8px;
}
.spinner-border {
  width: 1.3rem;
  height: 1.3rem;
  border-width: 0.19em;
}
</style>