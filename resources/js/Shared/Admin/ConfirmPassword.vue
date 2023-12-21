<script setup>
import Content from "@/Shared/Modal/Content.vue";
import Footer from "@/Shared/Modal/Footer.vue";
import Modal from "@/Shared/Modal/Index.vue";
import Input from "@/Shared/Form/Input.vue";
import { ref, reactive, nextTick } from "vue";

const emits = defineEmits(["confirmed"]);

const show = ref(false);
const passwordInput = ref(null);

const form = reactive({
    password: "",
    error: "",
    processing: false,
});

const props = defineProps({
    title: String,
    content: String,
    button: String,
    disabled: {
        type: Boolean,
        default: false,
    },
    alwaysShow: {
        type: Boolean,
        default: false,
    },
    id: {
        type: String,
        required: true,
    },
});

const startConfirmingPassword = () => {
    if (props.disabled) {
        return;
    }
    if (props.alwaysShow) {
        showModal();
        return;
    }
    axios.get(route("password.confirmation")).then((response) => {
        if (response.data.confirmed) {
            emits("confirmed");
        } else {
            showModal();
        }
    });
};

const confirmPassword = () => {
    form.processing = true;

    axios
        .post(route("password.confirm"), {
            password: form.password,
        })
        .then(() => {
            form.processing = false;
            let params = {};
            if (props.alwaysShow) {
                params = { password: form.password };
            }
            closeModal();
            nextTick().then(() => emits("confirmed", params));
        })
        .catch((error) => {
            form.processing = false;
            form.error = error.response.data.errors.password[0];
            passwordInput.value.focus();
        });
};

const closeModal = () => {
    form.password = "";
    form.error = "";
    show.value = false;
};

const showModal = () => {
    form.password = "";
    form.error = "";
    show.value = true;

    setTimeout(() => passwordInput.value.focus(), 500);
};
</script>

<template>
    <span @click="startConfirmingPassword">
        <slot />
    </span>
    <Modal :id="id" :show="show" @close="closeModal">
        <form @submit.prevent="confirmPassword">
            <Content>
                <template #body>
                    <h5 class="fs-15">
                        {{ title || $t("global.confirm_password_title") }}
                    </h5>
                    <p class="text-muted">
                        {{ content || $t("global.confirm_password_message") }}
                    </p>
                    <Input
                        v-model="form.password"
                        ref="passwordInput"
                        :error="form.error"
                        :placeholder="
                            $t('admin.my_account.attributes.password')
                        "
                        type="password"
                    />
                </template>
                <template #footer>
                    <Footer
                        :saveTitle="button || $t('global.buttons.confirm')"
                        :loading="form.processing"
                        :disabled="form.processing || !form.password"
                    />
                </template>
            </Content>
        </form>
    </Modal>
</template>
