<script setup>
import { watch } from "vue";

const emits = defineEmits(["search", "update:modelValue"]);
const props = defineProps({
    loading: Boolean,
    modelValue: String,
    disabled: Boolean,
});

const filter = () => {
    emits("search", false, 0, true);
};

watch(
    () => props.modelValue,
    (show, prevShow) => {
        filter();
    }
);
</script>
<template>
    <div class="search-box">
        <div v-if="loading" class="overview">
            <span class="spinner-border text-primary" role="status"> </span>
        </div>
        <input
            @input="$emit('update:modelValue', $event.target.value)"
            type="text"
            class="form-control"
            :value="modelValue"
            :disabled="disabled"
            :placeholder="$t('admin.media.search_in_current_folder')"
        />
        <i class="mdi mdi-magnify search-icon"></i>
    </div>
</template>

<style scoped>
.search-box {
    position: relative;
}

.overview {
    position: absolute;
    right: 10px;
    top: 8px;
}
.spinner-border {
    width: 1.3rem;
    height: 1.3rem;
    border-width: 0.19em;
}
</style>
