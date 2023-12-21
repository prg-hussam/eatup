<script setup>
import Input from "@/Shared/Form/Input.vue";
import LoadingButton from "@/Shared/Form/LoadingButton.vue";
import { useToast } from "vue-toastification";
import { useForm } from "@inertiajs/vue3";
import { trans } from "laravel-vue-i18n";

const props = defineProps({ user: Object });
const toast = useToast();
const form = useForm({
    _method: "PUT",
    name: props.user.name,
    email: props.user.email,
});

const submit = () => {
    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        onSuccess: () => toast.success(trans("messages.profile_updated")),
    });
};
</script>

<template>
    <div class="tab-pane active" id="profileInformation" role="tabpanel">
        <div class="p-2 mt-4">
            <form @submit.prevent="submit">
                <div class="row">
                    <div class="col-lg-6">
                        <Input
                            asterisk
                            v-model="form.name"
                            :error="form.errors.name"
                            :label="$t('admin.my_account.attributes.name')"
                            name="name"
                        />
                    </div>
                    <div class="col-lg-6">
                        <Input
                            asterisk
                            v-model="form.email"
                            :error="form.errors.email"
                            :label="$t('admin.my_account.attributes.email')"
                            type="email"
                            name="email"
                        />
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="text-end">
                        <LoadingButton
                            class="btn-success"
                            :title="$t('global.buttons.save')"
                            :loading="form.processing"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
