<script setup>
import { useForm } from "@inertiajs/vue3";
import FormTabs from "@/Shared/Admin/FormTabs/Index.vue";
import SettingsTab from "../Tabs/Settings.vue";
import SlidesTab from "../Tabs/Slides.vue";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";
import { onBeforeMount } from "vue";

const toast = useToast();
const props = defineProps({
    tabs: Object,
    action: String,
    slider: Object,
});

const form = useForm({
    name: props.slider.name || {},
    slides: [],
    _method: props.action == "store" ? "POST" : "PUT",
});

onBeforeMount(() => {
    if (props.slider.slides) {
        props.slider.slides.forEach((slide) => {
            let data = {
                id: slide.id,
                position: slide.position,
                files: {},
                banners: {},
            };

            slide.banners.forEach((banner) => {
                data.banners[banner.zone] = banner;
                data.files[banner.zone] = banner.id;
            });
            form.slides.push(data);
        });
    }
});
const submit = () => {
    form.transform((data) => ({
        ...data,
    })).post(route(`admin.sliders.${props.action}`, props.slider.id), {
        preserveState: true,
        onSuccess: () => {
            toast.success(
                trans("messages.resource_saved", {
                    resource: trans("admin.sliders.slider"),
                })
            );
        },
    });
};
</script>
<template>
    <FormTabs
        :tabs="tabs"
        :components="{
            Settings: SettingsTab,
            Slides: SlidesTab,
        }"
        :form="form"
        :submit="submit"
        :entity="slider"
    />
</template>
