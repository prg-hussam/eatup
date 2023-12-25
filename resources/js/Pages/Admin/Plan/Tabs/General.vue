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
                    Specify the plan duration in days
                </div>
            </template>
        </Input>
        <Input
            asterisk
            v-model="form.price"
            :error="form.errors.price"
            :label="$t('admin.plans.attributes.price')"
            name="price"
        />

        <Checkbox
            class="mt-3"
            v-model:checked="form.is_active"
            id="is_active"
            :label="$t('admin.plans.attributes.is_active')"
        />
    </div>
</template>
