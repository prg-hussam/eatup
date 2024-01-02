<script setup>
import { useForm } from "@inertiajs/vue3";
import FormTabs from "@/Shared/Admin/FormTabs/Index.vue";
import GeneralTab from "../Tabs/General.vue";
import PricingTab from "../Tabs/Pricing.vue";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const props = defineProps({
    tabs: Object,
    action: String,
    plan: Object,
});

const form = useForm({
    name: props.plan.name || {},
    duration: props.plan.duration,
    is_active: props.plan.is_active,
    prices: props.plan.plan_prices || [],
    _method: props.action == "store" ? "POST" : "PUT",
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        is_active: form.is_active ? true : false,
    })).post(route(`admin.plans.${props.action}`, props.plan.id), {
        errorBag: "SavePlan",
        preserveState: true,
        onSuccess: () => {
            toast.success(
                trans("messages.resource_saved", {
                    resource: trans("admin.plans.plan"),
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
            Pricing: PricingTab,
        }"
        :form="form"
        :submit="submit"
        :entity="plan"
    />
</template>
