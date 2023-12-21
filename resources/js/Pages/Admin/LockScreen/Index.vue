<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import Input from "@/Shared/Form/Input.vue";
import LoadingButton from "@/Shared/Form/LoadingButton.vue";
import useAuth from "@/Uses/auth";
import useGeneral from "@/Uses/general";

const { user } = useAuth();
const { appName, authCover, authLogo } = useGeneral();
const form = useForm({
    password: null,
});

const submit = () => {
    form.put(route("admin.users.lock_screen.unlock"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head :title="$t('admin.dashboard.lock_screen')" />

    <div class="auth-page-wrapper pt-5">
        <div
            class="auth-one-bg-position auth-one-bg"
            id="auth-particles"
            :style="{ 'background-image': 'url(' + authCover + ')' }"
        >
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    version="1.1"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120"
                >
                    <path
                        d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"
                    ></path>
                </svg>
            </div>
        </div>

        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <Link href="#" class="d-inline-block auth-logo">
                                    <img :src="authLogo" alt="" height="20" />
                                </Link>
                            </div>
                            <p class="mt-3 fs-15 fw-medium text-white">
                                {{ appName }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary text-capitalize">
                                        {{ $t("admin.dashboard.lock_screen") }}
                                    </h5>
                                    <p class="text-muted">
                                        {{
                                            $t(
                                                "admin.dashboard.enter_your_password_to_unlock_the_screen"
                                            )
                                        }}
                                    </p>
                                </div>
                                <div class="user-thumb text-center">
                                    <img
                                        :src="user.profile_photo_url"
                                        class="rounded-circle img-thumbnail avatar-lg shadow"
                                        alt="thumbnail"
                                    />
                                    <h5 class="font-size-15 mt-3">
                                        {{ user.name }}
                                    </h5>
                                </div>

                                <div class="p-2 mt-4">
                                    <form @submit.prevent="submit">
                                        <Input
                                            v-model="form.password"
                                            :error="form.errors.password"
                                            type="password"
                                            :placeholder="
                                                $t(
                                                    'admin.auth.enter_your_password'
                                                )
                                            "
                                            :label="
                                                $t(
                                                    'admin.auth.enter_your_password'
                                                )
                                            "
                                        >
                                        </Input>

                                        <div class="mt-4">
                                            <LoadingButton
                                                class="btn-success w-100"
                                                :title="
                                                    $t('admin.dashboard.unlock')
                                                "
                                                :loading="form.processing"
                                                :disabled="
                                                    form.processing ||
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
            </div>
        </div>
    </div>
</template>
