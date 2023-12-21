<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/Admin/AuthLayout.vue";
import Input from "@/Shared/Form/Input.vue";
import LoadingButton from "@/Shared/Form/LoadingButton.vue";

defineProps({
    status: String,
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <Head :title="$t('admin.auth.forgot_password')" />
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
                                {{ $t("admin.auth.forgot_password") }}
                            </h5>
                        </div>

                        <div v-if="status" class="mt-4 alert alert-success">
                            {{ status }}
                        </div>

                        <div class="p-2">
                            <form @submit.prevent="submit">
                                <Input
                                    asterisk
                                    :error="form.errors.email"
                                    :label="$t('admin.auth.attributes.email')"
                                    :placeholder="
                                        $t('admin.auth.enter_your_email')
                                    "
                                    v-model="form.email"
                                    name="email"
                                />

                                <div class="text-center mt-4">
                                    <LoadingButton
                                        class="btn-success w-100"
                                        :title="$t('admin.auth.send_rest_link')"
                                        :loading="form.processing"
                                        :disabled="
                                            form.processing || !form.email
                                        "
                                    />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <p class="mb-0">
                        {{ $t("admin.auth.remember_my_password") }}
                        <Link
                            :href="route('login')"
                            class="fw-semibold text-primary text-decoration-underline"
                        >
                            {{ $t("admin.auth.click_here") }}
                        </Link>
                    </p>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>
