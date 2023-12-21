<script setup>
import Group from "./Partials/Group.vue";
defineProps({
  boxes: Object,
});
</script>

<template>
  <Group
    v-for="(group, key) in boxes.groups"
    :key="key"
    :boxes="boxes.boxes[key]"
    :title="group.title"
  />
</template>