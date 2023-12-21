<script setup>
import Content from "@/Shared/Modal/Content.vue";
import Footer from "@/Shared/Modal/Footer.vue";
import Header from "@/Shared/Modal/Header.vue";
import Input from "@/Shared/Form/Input.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const emits = defineEmits(["closeModal"]);
const props = defineProps(["title", "name", "settings"]);

const form = useForm({
    translatable: {
        app_name: props.settings.app_name,
        app_address: props.settings.app_address,
        copyright_text: props.settings.copyright_text,
    },
    app_phone_number: props.settings.app_phone_number,
    app_email: props.settings.app_email,
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
                    asterisk
                    v-model="form.translatable.app_name"
                    :error="form.errors['translatable.app_name']"
                    :label="
                        $t('admin.settings.attributes.translatable.app_name')
                    "
                    name="translatable[app_name]"
                />
                <Input
                    asterisk
                    v-model="form.app_phone_number"
                    :error="form.errors.app_phone_number"
                    :label="$t('admin.settings.attributes.app_phone_number')"
                    name="app_phone_number"
                />
                <Input
                    asterisk
                    v-model="form.app_email"
                    :error="form.errors.app_email"
                    :label="$t('admin.settings.attributes.app_email')"
                    name="app_email"
                />
                <Input
                    asterisk
                    v-model="form.translatable.app_address"
                    :error="form.errors['translatable.app_address']"
                    :label="
                        $t('admin.settings.attributes.translatable.app_address')
                    "
                    name="translatable[app_address]"
                />
                <Input
                    v-model="form.translatable.copyright_text"
                    :error="form.errors['translatable.copyright_text']"
                    :label="
                        $t(
                            'admin.settings.attributes.translatable.copyright_text'
                        )
                    "
                    name="translatable[copyright_text]"
                />
            </template>
            <template #footer>
                <Footer :loading="form.processing" />
            </template>
        </Content>
    </form>
</template>
