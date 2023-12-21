<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import useGeneral from "@/Uses/general";

defineProps({ tab: Object });

const formLocale = ref(usePage().props.locale);
const { supportedLocales, settings } = useGeneral();
const changeFormLocale = (locale) => {
  setTimeout(() => (formLocale.value = locale), 5);
};
</script>

<template>
  <div
    class="tab-pane fade"
    :id="`custom-v-pills-${tab.name}`"
    role="tabpanel"
    :aria-labelledby="`custom-v-pills-${tab.name}-tab`"
    :class="{ 'active show': tab.isActive }"
  >
    <div class="d-flex align-items-center mb-0">
      <div class="flex-grow-1">
        <h5 class="card-title mb-0">{{ $t(tab.label) }}</h5>
      </div>
      <div
        v-if="Object.keys(supportedLocales).length > 1 && tab.hasTranslations"
        class="flex-shrink-0"
      >
        <div class="btn-group">
          <div class="btn-group">
            <button
              type="button"
              class="btn btn-light dropdown-toggle shadow-none"
              data-bs-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              :class="{
                'has-error-translations': tab.localesHasErrors.length > 0,
                'text-danger': tab.localesHasErrors.includes(formLocale),
              }"
            >
              <span v-if="formLocale == settings.default_locale">
                {{ $t("global.default_locale") }} -
              </span>
              {{ supportedLocales[formLocale].name }} -
              {{ formLocale }}
            </button>
            <div class="dropdown-menu">
              <div class="d-flex flex-column">
                <a
                  v-for="(language, locale) in supportedLocales"
                  href="javascript:void(0);"
                  @click="changeFormLocale(locale)"
                  class="dropdown-item"
                  :class="{
                    'text-danger': tab.localesHasErrors.includes(locale),
                    'order-1': locale == settings.default_locale,
                    'order-2': locale != settings.default_locale,
                  }"
                  :key="locale"
                >
                  <span v-if="locale == settings.default_locale">
                    {{ $t("global.default_locale") }} -
                  </span>
                  {{ language.name }} - {{ locale }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr class="hr-header" />
    <slot :formLocale="formLocale" />
  </div>
</template>

<style scoped>
.hr-header {
  margin: 0.5rem 0;
  margin-bottom: 1rem;
}
.has-error-translations {
  border: 1px dashed #f06548;
}
</style>