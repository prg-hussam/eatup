<script setup>
import useGeneral from "@/Uses/general";
const { copyRightText, setting } = useGeneral();
</script>
<template>
  <footer class="footer">
    <div class="container-fluid">
      <div class="row justify-content-between">
        <div v-html="copyRightText" class="col-sm-6"></div>
        <div class="col-sm-6">
          <div class="text-sm-end d-none d-sm-block">
            {{ new Date().getFullYear() }} &copy; {{ setting("app_name") }}
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>
