<script setup>
import { Link } from "@inertiajs/vue3";
import useGeneral from "@/Uses/general";
const { appName, authCover, authLogo, copyRightText } = useGeneral();
</script>

<template>
    <div class="auth-page-wrapper pt-5">
        <div
            class="auth-one-bg-position auth-one-bg"
            id="auth-particles"
            :style="
                authCover
                    ? { 'background-image': 'url(' + authCover + ')' }
                    : {}
            "
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
                            <div v-if="authLogo">
                                <Link href="/" class="d-inline-block auth-logo">
                                    <img
                                        alt="login_logo"
                                        :src="authLogo"
                                        height="20"
                                    />
                                </Link>
                            </div>
                            <p class="mt-3 fs-15 fw-medium text-white">
                                {{ appName }}
                            </p>
                        </div>
                    </div>
                </div>

                <slot />
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p
                                class="mb-0 text-muted"
                                v-html="copyRightText"
                            ></p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
