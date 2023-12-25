<script setup>
import Input from "@/Shared/Form/Input.vue";
import Checkbox from "@/Shared/Form/Checkbox.vue";
import useGeneral from "@/Uses/general";

defineProps({
    form: Object,
    tab: Object,
    ingredient: Object,
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
                $t('admin.ingredients.attributes.name') +
                ` ( ${supportedLocales[formLocale].name} )`
            "
            name="name"
        />
        <Checkbox
            class="mt-3"
            v-model:checked="form.is_active"
            id="is_active"
            :label="$t('admin.ingredients.attributes.is_active')"
        />
    </div>
</template>
