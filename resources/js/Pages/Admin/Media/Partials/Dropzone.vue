<script setup>
import { usePage } from "@inertiajs/vue3";
import Dropzone from "dropzone";
import { ref, onMounted } from "vue";

const props = defineProps({ folderId: Number });
const emits = defineEmits(["success"]);
const dropRef = ref(null);
const page = usePage();

onMounted(() => {
    if (dropRef.value !== null) {
        new Dropzone(dropRef.value, {
            url: route("admin.media.store", { folder_id: props.folderId }),
            autoProcessQueue: true,
            maxFiles: 10,
            maxFilesize: page.props.maxFileSize,
            acceptedFiles: page.props.acceptedFiles,
            headers: {
                "X-CSRF-TOKEN": page.props.csrfToken,
            },
            success: function (file) {
                if (
                    this.getUploadingFiles().length === 0 &&
                    this.getQueuedFiles().length === 0
                ) {
                    emits("success");
                }
            },
            error: function (file, message) {
                if (file.previewElement) {
                    file.previewElement.classList.add("dz-error");
                    if (typeof message !== "string" && message.error)
                        message = message.error;

                    if (typeof message !== "string" && message.message)
                        message = message.message;
                    var _iteratorNormalCompletion = true,
                        _didIteratorError = false,
                        _iteratorError = undefined;
                    try {
                        for (
                            var _iterator = file.previewElement
                                    .querySelectorAll("[data-dz-errormessage]")
                                    [Symbol.iterator](),
                                _step;
                            !(_iteratorNormalCompletion = (_step =
                                _iterator.next()).done);
                            _iteratorNormalCompletion = true
                        ) {
                            var node = _step.value;
                            node.textContent = message;
                        }
                    } catch (err) {
                        _didIteratorError = true;
                        _iteratorError = err;
                    } finally {
                        try {
                            if (
                                !_iteratorNormalCompletion &&
                                _iterator.return != null
                            ) {
                                _iterator.return();
                            }
                        } finally {
                            if (_didIteratorError) {
                                throw _iteratorError;
                            }
                        }
                    }
                }
            },
        });
    }
});
</script>
<template>
    <div>
        <div ref="dropRef" class="dropzone custom-dropzone">
            <div class="dz-message">
                <div class="mb-3">
                    <i class="display-4 text-muted bx bx-cloud-upload"></i>
                </div>
                <h4>{{ $t("admin.media.drop_files_here") }}</h4>
            </div>
        </div>
    </div>
</template>

<style>
@import "~dropzone/dist/dropzone";
.custom-dropzone {
    border: 2px dashed #d2d6de;
    min-height: 300px;
}

.dz-message {
    color: #646c7f;
    font-size: 20px;
    text-align: center;
}
</style>
