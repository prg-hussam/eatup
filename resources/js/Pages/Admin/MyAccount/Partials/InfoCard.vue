<script setup>
import useAuth from "@/Uses/auth";
const { user } = useAuth();
</script>

<template>
  <div class="card mt-n5">
    <div class="card-body p-4">
      <div class="text-center">
        <div class="profile-user position-relative d-inline-block mx-auto mb-4">
          <img
            :src="user.profile_photo_url"
            class="
              rounded-circle
              avatar-xl
              img-thumbnail
              user-profile-image
              shadow
            "
          />
        </div>
        <h5 class="fs-16 mb-1">{{ user.name }}</h5>
        <p class="text-muted mb-0">@{{ user.username }}</p>
      </div>
    </div>
  </div>
</template>


