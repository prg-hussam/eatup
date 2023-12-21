<script setup>
import { ref } from "@vue/reactivity";
import Label from "../Label.vue";

const emits = defineEmits(["update:modelValue"]);

const props = defineProps({
  modelValue: Array,
  entityFiles: Array,
  label: String,
  asterisk: Boolean,
  error: String,
  mime: String,
});

const files = ref(props.entityFiles || []);

const browse = () => {
  window.showFileManager({
    mime: props.mime,
  });

  window.fileManagerCallback = (newFiles) => {
    updateValue(newFiles);
    window.hideFileManager();
  };
};

const updateValue = (newFiles, isTrash = false) => {
  let allFils = [...newFiles, ...(isTrash ? [] : files.value)];
  emits(
    "update:modelValue",
    allFils.map((file) => file.id)
  );
  files.value = allFils;
};

const trash = (removeFileId) => {
  updateValue(
    files.value.filter((file) => removeFileId != file.id),
    true
  );
};
</script>

<template>
  <div class="mb-3">
    <Label :label="label" :error="error" :asterisk="asterisk" />
    <div class="multiple-picker">
      <div class="picker-holder" role="button" @click="browse">
        <i class="mdi mdi-file-image-plus-outline"></i>
      </div>
      <div v-for="file in files" :key="file.id" class="picker-preview">
        <img :src="file.preview_image_url" />
        <span class="file-name">{{ file.filename }}</span>

        <div class="overlay hstack gap-1">
          <button
            @click="trash(file.id)"
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
      </div>
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
.multiple-picker {
  border-radius: 3px;
  background: #fff;
  border: 2px dashed #d9d9d9;
  padding: 5px;
  width: 100%;
  min-height: 162px;
  position: relative;
  display: flex;
  flex-wrap: wrap;
}
.picker-holder,
.picker-preview {
  height: 140px;
  width: 140px;
  display: flex;
  border-radius: 3px;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  border: 2px dashed #d9d9d9;
  margin: 5px;
  position: relative;
}

.picker-holder i {
  font-size: 80px;
  color: #d9d9d9;
}

.picker-preview img {
  width: 70%;
  height: 70%;
  object-fit: contain;
}

.picker-preview .file-name {
  width: 100%;
  overflow: hidden;
  font-size: 10px;
  font-weight: 500;
  white-space: nowrap;
  text-overflow: ellipsis;
  margin-top: 5px;
  text-align: center;
}

.picker-preview .overlay {
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

.picker-preview:hover .overlay {
  display: flex;
  transform: scale(1);
}
</style>