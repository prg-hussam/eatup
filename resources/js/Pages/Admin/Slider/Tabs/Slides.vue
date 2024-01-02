<script setup>
import useGeneral from "@/Uses/general";
import { onMounted } from "vue";
import Slide from "../Partials/Slide.vue";
const props = defineProps({
    form: Object,
    tab: Object,
    entity: Object,
    formLocale: String,
});
const { supportedLocales } = useGeneral();

const addSlide = () => {
    const slide = {
        id: Date.now(),
        position: null,
        files: {},
    };

    Object.keys(supportedLocales).forEach((key) => {
        slide.files[`banner_${key}`] = null;
    });

    props.form.slides.push(slide);
};

onMounted(() => {
    if (props.form.slides.length == 0) {
        addSlide();
    }
});
</script>

<template>
    <div class="row">
        <Slide
            v-for="(slide, index) in form.slides"
            :slide="slide"
            :index="index"
            :form="form"
            :key="slide.id"
            :formLocale="formLocale"
        />
        <div class="col-12 text-end">
            <button
                type="button"
                @click="addSlide"
                class="btn btn-light waves-effect"
            >
                <i class="mdi mdi-plus align-bottom me-1"></i>
                {{ $t("admin.sliders.add_slide") }}
            </button>
        </div>
    </div>
</template>
