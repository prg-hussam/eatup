<script setup>
defineEmits(["clickItem"]);
defineProps({
  items: Array,
  folderId: Number,
});
</script>
<template>
  <div
    class="page-title-box d-sm-flex align-items-center justify-content-between"
  >
    <ol class="breadcrumb m-0">
      <li v-if="items.length > 0" class="breadcrumb-item">
        <span
          role="button"
          @click="$emit('clickItem', { is_folder: true, is_home: true }, true)"
        >
          <i class="bx bx-home-alt"></i>
        </span>
      </li>

      <li
        v-for="item in items"
        class="breadcrumb-item"
        :class="{ active: item.id == folderId }"
        :key="item.id"
      >
        <span v-if="item.id == folderId">{{ item.filename }}</span>
        <span v-else role="button" @click="$emit('clickItem', item, true)">
          {{ item.filename }}
        </span>
      </li>
    </ol>
  </div>
</template>

<style scoped>
.page-title-box {
  margin: -16px 1rem 0 -1rem;
  box-shadow: none;
}
</style>