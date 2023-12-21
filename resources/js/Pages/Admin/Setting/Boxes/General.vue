<script setup>
import Content from "@/Shared/Modal/Content.vue";
import Footer from "@/Shared/Modal/Footer.vue";
import Header from "@/Shared/Modal/Header.vue";
import Label from "@/Shared/Form/Label.vue";
import MultiSelect from "@/Shared/Form/MultiSelect.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import { onMounted } from "@vue/runtime-core";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const emits = defineEmits(["closeModal", "modal:options"]);
onMounted(() => {
    emits("modal:options", {
        scrollable: false,
    });
});

const props = defineProps([
    "title",
    "name",
    "locales",
    "timeZones",
    "dateFormats",
    "settings",
    "weekDays",
]);

const form = useForm({
    supported_locales: props.settings.supported_locales,
    default_locale: props.settings.default_locale,
    default_timezone: props.settings.default_timezone,
    default_dateformat: props.settings.default_dateformat,
    week_starts_at: props.settings.week_starts_at,
    week_ends_at: props.settings.week_ends_at,
});

const submit = () => {
    form.put(route("admin.settings.update", { name: props.name }), {
        errorBag: "UpdateSetting",
        preserveState: true,
        onSuccess: () => {
            toast.success(trans("messages.settings_have_been_saved"));
            emits("closeModal");
        },
    });
};
</script>
<template>
    <form @submit.prevent="submit">
        <Content>
            <template #header>
                <Header :title="$t(title)" />
            </template>
            <template #body>
                <MultiSelect
                    :label="$t('admin.settings.attributes.supported_locales')"
                    :error="form.errors.supported_locales"
                    v-model="form.supported_locales"
                    :options="locales"
                    name="supported-locales"
                    asterisk
                    multiple
                />

                <MultiSelect
                    :label="$t('admin.settings.attributes.default_locale')"
                    :error="form.errors.default_locale"
                    v-model="form.default_locale"
                    name="default-locale"
                    :closeOnSelect="true"
                    :options="locales"
                    asterisk
                />

                <MultiSelect
                    :label="$t('admin.settings.attributes.default_timezone')"
                    :error="form.errors.default_timezone"
                    v-model="form.default_timezone"
                    name="default-timezone"
                    :closeOnSelect="true"
                    :options="timeZones"
                    asterisk
                />

                <MultiSelect
                    :label="$t('admin.settings.attributes.default_dateformat')"
                    :error="form.errors.default_dateformat"
                    v-model="form.default_dateformat"
                    name="default-dateformat"
                    :closeOnSelect="true"
                    :options="dateFormats"
                    asterisk
                />

                <MultiSelect
                    :label="$t('admin.settings.attributes.week_starts_at')"
                    :error="form.errors.week_starts_at"
                    v-model="form.week_starts_at"
                    name="week-starts-at"
                    closeOnSelect
                    :options="weekDays"
                    asterisk
                />

                <MultiSelect
                    :label="$t('admin.settings.attributes.week_ends_at')"
                    :error="form.errors.week_ends_at"
                    v-model="form.week_ends_at"
                    name="week-ends-at"
                    closeOnSelect
                    :options="weekDays"
                    asterisk
                />
            </template>
            <template #footer>
                <Footer :loading="form.processing" />
            </template>
        </Content>
    </form>
</template>
