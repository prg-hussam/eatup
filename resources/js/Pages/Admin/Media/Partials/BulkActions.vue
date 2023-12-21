<script setup>
import useAuth from "@/Uses/auth";

const props = defineProps({
    disabled: Boolean,
    isPicker: Boolean,
    isSinglePicker: Boolean,
    destroy: Function,
    selectedFiles: Array,
});

const addFiles = () => {
    if (
        props.isPicker &&
        props.isSinglePicker == false &&
        props.selectedFiles.length > 0
    ) {
        window.parent.fileManagerCallback(props.selectedFiles);
    }
};
const { can } = useAuth();
</script>

<template>
    <button
        v-if="isPicker && isSinglePicker == false"
        @click="addFiles"
        :disabled="disabled"
        class="btn btn-label btn-info me-2"
    >
        <i class="label-icon align-middle fs-16 me-2 bx bx-select-multiple"></i>
        {{ $t("admin.media.add_files") }}
    </button>
    <button
        :disabled="disabled"
        @click="destroy"
        v-if="can('admin.media.destroy')"
        class="btn btn-label btn-danger me-2"
    >
        <i class="label-icon align-middle fs-16 me-2 bx bx-trash"></i>
        {{ $t("admin.media.delete") }}
    </button>
</template>
