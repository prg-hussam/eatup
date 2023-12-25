<script setup>
import Input from "@/Shared/Form/Input.vue";

defineProps({
    form: Object,
    tab: Object,
    entity: Object,
    formLocale: String,
});
</script>

<template>
    <Input
        v-model="form.meta.limitations.per_coupon"
        :error="form.errors['meta.limitations.per_coupon']"
        :label="$t('admin.coupons.attributes.meta.limitations.per_coupon')"
        name="meta-limitations-per_coupon"
        type="number"
    />
    <Input
        v-model="form.meta.limitations.per_customer"
        :error="form.errors['meta.limitations.per_customer']"
        :label="$t('admin.coupons.attributes.meta.limitations.per_customer')"
        name="meta-limitations-per_customer"
        type="number"
    />
</template>
