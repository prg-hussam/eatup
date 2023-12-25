<script setup>
import TimePicker from "@/Shared/Form/TimePicker.vue";
import Checkbox from "@/Shared/Form/Checkbox.vue";
const props = defineProps({
    form: Object,
    tab: Object,
    entity: Object,
    formLocale: String,
});

const addTime = () => {
    props.form.times.push({
        from: null,
        to: null,
        is_active: true,
    });
};

const removeTime = (index) => {
    props.form.times.splice(index, 1);
};
</script>

<template>
    <div>
        <div class="row mb-3">
            <div class="col-12 text-end">
                <button
                    @click="addTime"
                    type="button"
                    class="btn btn-info btn-label text-capitalize"
                >
                    <i
                        class="mdi mdi-plus label-icon align-middle fs-16 me-2"
                    ></i>
                    {{ $t("admin.dining_periods.times_table.add_time_period") }}
                </button>
            </div>
        </div>
        <div class="row" v-if="form.times.length">
            <div class="col">
                <table class="table table-bordered align-middle mb-3">
                    <thead class="table-light">
                        <tr class="text-muted">
                            <th scope="col" style="width: 23%">
                                {{
                                    $t("admin.dining_periods.times_table.from")
                                }}
                            </th>
                            <th scope="col" style="width: 23%">
                                {{ $t("admin.dining_periods.times_table.to") }}
                            </th>
                            <th scope="col" style="width: 23%">
                                {{
                                    $t(
                                        "admin.dining_periods.times_table.status"
                                    )
                                }}
                            </th>

                            <th scope="col" style="width: 8%">
                                {{ $t("global.table.actions") }}
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(time, index) in form.times" :key="index">
                            <td>
                                <TimePicker
                                    :error="form.errors[`times.${index}.from`]"
                                    v-model="form.times[index].from"
                                />
                            </td>
                            <td>
                                <TimePicker
                                    :error="form.errors[`times.${index}.to`]"
                                    v-model="form.times[index].to"
                                />
                            </td>
                            <td>
                                <Checkbox
                                    v-model:checked="
                                        form.times[index].is_active
                                    "
                                    :id="`times-${index}-is-active`"
                                    :label="
                                        $t(
                                            'admin.dining_periods.attributes.is_active'
                                        )
                                    "
                                />
                            </td>

                            <td>
                                <button
                                    @click="removeTime(index)"
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
    </div>
</template>
