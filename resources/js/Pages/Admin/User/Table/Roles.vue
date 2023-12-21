<script setup>
defineProps({ roles: Object });
</script>

<template>
<div>
    <div v-if="roles.length != 0">
        <span class="me-1 badge badge-soft-primary" v-for="(role) in roles" :key="role.id">
            <i class="bx bx-shield align-middle"></i>
            {{role.display_name}}
        </span>
    </div>
    <div v-else>-</div>
</div>
</template>

