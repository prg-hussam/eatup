<script setup>
import Input from "@/Shared/Form/Input.vue";
import Checkbox from "@/Shared/Form/Checkbox.vue";
import MultiSelect from "@/Shared/Form/MultiSelect.vue";
const props = defineProps({
    form: Object,
    tab: Object,
    entity: Object,
    formLocale: String,
});

const addPeriodPrice = () => {
    if (
        Object.keys(props.tab.data.diningPeriods).length ===
        props.form.prices.length
    ) {
        alert("stop!!!");
        return;
    }
    props.form.prices.push({
        dining_period_id: null,
        price: null,
        is_active: true,
    });
};

const removePeriodPrice = (index) => {
    props.form.prices.splice(index, 1);
};
</script>

<template>
    <div class="row mb-3">
        <div class="col-12 text-end">
            <button
                @click="addPeriodPrice"
                type="button"
                class="btn btn-info btn-label text-capitalize"
            >
                <i class="mdi mdi-plus label-icon align-middle fs-16 me-2"></i>
                {{ $t("admin.plans.pricing_table.add_period_price") }}
            </button>
        </div>
    </div>

    <div class="row" v-if="form.prices.length">
        <div class="col">
            <table class="table table-bordered align-middle mb-3">
                <thead class="table-light">
                    <tr class="text-muted">
                        <th scope="col" style="width: 23%">
                            {{ $t("admin.plans.pricing_table.dining_periods") }}
                        </th>
                        <th scope="col" style="width: 23%">
                            {{ $t("admin.plans.pricing_table.price") }}
                        </th>
                        <th scope="col" style="width: 23%">
                            {{ $t("admin.plans.pricing_table.is_active") }}
                        </th>

                        <th scope="col" style="width: 8%">
                            {{ $t("global.table.actions") }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(price, index) in form.prices" :key="index">
                        <td>
                            <MultiSelect
                                :error="
                                    form.errors[
                                        `prices.${index}.dining_period_id`
                                    ]
                                "
                                v-model="form.prices[index].dining_period_id"
                                :options="tab.data.diningPeriods"
                                closeOnSelect
                            />
                        </td>
                        <td>
                            <Input
                                asterisk
                                v-model="form.prices[index].price"
                                :error="form.errors[`prices.${index}.price`]"
                            >
                                <template
                                    #hint
                                    v-if="
                                        form.prices[index].dining_period_id &&
                                        form.duration
                                    "
                                >
                                    <div class="form-text text-info">
                                        {{
                                            $t(
                                                "admin.plans.pricing_table.price_hint",
                                                {
                                                    period: `${
                                                        tab.data.diningPeriods[
                                                            form.prices[index]
                                                                .dining_period_id
                                                        ]
                                                    }`,
                                                    duration: form.duration,
                                                }
                                            )
                                        }}
                                    </div>
                                </template>
                            </Input>
                        </td>
                        <td>
                            <Checkbox
                                v-model:checked="form.prices[index].is_active"
                                :id="`prices-${index}-is-active`"
                                :label="
                                    $t(
                                        'admin.dining_periods.attributes.is_active'
                                    )
                                "
                            />
                        </td>

                        <td>
                            <button
                                @click="removePeriodPrice(index)"
                                type="button"
                                class="btn btn-danger btn-label"
                            >
                                <i
                                    class="mdi mdi-delete-outline label-icon align-middle fs-16 me-2"
                                ></i>
                                {{ $t("global.buttons.delete") }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
