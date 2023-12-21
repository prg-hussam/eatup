<script setup>
import Label from "./Label.vue";
defineProps({
  modelValue: String,
  label: String,
  asterisk: Boolean,
  error: String,
  name: String,
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
});

defineEmits(["update:modelValue"]);
</script>

<template>
  <div class="mb-3">
    <Label :label="label" :error="error" :asterisk="asterisk" />
    <select
      :name="name"
      :multiple="multiple"
      class="form-control"
      :class="error ? 'is-invalid' : ''"
      @change="$emit('update:modelValue', $event.target.value)"
    >
      <option
        v-for="(option, key) in options"
        :key="key"
        :value="typeof option == 'object' ? option[idName] : key"
        :selected="
          modelValue == (typeof option == 'object' ? option[idName] : key)
            ? true
            : false
        "
      >
        {{ typeof option == "object" ? option[labelName] : option }}
      </option>
    </select>
    <div class="invalid-feedback" v-if="error">
      {{ error }}
    </div>
  </div>
</template>
