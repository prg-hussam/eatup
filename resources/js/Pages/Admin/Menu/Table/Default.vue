<script setup>
defineProps({
    isDefault: Boolean,
});
</script>

<template>
    <span :class="isDefault ? 'text-success' : 'text-danger'">
        <i
            class="mdi fs-17 align-middle"
            :class="
                isDefault
                    ? 'mdi-checkbox-marked-circle-outline'
                    : 'mdi-close-circle-outline'
            "
        ></i>
    </span>
</template>
