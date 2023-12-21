<script setup>
import Modal from "@/Shared/Modal/Index.vue";
import Content from "@/Shared/Modal/Content.vue";
import Footer from "@/Shared/Modal/Footer.vue";
import Header from "@/Shared/Modal/Header.vue";
import Dropzone from "../Partials/Dropzone.vue";
defineProps({
    show: Boolean,
    folderId: Number,
});

const emits = defineEmits(["close", "refresh"]);
const success = () => {
    emits("refresh");
};
</script>
<template>
    <Modal
        id="uploadFilesModal"
        :show="show"
        maxWidth="lg"
        @close="$emit('close')"
    >
        <Content>
            <template #header>
                <Header :title="$t('admin.media.upload_files')" />
            </template>
            <template #body>
                <Dropzone v-if="show" :folderId="folderId" @success="success" />
            </template>
        </Content>
    </Modal>
</template>
