<script setup>
import { useForm } from "@inertiajs/vue3";
import FormTabs from "@/Shared/Admin/FormTabs/Index.vue";
import GeneralTab from "../Tabs/General.vue";
import IconTab from "../Tabs/Icon.vue";
import TimesTab from "../Tabs/Times.vue";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const props = defineProps({
    tabs: Object,
    action: String,
    diningPeriod: Object,
});
const form = useForm({
    name: props.diningPeriod.name || {},
    is_active: props.diningPeriod.is_active,
    times: props.diningPeriod.times || [],
    files: {
        icon: props.diningPeriod.icon?.id,
    },

    categories:
        typeof props.diningPeriod.categories == "object"
            ? props.diningPeriod.categories.map((category) =>
                  category.id.toString()
              )
            : null,

    _method: props.action == "store" ? "POST" : "PUT",
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        is_active: form.is_active ? true : false,
    })).post(
        route(`admin.dining_periods.${props.action}`, props.diningPeriod.id),
        {
            errorBag: "SaveDiningPeriod",
            preserveState: true,
            onSuccess: () => {
                toast.success(
                    trans("messages.resource_saved", {
                        resource: trans("admin.dining_periods.dining_period"),
                    })
                );
            },
        }
    );
};
</script>
<template>
    <FormTabs
        :tabs="tabs"
        :components="{
            General: GeneralTab,
            Times: TimesTab,
            Icon: IconTab,
        }"
        :form="form"
        :submit="submit"
        :entity="diningPeriod"
    />
</template>
