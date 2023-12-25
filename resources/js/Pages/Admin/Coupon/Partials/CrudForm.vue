<script setup>
import { useForm } from "@inertiajs/vue3";
import FormTabs from "@/Shared/Admin/FormTabs/Index.vue";
import GeneralTab from "../Tabs/General.vue";
import UsageLimitsTab from "../Tabs/UsageLimits.vue";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const props = defineProps({
    tabs: Object,
    action: String,
    coupon: Object,
});

const form = useForm({
    name: props.coupon.name || {},
    code: props.coupon.code,
    discount_type: props.coupon?.discount_type,
    value: props.coupon?.value
        ? props.coupon?.discount_type == "percent"
            ? props.coupon?.value
            : props.coupon?.value.amount
        : null,
    is_active: props.coupon.is_active,
    meta: props.coupon?.meta || {
        limitations: {
            per_coupon: null,
            per_customer: null,
        },
    },
    _method: props.action == "store" ? "POST" : "PUT",
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        is_active: form.is_active ? true : false,
    })).post(route(`admin.coupons.${props.action}`, props.coupon.id), {
        errorBag: "SaveCoupon",
        preserveState: true,
        onSuccess: () => {
            toast.success(
                trans("messages.resource_saved", {
                    resource: trans("admin.coupons.coupon"),
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
            UsageLimits: UsageLimitsTab,
        }"
        :form="form"
        :submit="submit"
        :entity="coupon"
    />
</template>
