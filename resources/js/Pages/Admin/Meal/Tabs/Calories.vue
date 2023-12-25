<script setup>
import Input from "@/Shared/Form/Input.vue";

defineProps({
    form: Object,
    tab: Object,
    entity: Object,
});
</script>

<template>
    <div>
        <Input
            asterisk
            v-model="form.protein_calories_per_unit"
            :error="form.errors.protein_calories_per_unit"
            :label="$t('admin.meals.attributes.protein_calories_per_unit')"
            name="protein_calories_per_unit"
        />
        <Input
            asterisk
            v-model="form.carbs_calories_per_unit"
            :error="form.errors.carbs_calories_per_unit"
            :label="$t('admin.meals.attributes.carbs_calories_per_unit')"
            name="carbs_calories_per_unit"
        />
        <Input
            asterisk
            v-model="form.fat_calories_per_unit"
            :error="form.errors.fat_calories_per_unit"
            :label="$t('admin.meals.attributes.fat_calories_per_unit')"
            name="fat_calories_per_unit"
        />
        <Input
            asterisk
            v-model="form.sugars_calories_per_unit"
            :error="form.errors.sugars_calories_per_unit"
            :label="$t('admin.meals.attributes.sugars_calories_per_unit')"
            name="sugars_calories_per_unit"
        />
    </div>
</template>
