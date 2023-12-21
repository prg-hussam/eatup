<script setup>
import Input from "@/Shared/Form/Input.vue";
import useGeneral from "@/Uses/general";

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
            v-model="form.name"
            :disabled="entity.is_native"
            :error="form.errors.name"
            :label="$t('admin.roles.attributes.name')"
            name="name"
        />
        <Input
            asterisk
            v-model="form.display_name[formLocale]"
            :error="form.errors[`display_name.${formLocale}`]"
            :label="
                $t('admin.roles.attributes.display_name') +
                ` ( ${supportedLocales[formLocale].name} )`
            "
            name="display_name"
        />
    </div>
</template>
