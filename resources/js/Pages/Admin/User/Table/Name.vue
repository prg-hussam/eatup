<script setup>
defineProps({
  user: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div class="d-flex">
    <div class="p-1 me-2">
      <img
        :src="user.profile_photo_url"
        :alt="user.name"
        class="avatar-xs bg-light rounded-circle"
      />
    </div>
    <div>
      <h5 class="fs-14 my-1">
        {{ user.name }}
      </h5>
      <span class="d-inline-block mb-1 text-muted"> @{{ user.username }} </span>
      <slot name="actions" />
    </div>
  </div>
</template>
