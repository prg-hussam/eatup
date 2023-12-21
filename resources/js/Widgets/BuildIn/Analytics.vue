<script setup>
import { CountTo } from "vue3-count-to";
defineProps({
  title: String,
  visible: {
    type: Boolean,
    default: true,
  },
  value: [Number, String],
  iconClass: String,
  bgColor: {
    type: String,
    default: "bg-primary",
  },
});

const isString = (value) => typeof value == "string";
</script>

<template>
  <div v-if="visible" class="col-xl-3 col-md-6">
    <div class="card card-animate">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            <p class="fw-medium text-muted mb-0">{{ title }}</p>
            <h2 class="mt-4 ff-secondary fw-semibold">
              <span class="counter-value">
                <count-to
                  v-if="!isString(value)"
                  :startVal="0"
                  :endVal="value"
                  :duration="1000"
                />
                <span v-else>{{ value }}</span>
              </span>
            </h2>
          </div>
          <div>
            <div class="avatar-sm flex-shrink-0">
              <div class="avatar-title rounded-2 fs-2" :class="bgColor">
                <i :class="iconClass"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>