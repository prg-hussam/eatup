<script setup>
defineProps({ tab: Object, activeId: String });
</script>

<template>
  <a
    class="nav-link"
    :id="`custom-v-pills-${tab.name}-tab`"
    data-bs-toggle="pill"
    :href="`#custom-v-pills-${tab.name}`"
    role="tab"
    :aria-controls="`custom-v-pills-${tab.name}`"
    :aria-selected="tab.isActive"
    :class="[
      (tab.isActive && !activeId) ||
      (tab.isActive && activeId == `custom-v-pills-${tab.name}-tab`) ||
      (tab.hasError && activeId == `custom-v-pills-${tab.name}-tab`)
        ? 'active'
        : '',
      tab.hasError ? 'has-error' : '',
    ]"
  >
    {{ $t(tab.label) }}
  </a>
</template>

<style scoped>
.nav-link {
  padding: 0.8rem 1rem;
}
.has-error:not(.active) {
  border-left: 3px solid #f06548;
  color: #f06548;
}
</style>