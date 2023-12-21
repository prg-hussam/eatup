<script setup>
import useGeneral from "@/Uses/general";
import Group from "./Group.vue";
const { adminSidebar } = useGeneral();
</script>

<template>
    <div class="container-fluid">
        <ul class="navbar-nav h-100" id="navbar-nav">
            <Group
                v-for="(group, index) in adminSidebar"
                :key="index"
                :group="group"
            />
        </ul>
    </div>
</template>
