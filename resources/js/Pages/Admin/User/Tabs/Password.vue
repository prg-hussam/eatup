<script setup>
import Input from "@/Shared/Form/Input.vue";
import LoadingButton from "@/Shared/Form/LoadingButton.vue";
import { reactive } from "vue";
import { useToast } from "vue-toastification";
const props = defineProps({
    form: Object,
    entity: Object,
});

const toast = useToast();

const resetPasswordForm = reactive({
    id: props.entity.id,
    processing: false,
});

const submitResetPassword = () => {
    resetPasswordForm.processing = true;
    axios
        .post(route("admin.users.reset_password"), {
            id: resetPasswordForm.id,
        })
        .then(function (response) {
            toast.success(response.data);
            resetPasswordForm.processing = false;
        })
        .catch(function (error) {
            toast.error(error.response.data);
            resetPasswordForm.processing = false;
        });
};
</script>

<template>
    <div class="row mb-3">
        <div class="col-12">
            <Input
                asterisk
                type="password"
                v-model="form.password"
                :error="form.errors.password"
                :label="$t('admin.users.attributes.password')"
                name="password"
            />
            <Input
                asterisk
                type="password"
                v-model="form.password_confirmation"
                :error="form.errors.password"
                :label="$t('admin.users.attributes.password_confirmation')"
                name="password_confirmation"
            />
        </div>
        <div class="col-12">
            <div class="mt-2 text-center">
                <div class="signin-other-title">
                    <h5 class="fs-13 mb-4 title">
                        {{ $t("admin.users.or_reset_password") }}
                    </h5>
                </div>
                <div>
                    <form @submit.prevent="submitResetPassword">
                        <LoadingButton
                            class="btn-info w-100"
                            :title="$t('admin.users.send_reset_password_email')"
                            :loading="resetPasswordForm.processing"
                            :disabled="resetPasswordForm.processing"
                        />
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
