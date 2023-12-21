<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import BreadcrumbItem from "@/Shared/Admin/BreadcrumbItem.vue";
import Card from "@/Shared/Admin/Card.vue";
import Input from "@/Shared/Form/Input.vue";
import Checkbox from "@/Shared/Form/Checkbox.vue";
import LoadingButton from "@/Shared/Form/LoadingButton.vue";
import { useToast } from "vue-toastification";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const props = defineProps({
    enabled: Boolean,
    deleteRecordsOlderThanDays: Number,
});

const form = useForm({
    enabled: props.enabled,
    delete_records_older_than_days: props.deleteRecordsOlderThanDays,
});

const submit = () => {
    form.put(route("admin.activity_log.settings.update"), {
        preserveState: true,
        onSuccess: () => {
            toast.success(trans("messages.settings_have_been_saved"));
        },
    });
};
</script>

<template>
    <Head :title="$t('admin.sidebar.activity_log_settings')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.sidebar.activity_log_settings')">
                <BreadcrumbItem active :title="$t('admin.sidebar.settings')" />
                <BreadcrumbItem
                    active
                    :title="$t('admin.sidebar.activity_log_settings')"
                />
            </Breadcrumb>
        </template>
        <template #content>
            <form @submit.prevent="submit">
                <Card>
                    <template #body>
                        <div class="row align-items-center">
                            <div class="col-6">
                                <Input
                                    asterisk
                                    type="number"
                                    v-model="
                                        form.delete_records_older_than_days
                                    "
                                    :error="
                                        form.errors
                                            .delete_records_older_than_days
                                    "
                                    :label="
                                        $t(
                                            'admin.activity_log.attributes.delete_records_older_than_days'
                                        )
                                    "
                                    name="delete_records_older_than_days"
                                />
                            </div>
                            <div class="col-6 mt-2">
                                <Checkbox
                                    v-model:checked="form.enabled"
                                    id="enabled"
                                    :label="
                                        $t('admin.activity_log.form.enable')
                                    "
                                    :error="form.errors.enabled"
                                />
                            </div>
                        </div>
                    </template>
                    <template #footer>
                        <div class="row">
                            <div class="col-12 text-end">
                                <LoadingButton
                                    icon="bx bx-save"
                                    :title="$t('global.buttons.save')"
                                    :loading="form.processing"
                                />
                            </div>
                        </div>
                    </template>
                </Card>
            </form>
        </template>
    </DashboardLayout>
</template>
