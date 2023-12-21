<script setup>
defineProps({
    header: String,
});
</script>

<template>
    <div class="dropdown-menu dropdown-menu-end">
        <h6 class="dropdown-header" v-if="header">{{header}}</h6>
        <slot />
    </div>
</template>
