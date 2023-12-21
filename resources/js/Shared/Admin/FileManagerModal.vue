<script setup>
import Modal from "@/Shared/Modal/Index.vue";
import Content from "@/Shared/Modal/Content.vue";
import Header from "@/Shared/Modal/Header.vue";
import FileManager from "@/Pages/Admin/Media/FileManager.vue";
import { onBeforeMount, reactive } from "vue";

const state = reactive({
    show: false,
    mime: null,
    isSinglePicker: true,
});

onBeforeMount(() => {
    window.showFileManager = ({ mime, isSinglePicker }) => {
        state.mime = mime;
        state.isSinglePicker = isSinglePicker;
        showModal();
    };

    window.hideFileManager = () => {
        state.mime = null;
        state.isSinglePicker = true;
        closeModal();
    };
});

const closeModal = () => {
    state.show = false;
};

const showModal = () => {
    state.show = true;
};
</script>

<template>
    <Modal
        id="fileManagerModal"
        maxWidth="xl"
        :show="state.show"
        @close="closeModal"
    >
        <Content modalBodyPadding0>
            <template #header>
                <Header :title="$t('admin.media.file_manager.title')" />
            </template>
            <template #body>
                <iframe
                    v-if="state.show"
                    frameborder="0"
                    :src="
                        route('admin.file_manager.index', {
                            mime: state.mime,
                            isSinglePicker: state.isSinglePicker,
                        })
                    "
                ></iframe>
            </template>
        </Content>
    </Modal>
</template>

<style scoped>
iframe {
    width: 100%;
    height: 80vh;
}
</style>
