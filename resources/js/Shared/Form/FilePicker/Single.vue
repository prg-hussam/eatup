<script setup>
import { ref } from "@vue/reactivity";
import Label from "../Label.vue";

const emits = defineEmits(["update:modelValue"]);

const props = defineProps({
  modelValue: Number,
  entityFile: Object,
  label: String,
  asterisk: Boolean,
  error: String,
  mime: String,
  perfectSize: String,
});

const file = ref(props.entityFile);

const browse = () => {
  window.showFileManager({
    mime: props.mime,
    isSinglePicker: true,
  });

  window.fileManagerCallback = (newFile) => {
    updateValue(newFile);
    window.hideFileManager();
  };
};

const updateValue = (newFile) => {
  emits("update:modelValue", newFile == null ? null : newFile.id);
  file.value = newFile;
};

const trash = () => {
  updateValue(null);
};
</script>

<template>
  <div class="mb-3">
    <Label :label="label" :error="error" :asterisk="asterisk" />
    <div class="single-picker">
      <div class="picker-holder" role="button" @click="browse">
        <i v-if="file == null" class="mdi mdi-file-image-plus-outline"></i>
        <template v-else>
          <img :src="file.preview_image_url" />
          <span class="file-name">{{ file.filename }}</span>
        </template>
      </div>
      <template v-if="file != null">
        <div class="overlay hstack gap-1">
          <button
            @click="browse"
            type="button"
            class="
              btn btn-primary btn-icon btn-sm
              waves-effect waves-light
              shadow-none
            "
          >
            <i class="bx bx-folder"></i>
          </button>
          <button
            @click="trash"
            type="button"
            class="
              btn btn-danger btn-icon btn-sm
              waves-effect waves-light
              shadow-none
            "
          >
            <i class="bx bx-trash"></i>
          </button>
          <a
            download
            :href="file.download_url"
            class="
              btn btn-success btn-icon btn-sm
              waves-effect waves-light
              shadow-none
            "
          >
            <i class="bx bx-cloud-download"></i>
          </a>
        </div>
      </template>
    </div>
    <div v-if="perfectSize" class="perfect-size text-muted">
      {{ perfectSize }}
    </div>
    <div
      class="invalid-feedback"
      v-if="error"
      :style="`display:${error ? 'block' : 'none'}`"
    >
      {{ error }}
    </div>
  </div>
</template>

<style scoped>
.single-picker {
  border-radius: 3px;
  background: #fff;
  border: 2px dashed #d9d9d9;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 5px;
  width: 150px;
  height: 150px;
  position: relative;
}

.picker-holder {
  overflow: hidden;
  height: 140px;
  width: 140px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.picker-holder img {
  width: 70%;
  height: 70%;
  object-fit: contain;
}
.picker-holder i {
  font-size: 80px;
  color: #d9d9d9;
}
.picker-holder .file-name {
  width: 100%;
  overflow: hidden;
  font-size: 10px;
  font-weight: 500;
  white-space: nowrap;
  text-overflow: ellipsis;
  margin-top: 5px;
  text-align: center;
}

.single-picker .overlay {
  position: absolute;
  width: 100%;
  height: 100%;
  background: transparent;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  display: none;
  justify-content: flex-end;
  align-items: start;
  padding: 10px;
  transform: scale(0);
}

.single-picker:hover .overlay {
  display: flex;
  transform: scale(1);
}

[data-sidebar="dark"] .single-picker {
  background: transparent;
}
.perfect-size {
  font-size: 0.7rem;
}
</style>