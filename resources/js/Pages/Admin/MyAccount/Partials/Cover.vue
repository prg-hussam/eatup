
<script setup>
import ProfileBg from "/resources/images/profile-bg.jpeg";
</script>

<template>
  <div class="position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg profile-setting-img">
      <img :src="ProfileBg" class="profile-wid-img" alt="" />
      <div class="overlay-content"></div>
    </div>
  </div>
</template>


