<script setup>
import { computed } from "vue";

const emit = defineEmits(["update:checked"]);

const props = defineProps({
  checked: {
    type: [Array, Boolean],
    default: false,
  },
  value: String,
  id: String,
  label: String,
  error: String,
});

const proxyChecked = computed({
  get() {
    return props.checked;
  },
  set(val) {
    emit("update:checked", val);
  },
});
</script>

<template>
  <div class="form-check">
    <input
      :id="id"
      v-model="proxyChecked"
      type="checkbox"
      :value="value"
      class="form-check-input"
    />
    <label
      class="form-check-label"
      :class="error ? 'text-danger' : ''"
      :for="id"
    >
      {{ label }}
    </label>
  </div>
</template>
