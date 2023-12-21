<script setup>
import Modal from "@/Shared/Modal/Index.vue";
import Content from "@/Shared/Modal/Content.vue";
import Footer from "@/Shared/Modal/Footer.vue";
import Header from "@/Shared/Modal/Header.vue";
import Input from "@/Shared/Form/Input.vue";
import { reactive, ref, watch } from "vue";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const props = defineProps({
    show: Boolean,
    folderId: Number,
});
const toast = useToast();
const emits = defineEmits(["onSuccess", "close"]);
const input = ref(null);
const form = reactive({
    folder_name: "",
    processing: false,
    error: "",
});

const closeModal = () => {
    emits("close");
    form.folder_name = "";
    form.folder_id = null;
    form.processing = false;
    form.error = "";
};

const submit = () => {
    form.processing = true;
    axios
        .post(route("admin.media.folder.store"), {
            folder_name: form.folder_name,
            folder_id: props.folderId,
        })
        .then((response) => {
            toast.success(
                trans("messages.resource_saved", {
                    resource: trans("admin.media.folder"),
                })
            );
            emits("onSuccess", response.data);
            form.processing = false;
            closeModal();
        })
        .catch((error) => {
            try {
                form.error = error.response.data.errors.folder_name[0] || "";
            } catch (e) {}
            form.processing = false;
        });
};

watch(
    () => props.show,
    (show, prevShow) => {
        if (show == true) {
            setTimeout(() => input.value.focus(), 550);
        }
    }
);
</script>
<template>
    <Modal id="createFolderModal" :show="show" @close="closeModal">
        <form @submit.prevent="submit">
            <Content>
                <template #header>
                    <Header :title="$t('admin.media.create_folder')" />
                </template>
                <template #body>
                    <Input
                        asterisk
                        ref="input"
                        v-model="form.folder_name"
                        :error="form.error"
                        :label="$t('admin.media.attributes.folder_name')"
                    />
                </template>
                <template #footer>
                    <Footer :loading="form.processing" />
                </template>
            </Content>
        </form>
    </Modal>
</template>
