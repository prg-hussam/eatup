<script setup>
import Content from "@/Shared/Modal/Content.vue";
import Footer from "@/Shared/Modal/Footer.vue";
import Header from "@/Shared/Modal/Header.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import { onMounted } from "@vue/runtime-core";
import SinglePicker from "@/Shared/Form/FilePicker/Single.vue";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const emits = defineEmits(["closeModal", "modal:options"]);
onMounted(() => {
    emits("modal:options", {
        maxWidth: "lg",
    });
});

const props = defineProps([
    "title",
    "name",
    "settings",
    "dashboardSidebarLogo",
    "dashboardSidebarIcon",
    "dashboardFavIcon",
    "dashboardAuthCover",
    "dashboardAuthLogo",
    "mailLogo",
]);

const form = useForm({
    dashboard_sidebar_logo: props.settings.dashboard_sidebar_logo,
    dashboard_fav_icon: props.settings.dashboard_fav_icon,
    dashboard_sidebar_icon: props.settings.dashboard_sidebar_icon,
    dashboard_auth_cover: props.settings.dashboard_auth_cover,
    dashboard_auth_logo: props.settings.dashboard_auth_logo,
    mail_logo: props.settings.mail_logo,
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
                <div class="row">
                    <div class="col-12 col-xl-3">
                        <SinglePicker
                            :entityFile="dashboardSidebarLogo.data"
                            v-model="form.dashboard_sidebar_logo"
                            :label="
                                $t(
                                    'admin.settings.attributes.dashboard_sidebar_logo'
                                )
                            "
                        />
                    </div>
                    <div class="col-12 col-xl-3">
                        <SinglePicker
                            :entityFile="dashboardSidebarIcon.data"
                            v-model="form.dashboard_sidebar_icon"
                            :label="
                                $t(
                                    'admin.settings.attributes.dashboard_sidebar_icon'
                                )
                            "
                        />
                    </div>
                    <div class="col-12 col-xl-3">
                        <SinglePicker
                            :entityFile="dashboardFavIcon.data"
                            v-model="form.dashboard_fav_icon"
                            :label="
                                $t(
                                    'admin.settings.attributes.dashboard_fav_icon'
                                )
                            "
                        />
                    </div>
                    <div class="col-12 col-xl-3">
                        <SinglePicker
                            :entityFile="mailLogo.data"
                            v-model="form.mail_logo"
                            :label="$t('admin.settings.attributes.mail_logo')"
                        />
                    </div>
                    <div class="col-12 col-xl-3">
                        <SinglePicker
                            :entityFile="dashboardAuthCover.data"
                            v-model="form.dashboard_auth_cover"
                            :label="
                                $t(
                                    'admin.settings.attributes.dashboard_auth_cover'
                                )
                            "
                        />
                    </div>
                    <div class="col-12 col-xl-3">
                        <SinglePicker
                            :entityFile="dashboardAuthLogo.data"
                            v-model="form.dashboard_auth_logo"
                            :label="
                                $t(
                                    'admin.settings.attributes.dashboard_auth_logo'
                                )
                            "
                        />
                    </div>
                </div>
            </template>
            <template #footer>
                <Footer :loading="form.processing" />
            </template>
        </Content>
    </form>
</template>
