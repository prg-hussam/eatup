<script setup>
import Modal from "@/Shared/Modal/Index.vue";
import Content from "@/Shared/Modal/Content.vue";
import Header from "@/Shared/Modal/Header.vue";

defineProps({
    show: Boolean,
    file: Object,
});

defineEmits(["close"]);
</script>
<template>
    <Modal id="fileInfoModal" :show="show" @close="$emit('close')">
        <Content>
            <template #header>
                <Header :title="$t('admin.media.information')" />
            </template>
            <template #body>
                <div class="img-container">
                    <img :src="file.preview_image_url" />
                </div>
                <div class="info-container mt-4">
                    <div class="info">
                        <span class="title me-2"
                            >{{ $t("admin.media.show_info.name") }} </span
                        >:
                        <span class="value">{{ file.filename }}</span>
                    </div>
                    <template v-if="!file.is_folder">
                        <div class="info">
                            <span class="title me-2"
                                >{{
                                    $t("admin.media.show_info.mime_type")
                                }} </span
                            >:
                            <span class="value">{{ file.mime }}</span>
                        </div>
                        <div class="info">
                            <span class="title me-2">
                                {{
                                    $t("admin.media.show_info.extension")
                                }} </span
                            >:
                            <span class="value">{{ file.extension }}</span>
                        </div>
                        <div class="info">
                            <span class="title me-2"
                                >{{ $t("admin.media.show_info.size") }} </span
                            >:
                            <span class="value">
                                {{
                                    file.size +
                                    " " +
                                    $t("admin.media.show_info.bytes")
                                }}
                                (
                                {{
                                    file.human_size +
                                    " " +
                                    $t("admin.media.show_info.on_disk")
                                }}
                                )
                            </span>
                        </div>
                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.media.show_info.url") }} </span
                            >:
                            <span class="value">
                                <a :href="file.url" target="_blank">{{
                                    file.url
                                }}</a>
                            </span>
                        </div>
                    </template>
                    <div class="info">
                        <span class="title me-2">
                            {{
                                $t(
                                    `admin.media.show_info.${
                                        file.is_folder
                                            ? "created_at"
                                            : "uploaded_at"
                                    }`
                                )
                            }}
                        </span>
                        :
                        <span class="value">{{ file.created_at }}</span>
                    </div>
                </div>
            </template>
        </Content>
    </Modal>
</template>

<style scoped>
.img-container {
    margin-top: 20px;
    text-align: center;
}

.img-container img {
    width: 100px;
    height: 100px;
    object-fit: contain;
}
.info-container .info {
    margin-top: 8px;
}
.info-container .info .title {
    font-weight: bold;
    width: 100px;
    display: inline-block;
}

.info-container .info .value {
    max-width: 300px;
    display: inline-block;
}
</style>
