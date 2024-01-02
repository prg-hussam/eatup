<script setup>
import Input from "@/Shared/Form/Input.vue";
import useGeneral from "@/Uses/general";
import Checkbox from "@/Shared/Form/Checkbox.vue";

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
                $t('admin.menus.attributes.name') +
                ` ( ${supportedLocales[formLocale].name} )`
            "
            name="name"
        />

        <Checkbox
            class="mt-3"
            v-model:checked="form.is_default"
            id="is_default"
            :label="$t('admin.menus.attributes.is_default')"
        />
        <Checkbox
            class="mt-3"
            v-model:checked="form.is_active"
            id="is_active"
            :label="$t('admin.menus.attributes.is_active')"
        />
    </div>
</template>
