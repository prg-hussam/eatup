<script setup>
import useAuth from "@/Uses/auth";
import { trans } from "laravel-vue-i18n";

const emits = defineEmits(["destroy", "click", "edit", "info", "openFolder"]);
const props = defineProps({
    file: Object,
    selected: Boolean,
});
const { can } = useAuth();
const resource = trans(
    `admin.media.${props.file.is_folder ? "folder" : "file"}`
);

const destroy = () => {
    emits("destroy", props.file.id);
};

const onClick = ($event) => {
    emits("click", $event, props.file);
};
const onClickEdit = () => {
    emits("edit", props.file);
};
const onClickInfo = () => {
    emits("info", props.file);
};

const onClickOpenFolder = () => {
    emits("openFolder", props.file);
};

const contextmenu = () => {
    document.getElementById(`fileDropdown-${props.file.id}`).click();
};
</script>
<template>
    <div
        @click.self="onClick"
        class="file-container"
        @contextmenu.prevent="contextmenu"
        :class="{ selected }"
        role="button"
    >
        <img @click="onClick" :src="file.preview_image_url" />
        <p
            @click="onClick"
            class="filename text-dark text-truncate text-center"
        >
            {{ file.filename }}
        </p>
        <p @click="onClick" v-if="!file.is_folder" class="human-size text-dark">
            {{ file.human_size }}
        </p>

        <div class="btn-group">
            <button
                class="btn btn-icon btn-sm waves-effect waves-light shadow-none dropdown-toggle"
                type="button"
                :id="`fileDropdown-${file.id}`"
                data-bs-toggle="dropdown"
                data-bs-auto-close="true"
                aria-expanded="false"
            >
                <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <ul
                class="dropdown-menu"
                :aria-labelledby="`fileDropdown-${file.id}`"
            >
                <li>
                    <a
                        v-if="file.is_folder"
                        class="dropdown-item"
                        href="javascript:void(0);"
                        @click="onClickOpenFolder"
                    >
                        <i
                            class="text-muted fs-16 align-middle me-1 mdi mdi-folder-open-outline"
                        ></i>
                        <span class="align-middle">
                            {{ $t("resource.open", { resource }) }}
                        </span>
                    </a>
                </li>
                <li>
                    <a
                        v-if="!file.is_folder"
                        class="dropdown-item"
                        :href="file.download_url"
                        download
                    >
                        <i
                            class="text-muted fs-16 align-middle me-1 mdi mdi-cloud-download-outline"
                        ></i>
                        <span class="align-middle">
                            {{ $t("resource.download", { resource }) }}
                        </span>
                    </a>
                </li>
                <li>
                    <a
                        @click="onClickEdit"
                        class="dropdown-item"
                        href="javascript:void(0);"
                    >
                        <i
                            class="text-muted fs-16 align-middle me-1 mdi mdi-notebook-edit-outline"
                        ></i>
                        <span class="align-middle">
                            {{ $t("resource.edit", { resource }) }}
                        </span>
                    </a>
                </li>
                <li>
                    <a
                        @click="onClickInfo"
                        class="dropdown-item"
                        href="javascript:void(0);"
                    >
                        <i
                            class="text-muted fs-16 align-middle me-1 mdi"
                            :class="
                                file.is_folder
                                    ? 'mdi-folder-information-outline'
                                    : 'mdi-information-outline'
                            "
                        ></i>
                        <span class="align-middle">
                            {{
                                $t("resource.show", {
                                    resource: $t("admin.media.information"),
                                })
                            }}
                        </span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li v-if="can('admin.media.destroy')">
                    <a
                        @click="destroy"
                        class="dropdown-item text-danger"
                        href="javascript:void(0);"
                    >
                        <i
                            class="fs-16 align-middle me-1 mdi mdi-trash-can-outline"
                        ></i>
                        <span class="align-middle">
                            {{ $t("resource.delete", { resource }) }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
.file-container {
    margin: 6px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    width: 146px;
    height: 146px;
    border: 1px dashed #d2d6de;
    border-radius: 6px;
    position: relative;
}

img {
    width: 80px;
    height: 80px;
    object-fit: contain;
}
.filename {
    margin: 5px 0 1px;
    font-size: 0.7rem;
    width: 120px;
}
.human-size {
    margin: 0;
    font-size: 0.6rem;
}
.selected {
    border-color: #4b39b3;
}
.btn-group {
    position: absolute;
    top: 0;
    right: 0;
}
.dropdown-toggle::after {
    display: none;
}
</style>
