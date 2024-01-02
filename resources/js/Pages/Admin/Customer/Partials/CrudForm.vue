<script setup>
import { useForm } from "@inertiajs/vue3";
import FormTabs from "@/Shared/Admin/FormTabs/Index.vue";
import GeneralTab from "../Tabs/General.vue";
import PasswordTab from "../Tabs/Password.vue";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const props = defineProps({ tabs: Object, action: String, user: Object });
const form = useForm({
    username: props.user.username,
    name: props.user.name,
    password: "",
    password_confirmation: "",
    email: props.user.email,
    is_active: props.user.is_active,
    roles: props.user.current_roles,
    _method: props.action == "store" ? "POST" : "PUT",
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        is_active: form.is_active ? true : false,
    })).post(route(`admin.users.${props.action}`, props.user.id), {
        errorBag: "SaveUser",
        preserveState: true,
        onSuccess: () => {
            toast.success(
                trans("messages.resource_saved", {
                    resource: trans("admin.users.user"),
                })
            );
        },
    });
};
</script>
<template>
    <FormTabs
        :tabs="tabs"
        :components="{
            General: GeneralTab,
            Password: PasswordTab,
        }"
        :form="form"
        :submit="submit"
        :entity="user"
    />
</template>
