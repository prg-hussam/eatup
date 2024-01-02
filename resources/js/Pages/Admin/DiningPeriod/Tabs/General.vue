<script setup>
import Input from "@/Shared/Form/Input.vue";
import Checkbox from "@/Shared/Form/Checkbox.vue";
import useGeneral from "@/Uses/general";
import MultiSelect from "@/Shared/Form/MultiSelect.vue";

defineProps({
    form: Object,
    tab: Object,
    entity: Object,
    formLocale: String,
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
                $t('admin.dining_periods.attributes.name') +
                ` ( ${supportedLocales[formLocale].name} )`
            "
            name="name"
        />

        <MultiSelect
            :label="$t('admin.dining_periods.attributes.categories')"
            :error="form.errors.categories"
            v-model="form.categories"
            :options="tab.data.categories"
            name="categories"
            asterisk
            multiple
        />

        <Checkbox
            class="mt-3"
            v-model:checked="form.is_active"
            id="is_active"
            :label="$t('admin.dining_periods.attributes.is_active')"
        />
    </div>
</template>
