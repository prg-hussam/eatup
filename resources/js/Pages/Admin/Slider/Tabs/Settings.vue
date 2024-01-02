<script setup>
import Input from "@/Shared/Form/Input.vue";
import Checkbox from "@/Shared/Form/Checkbox.vue";
import useGeneral from "@/Uses/general";

defineProps({
    form: Object,
    tab: Object,
    entity: Object,
    formLocale: String,
});
const { supportedLocales } = useGeneral();
</script>

<template>
    <Input
        asterisk
        v-model="form.name[formLocale]"
        :error="form.errors[`name.${formLocale}`]"
        :label="
            $t('admin.sliders.attributes.name') +
            ` ( ${supportedLocales[formLocale].name} )`
        "
        name="name"
    />
</template>
