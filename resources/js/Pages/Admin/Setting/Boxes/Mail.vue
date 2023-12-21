<script setup>
import Content from "@/Shared/Modal/Content.vue";
import Footer from "@/Shared/Modal/Footer.vue";
import Header from "@/Shared/Modal/Header.vue";
import Input from "@/Shared/Form/Input.vue";
import MultiSelect from "@/Shared/Form/MultiSelect.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const emits = defineEmits(["closeModal"]);
const props = defineProps(["title", "name", "encryptionProtocols", "settings"]);

const form = useForm({
    mail_from_address: props.settings.mail_from_address,
    mail_from_name: props.settings.mail_from_name,
    mail_host: props.settings.mail_host,
    mail_port: props.settings.mail_port,
    mail_username: props.settings.mail_username,
    mail_password: props.settings.mail_password,
    mail_encryption: props.settings.mail_encryption,
});

const submit = () => {
    form.put(route("admin.settings.update", { name: props.name }), {
        errorBag: "UpdateSetting",
        preserveState: true,
        onSuccess: () => {
            toast.success(trans("messages.settings_have_been_saved"));
            emits("closeModal");
        },
    });
};
</script>
<template>
    <form @submit.prevent="submit">
        <Content>
            <template #header>
                <Header :title="$t(title)" />
            </template>
            <template #body>
                <Input
                    v-model="form.mail_from_address"
                    :error="form.errors.mail_from_address"
                    :label="$t('admin.settings.attributes.mail_from_address')"
                    name="mail_from_address"
                    type="email"
                />
                <Input
                    v-model="form.mail_from_name"
                    :error="form.errors.mail_from_name"
                    :label="$t('admin.settings.attributes.mail_from_name')"
                    name="mail_from_name"
                />
                <Input
                    v-model="form.mail_host"
                    :error="form.errors.mail_host"
                    :label="$t('admin.settings.attributes.mail_host')"
                    name="mail_host"
                />
                <Input
                    v-model="form.mail_port"
                    :error="form.errors.mail_port"
                    :label="$t('admin.settings.attributes.mail_port')"
                    name="mail_port"
                />
                <Input
                    v-model="form.mail_username"
                    :error="form.errors.mail_username"
                    :label="$t('admin.settings.attributes.mail_username')"
                    name="mail_username"
                />
                <Input
                    v-model="form.mail_password"
                    :error="form.errors.mail_password"
                    :label="$t('admin.settings.attributes.mail_password')"
                    type="password"
                    name="mail_password"
                />
                <MultiSelect
                    :label="$t('admin.settings.attributes.mail_encryption')"
                    :error="form.errors.mail_encryption"
                    v-model="form.mail_encryption"
                    name="mail_encryption"
                    :closeOnSelect="true"
                    :options="encryptionProtocols"
                />
            </template>
            <template #footer>
                <Footer :loading="form.processing" />
            </template>
        </Content>
    </form>
</template>
