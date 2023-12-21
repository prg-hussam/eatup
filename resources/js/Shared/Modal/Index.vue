


<script>
import { Modal } from "bootstrap";

export default {
  emits: ["close"],
  props: {
    id: {
      type: String,
      default: "myModal",
    },
    show: {
      type: Boolean,
      default: false,
    },
    scrollable: {
      type: Boolean,
      default: false,
    },
    maxWidth: {
      default: "md",
    },
  },
  data() {
    return {
      modal: null,
    };
  },
  mounted() {
    this.modal = new Modal(document.getElementById(this.id));
    this.addEventListeners();
  },
  methods: {
    addEventListeners() {
      var myModalEl = document.getElementById(this.id);
      myModalEl.addEventListener("hidden.bs.modal", this.handleHiddenBsModal);
    },

    handleHiddenBsModal() {
      this.$emit("close");
    },

    closeModal() {
      if (this.modal) {
        this.modal.hide();
      }
    },
    showModal() {
      if (this.modal) {
        this.modal.show();
      }
    },
  },
  watch: {
    show: {
      immediate: true,
      handler: function (show) {
        if (show) {
          this.showModal();
        } else {
          this.closeModal();
        }
      },
    },
  },

  computed: {
    maxWidthClass() {
      return {
        sm: "modal-sm",
        md: null,
        fullscreen: "modal-fullscreen",
        lg: "modal-lg",
        xl: "modal-xl",
      }[this.maxWidth];
    },
  },
};
</script>
<template>
  <div
    :id="id"
    class="modal fade"
    tabindex="-1"
    aria-hidden="true"
    style="display: none"
  >
    <div
      class="modal-dialog"
      :class="[maxWidthClass, scrollable ? 'modal-dialog-scrollable' : '']"
    >
      <slot />
    </div>
  </div>
</template>

