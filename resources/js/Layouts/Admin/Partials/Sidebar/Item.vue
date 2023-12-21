<script setup>
import { Link } from "@inertiajs/vue3";
import Badge from "./Badge.vue";

defineProps({ item: Object });
</script>

<template>
  <li class="nav-item">
    <Link
      :href="
        item.item.has_items
          ? '#' + item.item.name.replaceAll('.', '-')
          : item.item.url
      "
      :data-bs-toggle="item.item.has_items ? 'collapse' : ''"
      :role="item.item.has_items ? 'button' : ''"
      class="nav-link menu-link"
      :class="{ 'collapsed active': item.active }"
      :aria-expanded="item.item.has_items ? 'false' : ''"
      :aria-controls="item.item.has_items ? item.name : ''"
    >
      <i :class="item.item.icon"></i>
      <span>{{ $t(item.item.name) }}</span>
      <Badge
        v-for="(badge, index) in item.badges"
        :key="index"
        :badge="badge"
      />
    </Link>
    <div
      v-if="item.item.has_items"
      class="collapse menu-dropdown"
      :class="{ show: item.active }"
      :id="item.item.name.replaceAll('.', '-')"
    >
      <ul class="nav nav-sm flex-column">
        <li
          v-for="(subItem, index) in item.items"
          :key="index"
          class="nav-item"
        >
          <Link
            :class="{ active: subItem.active }"
            class="nav-link"
            :href="subItem.item.url"
          >
            {{ $t(subItem.item.name) }}
            <Badge
              v-for="(badge, index) in subItem.badges"
              :key="index"
              :badge="badge"
            />
          </Link>
        </li>
      </ul>
    </div>
  </li>
</template>