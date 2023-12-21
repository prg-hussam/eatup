<script setup>
import Item from "./Item.vue";
defineProps({ group: Object });
</script>

<template>
  <li v-if="group.group.should_show_heading" class="menu-title">
    <span>{{ $t(group.group.name) }}</span>
  </li>
  <Item v-for="(item, index) in group.items" :key="index" :item="item" />
</template>