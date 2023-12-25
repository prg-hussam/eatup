<script setup>
import { ref, onMounted } from "vue";
import Label from "./Label.vue";

defineEmits(["update:modelValue"]);

defineProps({
    modelValue: [String, Number],
    label: String,
    asterisk: Boolean,
    error: String,
    placeholder: String,
    name: String,
    autofocus: Boolean,
    readonly: Boolean,
    disabled: Boolean,
    autocomplete: String,
    type: {
        type: String,
        default: "text",
    },
    mb: {
        type: String,
        default: "3",
    },
});
const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div :class="'mb-' + mb">
        <div v-if="$slots.floatEndContent" class="float-end">
            <slot name="floatEndContent" />
        </div>

        <Label :for="name" :label="label" :error="error" :asterisk="asterisk" />
        <div
            :class="
                $slots.floatEndContent
                    ? 'position-relative auth-pass-inputgroup mb-3'
                    : ''
            "
        >
            <input
                ref="input"
                class="form-control"
                @input="$emit('update:modelValue', $event.target.value)"
                :class="error ? 'is-invalid' : ''"
                :placeholder="placeholder"
                :value="modelValue"
                :name="name"
                :type="type"
                :readonly="readonly"
                :disabled="disabled"
                :autofocus="autofocus"
                :autocomplete="autocomplete"
                :id="name"
            />
            <slot name="hint" />
            <div class="invalid-feedback" v-if="error">
                {{ error }}
            </div>
        </div>
    </div>
</template>
