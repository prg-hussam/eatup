<script setup>
import Input from "@/Shared/Form/Input.vue";
import useGeneral from "@/Uses/general";
import Checkbox from "@/Shared/Form/Checkbox.vue";
import MultiSelect from "@/Shared/Form/MultiSelect.vue";
import DateTimePicker from "@/Shared/Form/DateTimePicker.vue";

defineProps({
    form: Object,
    tab: Object,
    formLocale: String,
    entity: Object,
});
const { supportedLocales } = useGeneral();
</script>

<template>
    <div>
        <Input
            asterisk
            v-model="form.name[formLocale]"
            :error="form.errors[`name.${formLocale}`]"
            :label="
                $t('admin.coupons.attributes.name') +
                ` ( ${supportedLocales[formLocale].name} )`
            "
            name="name"
        />

        <Input
            asterisk
            v-model="form.code"
            :error="form.errors.code"
            :label="$t('admin.coupons.attributes.code')"
            name="code"
        />

        <MultiSelect
            asterisk
            :label="$t('admin.coupons.attributes.discount_type')"
            v-model="form.discount_type"
            :options="tab.data.discountTypes"
            :error="form.errors.discount_type"
            closeOnSelect
        />

        <Input
            asterisk
            v-model="form.value"
            :error="form.errors.value"
            :label="$t('admin.coupons.attributes.value')"
            name="value"
        />
        <DateTimePicker
            :label="$t('admin.coupons.attributes.start_date')"
            v-model="form.start_date"
            name="start_date"
        />

        <DateTimePicker
            :label="$t('admin.coupons.attributes.end_date')"
            v-model="form.end_date"
            name="end_date"
        />

        <Checkbox
            class="mt-3"
            v-model:checked="form.is_active"
            id="is_active"
            :label="$t('admin.coupons.attributes.is_active')"
        />
    </div>
</template>
