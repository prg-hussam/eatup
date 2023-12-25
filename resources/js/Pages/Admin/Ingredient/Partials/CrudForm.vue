<script setup>
import { useForm } from "@inertiajs/vue3";
import FormTabs from "@/Shared/Admin/FormTabs/Index.vue";
import GeneralTab from "../Tabs/General.vue";
import IconTab from "../Tabs/Icon.vue";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const props = defineProps({
    tabs: Object,
    action: String,
    ingredient: Object,
});
const form = useForm({
    name: props.ingredient.name || {},
    is_active: props.ingredient.is_active,
    times: props.ingredient.times || [],
    files: {
        icon: props.ingredient.icon?.id,
    },
    _method: props.action == "store" ? "POST" : "PUT",
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        is_active: form.is_active ? true : false,
    })).post(route(`admin.ingredients.${props.action}`, props.ingredient.id), {
        errorBag: "SaveIngredient",
        preserveState: true,
        onSuccess: () => {
            toast.success(
                trans("messages.resource_saved", {
                    resource: trans("admin.ingredients.ingredient"),
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
            Icon: IconTab,
        }"
        :form="form"
        :submit="submit"
        :entity="ingredient"
    />
</template>
