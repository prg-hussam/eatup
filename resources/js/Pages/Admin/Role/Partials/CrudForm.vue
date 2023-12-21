<script setup>
import { useForm } from "@inertiajs/vue3";
import FormTabs from "@/Shared/Admin/FormTabs/Index.vue";
import GeneralTab from "../Tabs/General.vue";
import PermissionsTab from "../Tabs/Permissions.vue";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const props = defineProps({
    tabs: Object,
    action: String,
    role: Object,
    permissionNames: {
        type: Array,
        default: [],
    },
});

const form = useForm({
    name: props.role.name,
    display_name:
        props.role.original_display_name != null
            ? JSON.parse(props.role.original_display_name)
            : {},
    permissions: props.permissionNames,
    _method: props.action == "store" ? "POST" : "PUT",
});

const submit = () => {
    form.post(route(`admin.roles.${props.action}`, props.role.id), {
        errorBag: "SaveRole",
        preserveState: true,
        onSuccess: () => {
            toast.success(
                trans("messages.resource_saved", {
                    resource: trans("admin.roles.role"),
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
            Permissions: PermissionsTab,
        }"
        :form="form"
        :submit="submit"
        :entity="role"
    />
</template>
