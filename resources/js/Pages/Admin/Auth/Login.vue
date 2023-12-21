<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/Admin/AuthLayout.vue";
import Input from "@/Shared/Form/Input.vue";
import LoadingButton from "@/Shared/Form/LoadingButton.vue";
import Checkbox from "@/Shared/Form/Checkbox.vue";
import useGeneral from "@/Uses/general";

defineProps({
    canResetPassword: Boolean,
    status: String,
    errors: Object,
});
const { appName } = useGeneral();
const form = useForm({
    username: null,
    password: null,
    remember: false,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>
<template>
    <Head :title="$t('admin.auth.signin')" />
    <AuthLayout>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">
                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">
                                {{ $t("admin.auth.welcome_back") }}
                            </h5>
                            <p class="text-muted">
                                {{
                                    $t("admin.auth.sign_in_to_continue_to", {
                                        app_name: appName,
                                    })
                                }}
                            </p>
                        </div>
                        <div v-if="status" class="mt-4 alert alert-success">
                            {{ status }}
                        </div>
                        <div class="p-2 mt-4">
                            <form @submit.prevent="submit">
                                <Input
                                    asterisk
                                    v-model="form.username"
                                    :error="form.errors.username"
                                    :placeholder="
                                        $t('admin.auth.enter_your_username')
                                    "
                                    :label="
                                        $t('admin.auth.attributes.username')
                                    "
                                    name="username"
                                />
                                <Input
                                    asterisk
                                    v-model="form.password"
                                    :error="form.errors.password"
                                    type="password"
                                    :placeholder="
                                        $t('admin.auth.enter_your_password')
                                    "
                                    :label="
                                        $t('admin.auth.attributes.password')
                                    "
                                    name="password"
                                >
                                    <template
                                        v-if="canResetPassword"
                                        #floatEndContent
                                    >
                                        <Link
                                            v-if="canResetPassword"
                                            :href="route('password.request')"
                                            class="text-muted"
                                        >
                                            {{
                                                $t(
                                                    "admin.auth.forgot_your_password"
                                                )
                                            }}
                                        </Link>
                                    </template>
                                </Input>

                                <Checkbox
                                    v-model:checked="form.remember"
                                    id="remember"
                                    :label="
                                        $t('admin.auth.attributes.remember_me')
                                    "
                                />

                                <div class="mt-4">
                                    <LoadingButton
                                        class="btn-success w-100"
                                        :title="$t('admin.auth.signin')"
                                        :loading="form.processing"
                                        :disabled="
                                            form.processing ||
                                            !form.username ||
                                            !form.password
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
