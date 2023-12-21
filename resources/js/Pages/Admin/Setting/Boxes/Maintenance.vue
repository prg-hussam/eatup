<script setup>
import Content from "@/Shared/Modal/Content.vue";
import Footer from "@/Shared/Modal/Footer.vue";
import Header from "@/Shared/Modal/Header.vue";
import Checkbox from "@/Shared/Form/Checkbox.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const emits = defineEmits(["closeModal"]);
const props = defineProps(["title", "settings", "name"]);

const form = useForm({
    maintenance_mode: props.settings.maintenance_mode || false,
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
                <Checkbox
                    v-model:checked="form.maintenance_mode"
                    id="maintenance_mode"
                    :label="
                        $t(
                            'admin.settings.form.put_the_application_into_maintenance_mode'
                        )
                    "
                    :error="form.errors.maintenance_mode"
                />
            </template>
            <template #footer>
                <Footer :loading="form.processing" />
            </template>
        </Content>
    </form>
</template>
