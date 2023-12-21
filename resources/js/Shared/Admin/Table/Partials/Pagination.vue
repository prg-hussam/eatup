<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  meta: Object,
  links: Object,
});
</script>

<template>
  <div
    v-if="meta.total > 0"
    class="align-items-center pb-0 row g-3 text-center text-sm-start"
  >
    <div class="col-sm">
      <div class="text-muted">
        {{ $t("global.table.showing") }}
        <span class="fw-semibold">{{ meta.from }}</span>
        {{ $t("global.table.to") }}
        <span class="fw-semibold">{{ meta.to }}</span>
        {{ $t("global.table.of") }}
        <span class="fw-semibold">{{ meta.total }}</span>
        {{ $t("global.table.entries") }}
      </div>
    </div>
    <div class="col-sm-auto">
      <ul
        class="
          pagination pagination-separated pagination-sm
          justify-content-center justify-content-sm-start
          mb-0
        "
      >
        <li
          v-for="(link, index) in meta.links"
          :key="index"
          class="page-item"
          :class="{
            disabled: !link.url,
            active: link.active,
          }"
        >
          <Link
            :href="link.url ? link.url : '#'"
            v-html="link.label"
            class="page-link"
          />
        </li>
      </ul>
    </div>
  </div>
</template>
