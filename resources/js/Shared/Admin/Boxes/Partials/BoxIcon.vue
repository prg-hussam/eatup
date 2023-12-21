<script setup>
defineProps({
    // "svg", "url", "font", "asset"
    icon: Object,
});
</script>
<template>
    <div
        v-if="icon.type == 'asset' || icon.type == 'url' || icon.type == 'svg'"
        class="mx-auto avatar-md mb-3"
    >
        <img :src="icon.icon" alt="" class="img-fluid svg-img" />
    </div>
    <div v-if="icon.type == 'font'">
        <i :class="icon.icon" style="font-size: 3.5rem"></i>
    </div>
</template>
