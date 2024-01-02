<script setup>
import { useForm } from "@inertiajs/vue3";
import FormTabs from "@/Shared/Admin/FormTabs/Index.vue";
import GeneralTab from "../Tabs/General.vue";
import ThumbnailTab from "../Tabs/Thumbnail.vue";
import CaloriesTab from "../Tabs/Calories.vue";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const props = defineProps({
    tabs: Object,
    action: String,
    meal: Object,
});

const form = useForm({
    name: props.meal.name || {},
    dining_period_id: props.meal.dining_period_id,
    category_id: props.meal.category_id,
    type: props.meal.type,
    unit: props.meal.unit,
    min_qty: props.meal.min_qty,
    max_qty: props.meal.max_qty,
    protein_calories_per_unit: props.meal.protein_calories_per_unit,
    carbs_calories_per_unit: props.meal.carbs_calories_per_unit,
    fat_calories_per_unit: props.meal.fat_calories_per_unit,
    sugars_calories_per_unit: props.meal.sugars_calories_per_unit,
    is_active: props.meal.is_active,
    menus:
        typeof props.meal.menus == "object"
            ? props.meal.menus.map((menu) => menu.id.toString())
            : null,
    ingredients:
        typeof props.meal.ingredients == "object"
            ? props.meal.ingredients.map((ingredient) =>
                  ingredient.id.toString()
              )
            : null,
    diningPeriods:
        typeof props.meal.dining_periods == "object"
            ? props.meal.dining_periods.map((diningPeriod) =>
                  diningPeriod.id.toString()
              )
            : null,
    files: {
        thumbnail: props.meal.thumbnail?.id,
    },
    _method: props.action == "store" ? "POST" : "PUT",
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        is_active: form.is_active ? true : false,
    })).post(route(`admin.meals.${props.action}`, props.meal.id), {
        errorBag: "SaveMeal",
        preserveState: true,
        onSuccess: () => {
            toast.success(
                trans("messages.resource_saved", {
                    resource: trans("admin.meals.meal"),
                })
            );
        },
    });
};
</script>
<template>
    <FormTabs
        :tabs="tabs"
        :components="{
            General: GeneralTab,
            Thumbnail: ThumbnailTab,
            Calories: CaloriesTab,
        }"
        :form="form"
        :submit="submit"
        :entity="meal"
    />
</template>
