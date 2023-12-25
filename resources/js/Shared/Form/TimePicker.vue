<script setup>
import Label from "./Label.vue";
import { computed } from "vue";
import FlatPicker from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";

const emits = defineEmits(["update:modelValue"]);
const config = {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
};
const props = defineProps({
    modelValue: [String, Object],
    label: String,
    asterisk: Boolean,
    error: String,
    name: String,
    placeholder: String,
});

const proxyValue = computed({
    get() {
        return props.modelValue;
    },
    set(val) {
        emits("update:modelValue", val);
    },
});
</script>
<template>
    <div class="mb-3">
        <Label :for="name" :label="label" :error="error" :asterisk="asterisk" />
        <div class="form-icon" :class="{ 'is-invalid': error }">
            <FlatPicker
                :placeholder="placeholder"
                :config="config"
                class="form-control flatpickr-input form-control-icon"
                :class="{ 'is-invalid': error }"
                v-model="proxyValue"
            />

            <i class="bx bx-calendar"></i>
        </div>
        <div class="invalid-feedback" v-if="error">
            {{ error }}
        </div>
    </div>
</template>
