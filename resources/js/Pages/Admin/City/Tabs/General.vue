<script setup>
import Input from "@/Shared/Form/Input.vue";
import useGeneral from "@/Uses/general";
import Checkbox from "@/Shared/Form/Checkbox.vue";
import MultiSelect from "@/Shared/Form/MultiSelect.vue";

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
                $t('admin.cities.attributes.name') +
                ` ( ${supportedLocales[formLocale].name} )`
            "
            name="name"
        />
        <MultiSelect
            :label="$t('admin.cities.attributes.province_id')"
            :error="form.errors.province_id"
            v-model="form.province_id"
            :options="tab.data.provinces"
            name="province_id"
            asterisk
            closeOnSelect
        />
        <Checkbox
            class="mt-3"
            v-model:checked="form.is_active"
            id="is_active"
            :label="$t('admin.cities.attributes.is_active')"
        />
    </div>
</template>
