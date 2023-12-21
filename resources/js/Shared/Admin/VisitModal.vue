<script setup>
import Modal from "@/Shared/Modal/Index.vue";
import { usePage, router } from "@inertiajs/vue3";
import { markRaw, ref, onBeforeMount } from "vue";

const options = ref(null);
const show = ref(false);
const modalOptions = ref({
  scrollable: true,
  maxWidth: "md",
});

onBeforeMount(() => {
  router.visitInModal = (url, onSuccess) => {
    visitInModal(url, onSuccess);
  };
});

const closeModal = () => {
  options.value = null;
  show.value = false;
  modalOptions.value = {
    scrollable: true,
    maxWidth: "md",
  };
};

const showModal = () => {
  show.value = true;
};

const visitInModal = (url) => {
  axios
    .get(url, {
      headers: {
        Accept: "text/html, application/xhtml+xml",
        "X-Requested-With": "XMLHttpRequest",
        "X-Inertia": true,
        "X-Inertia-Modal": true,
        "X-Inertia-Version": usePage().version,
      },
    })
    .then((response) => {
      return Promise.resolve(
        router.resolveComponent(response.data.component)
      ).then((component) => {
        options.value = {
          component: markRaw(component),
          page: response.data,
        };
        showModal();
      });
    });
};

const updateModalOptions = (options) => {
  modalOptions.value = { ...modalOptions.value, ...options };
};
</script>

<template>
  <Modal
    id="boxModal"
    :maxWidth="modalOptions.maxWidth"
    :show="show"
    @close="closeModal"
    :scrollable="modalOptions.scrollable"
  >
    <component
      v-if="options != null"
      :is="options.component"
      @closeModal="closeModal"
      @modal:options="updateModalOptions"
      v-bind="options.page.props"
    />
  </Modal>
</template>
