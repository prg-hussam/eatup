<script setup>
import { computed, ref } from "vue";
import LoadingButton from "@/Shared/Form/LoadingButton.vue";
import FromDate from "../Filters/FromDate.vue";
import ToDate from "../Filters/ToDate.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  form: Object,
  resource: String,
});

const loadingFilter = ref(false);
const loadingReset = ref(false);

const btnResetDisabled = computed(() => {
  return (
    loadingReset.value ||
    loadingFilter.value ||
    Object.keys(props.form).filter(
      (key) => typeof route().params[key] != "undefined"
    ).length == 0
  );
});

const btnFilterDisabled = computed(() => {
  return (
    loadingReset.value ||
    loadingFilter.value ||
    Object.keys(props.form).filter((key) => props.form[key]).length == 0
  );
});

const close = () => {
  document
    .getElementById("table-filter-offcanvas")
    .getElementsByClassName("btn-close")[0]
    .click();
};

const reset = () => {
  Object.keys(props.form).forEach((key) => {
    props.form[key] = "";
  });
  filter(true);
};

const filter = (isReset = false) => {
  isReset = typeof isReset == "boolean" && isReset;
  if (loadingFilter.value || loadingReset.value) {
    return;
  }

  if (isReset) {
    loadingReset.value = true;
  } else {
    loadingFilter.value = true;
  }

  router.get(
    route(`admin.${props.resource}.index`),
    Object.fromEntries(
      Object.entries(props.form).filter(([key, value]) => value)
    ),
    {
      preserveState: true,
      preserveScroll: true,
      replace: true,
      onSuccess: () => close(),
      onFinish: () => {
        loadingFilter.value = false;
        loadingReset.value = false;
      },
    }
  );
};
</script>

<template>
  <div
    class="offcanvas offcanvas-end border-0"
    tabindex="-1"
    id="table-filter-offcanvas"
  >
    <div
      class="
        d-flex
        align-items-center
        bg-primary bg-gradient
        p-3
        offcanvas-header
      "
    >
      <h5 class="m-0 me-2 text-white">{{ $t("global.filter") }}</h5>

      <button
        type="button"
        class="btn-close btn-close-white ms-auto"
        data-bs-dismiss="offcanvas"
        aria-label="Close"
      ></button>
    </div>
    <div class="offcanvas-body p-0">
      <div data-simplebar class="h-100">
        <div class="p-3">
          <slot name="body" />
          <FromDate v-if="typeof form.from != 'undefined'" :form="form" />
          <ToDate v-if="typeof form.to != 'undefined'" :form="form" />
        </div>
      </div>
    </div>
    <div class="offcanvas-footer border-top p-3 text-center">
      <div class="row">
        <div class="col-6">
          <LoadingButton
            @click="reset"
            icon="mdi mdi-filter-off-outline"
            class="btn-light w-100"
            :title="$t('global.reset')"
            :loading="loadingReset"
            :disabled="btnResetDisabled"
          />
        </div>
        <div class="col-6">
          <LoadingButton
            @click="filter"
            icon="mdi mdi-filter-outline"
            class="btn-primary w-100"
            :title="$t('global.buttons.filter')"
            :loading="loadingFilter"
            :disabled="btnFilterDisabled"
          />
        </div>
      </div>
    </div>
  </div>
</template>