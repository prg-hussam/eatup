<script setup>
import Label from "./Label.vue";
import MultiSelect from "vue-multiselect";
import { computed, ref } from "vue";

const emits = defineEmits(["update:modelValue"]);
const props = defineProps({
    modelValue: [String, Array, Number],
    label: String,
    asterisk: Boolean,
    error: String,
    closeOnSelect: Boolean,
    placeholder: String,
    name: String,
    disabled: Boolean,
    multiple: Boolean,
    options: [Array, Object],
    idName: {
        type: String,
        default: "id",
    },
    labelName: {
        type: String,
        default: "name",
    },
    maxHeight: {
        type: Number,
        default: 250,
    },
});

const optionsType = computed(() => {
    if (Array.isArray(props.options)) {
        if (typeof props.options[0] == "object") {
            return "arrayOfObject";
        } else {
            return "array";
        }
    } else {
        return "object";
    }
});

const proxySelect = computed({
    get() {
        return optionsType.value == "arrayOfObject" &&
            Array.isArray(props.modelValue)
            ? props.options.filter((option) =>
                  props.modelValue.includes(option[props.idName].toString())
              )
            : props.modelValue;
    },
    set(val) {
        emits(
            "update:modelValue",
            optionsType.value == "arrayOfObject"
                ? val.map((v) => v[props.idName].toString())
                : val
        );
    },
});
</script>

<template>
    <div class="mb-3">
        <Label :for="name" :label="label" :error="error" :asterisk="asterisk" />
        <MultiSelect
            :id="name"
            :disabled="disabled"
            :multiple="multiple"
            :maxHeight="maxHeight"
            v-model="proxySelect"
            :close-on-select="closeOnSelect"
            :placeholder="placeholder || $t('global.please_select')"
            :class="error ? 'is-invalid' : ''"
            :options="optionsType == 'object' ? Object.keys(options) : options"
            :custom-label="
                optionsType == 'object'
                    ? (option) => options[option]
                    : undefined
            "
            :label="optionsType == 'arrayOfObject' ? labelName : undefined"
            :track-by="optionsType == 'arrayOfObject' ? idName : undefined"
        />

        <div class="invalid-feedback" v-if="error">
            {{ error }}
        </div>
    </div>
</template>
