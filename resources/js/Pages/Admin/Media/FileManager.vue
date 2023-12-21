<script setup>
import SearchBox from "./Partials/SearchBox.vue";
import HeaderActions from "./Partials/HeaderActions.vue";
import BulkActions from "./Partials/BulkActions.vue";
import MainSpinner from "./Partials/MainSpinner.vue";
import Empty from "./Partials/Empty.vue";
import File from "./Partials/File.vue";
import FilePlaceholderLoader from "./Partials/FilePlaceholderLoader.vue";
import Breadcrumb from "./Partials/Breadcrumb.vue";
import CreateFolderModal from "./Modals/CreateFolder.vue";
import UploadFilesModal from "./Modals/UploadFiles.vue";
import EditFileModal from "./Modals/EditFile.vue";
import FileInfoModal from "./Modals/FileInfoModal.vue";
import { inject, onMounted, reactive } from "vue";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const $swal = inject("$swal");
const props = defineProps({
    mime: String,
    isPicker: Boolean,
    isSinglePicker: Boolean,
});

const state = reactive({
    loading: false,
    searchLoading: false,
    refreshing: false,
    files: [],
    selectedFiles: [],
    folderId: null,
    breadcrumb: [],
    createFolderModal: false,
    uploadFilesModal: false,
    editFileModal: false,
    fileInfoModal: false,
    searchText: "",
    isLoadMore: false,
    stopLoadMore: false,
    focusFile: null,
});

onMounted(() => {
    getFiles();
});

const getFiles = (isRefreshing = false, skip = 0, isSearching = null) => {
    if (state.loading || state.refreshing || state.isLoadMore) {
        return;
    }
    state.selectedFiles = [];
    if (isSearching) {
        state.searchLoading = true;
    } else if (isRefreshing) {
        state.refreshing = true;
    } else if (skip > 0) {
        state.isLoadMore = true;
    } else {
        state.loading = true;
    }

    axios
        .get(route("admin.media.index", { json: true }), {
            params: {
                search: state.searchText,
                folder_id: state.folderId,
                skip,
                mime: props.mime,
            },
        })
        .then((response) => {
            if (response.data.files.length == 0) {
                state.stopLoadMore = true;
            }

            state.files =
                skip > 0
                    ? [...state.files, ...response.data.files]
                    : response.data.files;

            resetLoaders();
        })
        .catch((error) => {
            resetLoaders();
        });
};

const resetLoaders = () => {
    state.refreshing = false;
    state.loading = false;
    state.searchLoading = false;
    state.isLoadMore = false;
};

const refresh = () => {
    state.stopLoadMore = false;
    getFiles(true, 0);
};

const isSelected = (file) => {
    return state.selectedFiles.includes(file);
};

const onClickFile = (event, file) => {
    if (event.ctrlKey || event.metaKey) {
        if (isSelected(file)) {
            state.selectedFiles = state.selectedFiles.filter((f) => f != file);
        } else {
            state.selectedFiles.push(file);
        }
    } else {
        if (isSelected(file)) {
            state.selectedFiles = [];
        } else {
            state.selectedFiles = [file];
        }
    }
};

const onDblClickFile = (file, fromBreadcrumb = false) => {
    if (
        file.is_folder &&
        !state.loading &&
        !state.refreshing &&
        !state.isLoadMore
    ) {
        state.folderId = file.is_home ? null : file.id;
        if (!file.is_home && fromBreadcrumb) {
            state.breadcrumb = state.breadcrumb.slice(
                0,
                state.breadcrumb.indexOf(file) + 1
            );
        } else if (!file.is_home) {
            state.breadcrumb.push(file);
        } else {
            state.breadcrumb = [];
        }
        state.selectedFiles = [];
        state.searchText = "";
        state.stopLoadMore = false;
        state.files = [];
        getFiles();
    } else if (props.isPicker && props.isSinglePicker) {
        window.parent.fileManagerCallback(file);
    }
};

const showCreateFolderModal = () => {
    state.createFolderModal = true;
};

const hideCreateFolderModal = () => {
    state.createFolderModal = false;
};

const showUploadFilesModal = () => {
    state.uploadFilesModal = true;
};

const hideUploadFilesModal = () => {
    state.uploadFilesModal = false;
};

const showEditFileModal = (file) => {
    state.focusFile = file;
    setTimeout(() => (state.editFileModal = true), 1);
};

const hideEditFileModal = () => {
    state.editFileModal = false;
    setTimeout(() => (state.focusFile = null), 1);
};

const showFileInfoModal = (file) => {
    state.focusFile = file;
    setTimeout(() => (state.fileInfoModal = true), 1);
};

const hideFileInfoModal = () => {
    state.fileInfoModal = false;
    setTimeout(() => (state.focusFile = null), 1);
};

const onScroll = ({ target: { scrollTop, clientHeight, scrollHeight } }) => {
    if (scrollTop + clientHeight + 10 >= scrollHeight) {
        if (state.stopLoadMore == false) {
            getFiles(false, state.files.length);
        }
    }
};

const destroy = (id = null) => {
    if (typeof id == "number" || state.selectedFiles.length > 0) {
        $swal
            .fire({
                title: trans("global.delete_modal.confirmation"),
                text: trans("global.delete_modal.confirmation_message"),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: trans(
                    "global.delete_modal.confirmation_button"
                ),
            })
            .then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(
                            route("admin.media.destroy", {
                                ids:
                                    typeof id == "number"
                                        ? id
                                        : state.selectedFiles
                                              .map((file) => file.id)
                                              .join(","),
                            })
                        )
                        .then(() => {
                            state.selectedFiles = [];
                            useToast().success(
                                trans("messages.selected_files_deleted")
                            );
                            refresh();
                        });
                }
            });
    }
};
</script>
<template>
    <div
        class="card"
        :class="{ 'm-0 shadow-none': isPicker }"
        id="file-manager"
    >
        <div class="card-header">
            <div class="row g-2">
                <div class="col-sm-4">
                    <SearchBox
                        v-model="state.searchText"
                        :loading="state.searchLoading"
                        @search="getFiles"
                        :disabled="state.loading || state.isLoadMore"
                    />
                </div>
                <div class="col-sm-auto ms-auto">
                    <BulkActions
                        :destroy="destroy"
                        :isPicker="isPicker"
                        :isSinglePicker="isSinglePicker"
                        :selectedFiles="state.selectedFiles"
                        :disabled="
                            state.loading ||
                            state.isLoadMore ||
                            state.selectedFiles.length == 0
                        "
                    />
                    <HeaderActions
                        @refresh="refresh"
                        :refreshing="state.refreshing"
                        :disabled="state.loading || state.isLoadMore"
                        @showCreateFolderModal="showCreateFolderModal"
                        @showUploadFilesModal="showUploadFilesModal"
                    />
                </div>
            </div>
        </div>
        <div
            class="card-body"
            @scroll="onScroll"
            :style="`height:${isPicker ? '90vh' : '65vh'}`"
        >
            <Breadcrumb
                @clickItem="onDblClickFile"
                :folderId="state.folderId"
                :items="state.breadcrumb"
            />
            <MainSpinner v-if="state.loading && state.files.length == 0" />
            <Empty v-else-if="!state.loading && state.files.length == 0" />
            <div v-else id="files-container">
                <File
                    v-for="file in state.files"
                    :selected="isSelected(file)"
                    :file="file"
                    :key="file.id"
                    @dblclick="onDblClickFile(file)"
                    @click="onClickFile"
                    @destroy="destroy"
                    @edit="showEditFileModal"
                    @info="showFileInfoModal"
                    @openFolder="onDblClickFile"
                />

                <template v-if="state.isLoadMore">
                    <FilePlaceholderLoader
                        v-for="item in [1, 2, 3, 4, 5, 6, 7, 8, 9]"
                        :key="item"
                    />
                </template>
            </div>

            <EditFileModal
                v-if="state.focusFile != null"
                @close="hideEditFileModal"
                :show="state.editFileModal"
                :file="state.focusFile"
                @onSuccess="refresh"
            />
            <FileInfoModal
                v-if="state.focusFile != null"
                @close="hideFileInfoModal"
                :show="state.fileInfoModal"
                :file="state.focusFile"
            />
            <CreateFolderModal
                @close="hideCreateFolderModal"
                :show="state.createFolderModal"
                :folderId="state.folderId"
                @onSuccess="refresh"
            />
            <UploadFilesModal
                @close="hideUploadFilesModal"
                @refresh="refresh"
                :show="state.uploadFilesModal"
                :folderId="state.folderId"
            />
        </div>
    </div>
</template>

<style>
#file-manager .card-body {
    position: relative;
    overflow-x: hidden;
    overflow-y: scroll;
}
#files-container {
    display: flex;
    flex-wrap: wrap;
}
</style>
