<script setup>
import SinglePicker from "@/Shared/Form/FilePicker/Single.vue";
import useGeneral from "@/Uses/general";

const { supportedLocales } = useGeneral();

const props = defineProps({
    slide: Object,
    index: Number,
    form: Object,
    index: Number,
    formLocale: String,
});

const removeSlide = () => {
    props.form.slides.splice(props.index, 1);
};

const getEntityFile = (locale) => {
    return props.slide.banners &&
        typeof props.slide?.banners[`banner_${locale}`] != "undefined"
        ? props.slide?.banners[`banner_${locale}`]
        : null;
};
</script>

<template>
    <div class="card border rounded border-dashed shadow-none mb-4">
        <div class="card-header align-items-center d-flex">
            <h6 class="card-title mb-0 flex-grow-1">
                <span class="text-muted fs-16">
                    <i
                        style="cursor: move"
                        class="mdi mdi-drag align-middle"
                    ></i>
                </span>

                {{ $t("admin.sliders.image_slide") }}
            </h6>
            <div class="flex-shrink-0">
                <span
                    role="button"
                    @click="removeSlide"
                    class="text-muted fs-16"
                >
                    <i class="mdi mdi-close align-middle"></i>
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <SinglePicker
                        v-for="(supportedLocale, locale) in supportedLocales"
                        :key="locale"
                        asterisk
                        v-model="slide.files[`banner_${locale}`]"
                        :error="
                            form.errors[
                                `slides.${index}.files.banner_${locale}`
                            ]
                        "
                        :entityFile="getEntityFile(locale)"
                        :label="
                            $t(
                                'admin.sliders.attributes.slides.*.files.banner'
                            ) + ` ( ${supportedLocales[locale].name} )`
                        "
                        :class="locale != formLocale ? 'd-none' : ''"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
