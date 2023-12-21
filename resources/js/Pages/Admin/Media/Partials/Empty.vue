<script setup></script>
<template>
  <div class="empty-container">
    <i class="icon bx bx-images"></i>
    <p class="message">
      {{ $t("messages.no_data_available") }}
    </p>
  </div>
</template>

<style scoped>
.empty-container {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  flex-direction: column;
  width: 100%;
  height: 100%;
}
.icon {
  font-size: 7rem;
  color: #d2d6de;
}
.message {
  margin-top: 10px;
  font-size: 1rem;
  color: #d2d6de;
}
</style>