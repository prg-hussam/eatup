<script setup>
import { useForm } from "@inertiajs/vue3";
import FormTabs from "@/Shared/Admin/FormTabs/Index.vue";
import GeneralTab from "../Tabs/General.vue";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const props = defineProps({
    tabs: Object,
    action: String,
    menu: Object,
});

const form = useForm({
    name: props.menu.name || {},
    is_active: props.menu.is_active,
    is_default: props.menu.is_default,

    _method: props.action == "store" ? "POST" : "PUT",
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        is_active: form.is_active ? true : false,
        is_default: form.is_default ? true : false,
    })).post(route(`admin.menus.${props.action}`, props.menu.id), {
        errorBag: "SaveMenu",
        preserveState: true,
        onSuccess: () => {
            toast.success(
                trans("messages.resource_saved", {
                    resource: trans("admin.menus.menu"),
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
        }"
        :form="form"
        :submit="submit"
        :entity="menu"
    />
</template>
