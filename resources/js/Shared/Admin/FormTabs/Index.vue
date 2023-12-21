<script setup>
import NavPill from "./NavPill.vue";
import Content from "./Content.vue";
import LoadingButton from "@/Shared/Form/LoadingButton.vue";
import { onMounted, ref } from "@vue/runtime-core";

defineProps({
  tabs: Object,
  components: Object,
  submit: Function,
  form: Object,
  entity: Object,
});

const pillActiveId = ref("");

onMounted(() => {
  var triggerTabList = [].slice.call(
    document.querySelectorAll("#custom-crud-tabs a")
  );
  triggerTabList.forEach((triggerEl) => {
    triggerEl.addEventListener("click", (event) => {
      pillActiveId.value = event.target.id;
    });
  });
});
</script>

<template>
  <form @submit.prevent="submit">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <div
              class="
                nav nav-pills
                flex-column
                nav-pills-tab
                custom-verti-nav-pills
              "
              id="custom-crud-tabs"
              role="tablist"
              aria-orientation="vertical"
            >
              <NavPill
                v-for="tab in tabs.tabs"
                :activeId="pillActiveId"
                :key="tab.name"
                :tab="tab"
              />
            </div>
          </div>
          <div class="col-lg-9">
            <div class="tab-content mt-4 mt-lg-3">
              <Content
                v-for="tab in tabs.tabs"
                :key="tab.name"
                :tab="tab"
                v-slot="{ formLocale }"
              >
                <component
                  :is="components[tab.component]"
                  :form="form"
                  :tab="tab"
                  :entity="entity"
                  :formLocale="formLocale"
                />
              </Content>
            </div>
            <div class="row">
              <div class="col-12 text-end">
                <LoadingButton
                  icon="bx bx-save"
                  :title="$t('global.buttons.save')"
                  :loading="form.processing"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<style scoped>
.spinner-border {
  width: 1rem;
  height: 1rem;
  border-width: 0.19em;
}
</style>