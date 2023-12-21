<script setup>
import LoadingButton from "@/Shared/Form/LoadingButton.vue";
import useAuth from "@/Uses/auth";
defineEmits(["showCreateFolderModal", "showUploadFilesModal", "refresh"]);
defineProps({ refreshing: Boolean, disabled: Boolean });
const { can } = useAuth();
</script>

<template>
    <LoadingButton
        @click="$emit('refresh')"
        class="btn-secondary me-2"
        icon="bx bx-refresh"
        :title="$t('admin.media.refresh')"
        :loading="refreshing"
        :disabled="disabled || refreshing"
    />
    <button
        :disabled="disabled"
        @click="$emit('showUploadFilesModal')"
        v-if="can('admin.media.create')"
        class="btn btn-label btn-success me-2"
    >
        <i class="label-icon align-middle fs-16 me-2 bx bx-cloud-upload"></i>
        {{ $t("admin.media.upload_files") }}
    </button>
    <button
        :disabled="disabled"
        @click="$emit('showCreateFolderModal')"
        v-if="can('admin.media.create')"
        class="btn btn-label btn-primary"
    >
        <i class="label-icon align-middle fs-16 me-2 bx bx-folder"></i>
        {{ $t("admin.media.create_folder") }}
    </button>
</template>
