<script setup>
import { onMounted, ref, watch } from "vue";
import Input from "@/Shared/Form/Input.vue";
import useGeneral from "@/Uses/general";
import Checkbox from "@/Shared/Form/Checkbox.vue";
import MultiSelect from "@/Shared/Form/MultiSelect.vue";

const props = defineProps({
    form: Object,
    tab: Object,
    formLocale: String,
    entity: Object,
});
const { supportedLocales } = useGeneral();

const diningPeriods = ref({});

watch(
    () => props.form.category_id,
    (value, prevValue) => {
        diningPeriods.value = {};
        props.form.diningPeriods = null;
        if (value) {
            diningPeriodsHandler(value);
        }
    }
);

onMounted(() => {
    if (props.form.diningPeriods) {
        diningPeriodsHandler(props.form.category_id);
    }
});
const diningPeriodsHandler = (categoryId) => {
    axios
        .get(route("admin.utility.category.periods", categoryId))
        .then((res) => {
            diningPeriods.value = res.data.diningPeriods;
        });
};
</script>

<template>
    <div>
        <Input
            asterisk
            v-model="form.name[formLocale]"
            :error="form.errors[`name.${formLocale}`]"
            :label="
                $t('admin.meals.attributes.name') +
                ` ( ${supportedLocales[formLocale].name} )`
            "
            name="name"
        />

        <MultiSelect
            :label="$t('admin.meals.attributes.category_id')"
            :error="form.errors.category_id"
            v-model="form.category_id"
            :options="tab.data.categories"
            name="category_id"
            asterisk
            closeOnSelect
        />

        <MultiSelect
            :label="$t('admin.meals.attributes.diningPeriods')"
            :error="form.errors.diningPeriods"
            v-model="form.diningPeriods"
            :options="diningPeriods"
            name="diningPeriods"
            asterisk
            multiple
        />
        <MultiSelect
            :label="$t('admin.meals.attributes.menus')"
            :error="form.errors.menus"
            v-model="form.menus"
            :options="tab.data.menus"
            name="menus"
            asterisk
            multiple
        />

        <MultiSelect
            :label="$t('admin.meals.attributes.ingredients')"
            :error="form.errors.ingredients"
            v-model="form.ingredients"
            :options="tab.data.ingredients"
            name="ingredients"
            asterisk
            multiple
        />

        <MultiSelect
            :label="$t('admin.meals.attributes.meal_type')"
            :error="form.errors.type"
            v-model="form.type"
            :options="tab.data.types"
            name="type"
            asterisk
            closeOnSelect
        />
        <MultiSelect
            :label="$t('admin.meals.attributes.unit')"
            :error="form.errors.unit"
            v-model="form.unit"
            :options="tab.data.units"
            name="unit"
            asterisk
            closeOnSelect
        />

        <Input
            asterisk
            v-model="form.min_qty"
            :error="form.errors.min_qty"
            :label="$t('admin.meals.attributes.min_qty')"
            name="min_qty"
        />
        <Input
            asterisk
            v-model="form.max_qty"
            :error="form.errors.max_qty"
            :label="$t('admin.meals.attributes.max_qty')"
            name="max_qty"
        />

        <Checkbox
            class="mt-3"
            v-model:checked="form.is_active"
            id="is_active"
            :label="$t('admin.meals.attributes.is_active')"
        />
    </div>
</template>
