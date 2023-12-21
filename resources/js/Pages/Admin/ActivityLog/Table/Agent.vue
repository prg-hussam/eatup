<script setup>
defineProps({ agent: Object });
</script>

<template>
  <div v-if="agent">
    <i
      class="bx"
      :class="{
        'bx-mobile': !agent.is_desktop,
        'bx-desktop': agent.is_desktop,
      }"
    ></i>
    {{ agent.platform }}
    -
    {{ agent.browser }}
  </div>
</template>

