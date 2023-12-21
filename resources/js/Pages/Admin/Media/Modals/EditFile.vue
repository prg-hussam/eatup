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
    file: Object,
});

const toast = useToast();
const emits = defineEmits(["onSuccess", "close"]);
const input = ref(null);
const form = reactive({
    name: props.file?.filename,
    processing: false,
    error: "",
});

const closeModal = () => {
    emits("close");
    form.processing = false;
    form.error = "";
};

const submit = () => {
    form.processing = true;
    axios
        .put(route("admin.media.update", props.file.id), {
            name: form.name,
        })
        .then((response) => {
            toast.success(
                trans("messages.resource_saved", {
                    resource: trans(
                        `admin.media.${
                            props.file?.is_folder ? "folder" : "file"
                        }`
                    ),
                })
            );
            emits("onSuccess", response.data);
            form.processing = false;
            closeModal();
        })
        .catch((error) => {
            try {
                form.error = error.response.data.errors.name[0] || "";
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
    <Modal id="editFileModal" :show="show" @close="closeModal">
        <form @submit.prevent="submit">
            <Content>
                <template #header>
                    <Header
                        :title="
                            $t('resource.edit', {
                                resource: $t(
                                    `admin.media.${
                                        file?.is_folder ? 'folder' : 'file'
                                    }`
                                ),
                            })
                        "
                    />
                </template>
                <template #body>
                    <Input
                        asterisk
                        ref="input"
                        v-model="form.name"
                        :error="form.error"
                        :label="$t('admin.media.attributes.name')"
                    />
                </template>
                <template #footer>
                    <Footer :loading="form.processing" />
                </template>
            </Content>
        </form>
    </Modal>
</template>
