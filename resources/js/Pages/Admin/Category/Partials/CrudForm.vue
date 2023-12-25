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
    category: Object,
});

const form = useForm({
    name: props.category.name || {},
    is_active: props.category.is_active,

    _method: props.action == "store" ? "POST" : "PUT",
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        is_active: form.is_active ? true : false,
    })).post(route(`admin.categories.${props.action}`, props.category.id), {
        errorBag: "SaveCategory",
        preserveState: true,
        onSuccess: () => {
            toast.success(
                trans("messages.resource_saved", {
                    resource: trans("admin.categories.category"),
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
        :entity="category"
    />
</template>
