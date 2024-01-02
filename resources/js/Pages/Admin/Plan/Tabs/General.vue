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
                $t('admin.plans.attributes.name') +
                ` ( ${supportedLocales[formLocale].name} )`
            "
            name="name"
        />

        <Input
            asterisk
            v-model="form.duration"
            :error="form.errors.duration"
            :label="$t('admin.plans.attributes.duration')"
            name="duration"
        >
            <template #hint>
                <div class="form-text text-info">
                    {{ $t("admin.plans.duration_hint") }}
                </div>
            </template>
        </Input>

        <Checkbox
            class="mt-3"
            v-model:checked="form.is_active"
            id="is_active"
            :label="$t('admin.plans.attributes.is_active')"
        />
    </div>
</template>
