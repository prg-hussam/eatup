<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/Admin/AuthLayout.vue";
import Input from "@/Shared/Form/Input.vue";
import LoadingButton from "@/Shared/Form/LoadingButton.vue";

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.update"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head :title="$t('admin.auth.reset_password')" />
    <AuthLayout>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="avatar-lg mx-auto">
                                <div
                                    class="avatar-title bg-light text-primary display-5 rounded-circle shadow"
                                >
                                    <i class="mdi mdi-lock-reset"></i>
                                </div>
                            </div>
                            <h5 class="text-primary mt-4">
                                {{ $t("admin.auth.reset_password") }}
                            </h5>
                        </div>

                        <div class="p-2">
                            <form @submit.prevent="submit">
                                <Input
                                    asterisk
                                    :error="form.errors.password"
                                    :label="
                                        $t('admin.auth.attributes.new_password')
                                    "
                                    :placeholder="
                                        $t('admin.auth.enter_new_password')
                                    "
                                    v-model="form.password"
                                    type="password"
                                    name="password"
                                />
                                <Input
                                    asterisk
                                    :error="form.errors.password_confirmation"
                                    :label="
                                        $t(
                                            'admin.auth.attributes.new_password_confirmation'
                                        )
                                    "
                                    :placeholder="
                                        $t(
                                            'admin.auth.enter_new_password_confirmation'
                                        )
                                    "
                                    v-model="form.password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                />

                                <div class="text-center mt-4">
                                    <LoadingButton
                                        class="btn-success w-100"
                                        :title="$t('admin.auth.reset_password')"
                                        :loading="form.processing"
                                        :disabled="
                                            form.processing ||
                                            !form.password ||
                                            !form.password_confirmation
                                        "
                                    />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>
