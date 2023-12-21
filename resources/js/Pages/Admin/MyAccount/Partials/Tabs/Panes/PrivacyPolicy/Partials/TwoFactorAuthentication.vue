<script setup>
import LoadingButton from "@/Shared/Form/LoadingButton.vue";
import Input from "@/Shared/Form/Input.vue";
import ConfirmPassword from "@/Shared/Admin/ConfirmPassword.vue";
import { ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import { copyText } from "vue3-clipboard";
import { useToast } from "vue-toastification";
import useAuth from "@/Uses/auth";
const enabling = ref(false);
const disabling = ref(false);
const qrCode = ref(null);
const setupKey = ref(null);
const recoveryCodes = ref([]);
const confirmationForm = useForm({
    _method: "POST",
    code: null,
});
const toast = useToast();
const { user } = useAuth();
const doCopy = () => {
    copyText(recoveryCodes.value, undefined, (error, event) => {
        if (error) {
        } else {
            toast.success($t("messages.copied_to_clipboard"));
        }
    });
};

const enable2fa = () => {
    enabling.value = true;
    router.post(
        route("two-factor.enable"),
        {},
        {
            preserveScroll: true,
            onSuccess: () =>
                Promise.all([
                    showQrCode(),
                    showSetupKey(),
                    showRecoveryCodes(),
                ]),
            onFinish: () => (enabling.value = false),
        }
    );
};

const disable2fz = () => {
    disabling.value = true;
    router.delete(route("two-factor.disable"), {
        preserveScroll: true,
        onSuccess: () => {
            user.two_factor_enabled = false;
            disabling.value = false;
        },
    });
};

const showQrCode = () => {
    return axios.get(route("two-factor.qr-code")).then((response) => {
        qrCode.value = response.data.svg;
    });
};

const showSetupKey = () => {
    return axios.get(route("two-factor.secret-key")).then((response) => {
        setupKey.value = response.data.secretKey;
    });
};

const showRecoveryCodes = () => {
    return axios.get(route("two-factor.recovery-codes")).then((response) => {
        recoveryCodes.value = response.data;
    });
};

const regenerateRecoveryCodes = () => {
    return axios
        .post("/admin/user/two-factor-recovery-codes")
        .then((response) => {
            showRecoveryCodes();
        });
};

const confirm2fa = () => {
    confirmationForm.post(route("two-factor.confirm"), {
        errorBag: "confirmTwoFactorAuthentication",
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            user.two_factor_enabled = true;
            qrCode.value = null;
            setupKey.value = null;
        },
    });
};
</script>

<template>
    <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0">
        <div class="flex-grow-1">
            <h6 class="fs-14 mb-1">
                <span v-if="user.two_factor_enabled">
                    {{
                        $t(
                            "admin.my_account.two_factor_authentication.have_enabled"
                        )
                    }}
                </span>
                <span v-else-if="qrCode && !user.two_factor_confirmed">
                    {{
                        $t(
                            "admin.my_account.two_factor_authentication.finish_enabling"
                        )
                    }}
                </span>
                <span v-else>
                    {{
                        $t(
                            "admin.my_account.two_factor_authentication.not_enabled"
                        )
                    }}
                </span>
            </h6>
            <p class="text-muted">
                <span>
                    {{
                        $t(
                            "admin.my_account.two_factor_authentication.description"
                        )
                    }}
                </span>
            </p>
            <div>
                <div v-if="qrCode" class="qrcode-container">
                    <p>
                        {{
                            $t(
                                "admin.my_account.two_factor_authentication.qrcode_note"
                            )
                        }}
                    </p>

                    <div class="mt-4" v-html="qrCode"></div>
                    <p class="text-muted mt-2" v-if="setupKey">
                        {{
                            $t(
                                "admin.my_account.two_factor_authentication.setup_key"
                            )
                        }}:
                        <span v-html="setupKey"></span>
                    </p>
                    <div
                        v-if="!user.two_factor_confirmed && qrCode"
                        class="col-sm-12 col-md-8 mt-3"
                    >
                        <form @submit.prevent="confirm2fa" class="w-50">
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-8">
                                        <Input
                                            v-model="confirmationForm.code"
                                            :error="
                                                confirmationForm.errors.code
                                            "
                                            :placeholder="
                                                $t(
                                                    'admin.my_account.attributes.code'
                                                )
                                            "
                                        />
                                    </div>
                                    <div class="col-4">
                                        <LoadingButton
                                            class="btn-primary"
                                            :title="
                                                $t('global.buttons.confirm')
                                            "
                                            :loading="
                                                confirmationForm.processing
                                            "
                                            :disabled="
                                                !confirmationForm.code ||
                                                confirmationForm.processing
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div
                    v-if="recoveryCodes.length > 0 && user.two_factor_enabled"
                    class="qrcode-recovery-codes mt-3"
                >
                    <p>
                        {{
                            $t(
                                "admin.my_account.two_factor_authentication.recovery_codes_note"
                            )
                        }}
                    </p>
                    <div class="bg-light p-3">
                        <button
                            class="btn btn-icon btn-primary float-end btn-sm"
                            type="button"
                            @click="doCopy"
                        >
                            <i class="bx bx-copy"></i>
                        </button>
                        <div v-for="code in recoveryCodes" :key="code">
                            <p class="recovery-code user-select-all">
                                {{ code }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-2" v-if="user.two_factor_enabled">
                    <ConfirmPassword
                        v-if="recoveryCodes.length == 0"
                        @confirmed="showRecoveryCodes"
                        id="confirm-password-show-recovery-codes"
                    >
                        <LoadingButton
                            class="btn btn-light bg-gradient"
                            :title="
                                $t(
                                    'admin.my_account.two_factor_authentication.show_recovery_codes'
                                )
                            "
                        />
                    </ConfirmPassword>
                    <ConfirmPassword
                        v-if="recoveryCodes.length > 0"
                        @confirmed="regenerateRecoveryCodes"
                        id="confirm-password-regenerate-recovery-codes"
                    >
                        <LoadingButton
                            class="btn btn-light bg-gradient"
                            :title="
                                $t(
                                    'admin.my_account.two_factor_authentication.regenerate_recovery_codes'
                                )
                            "
                        />
                    </ConfirmPassword>
                </div>
            </div>
        </div>
        <div class="flex-shrink-0 ms-sm-3">
            <ConfirmPassword
                v-if="!user.two_factor_enabled && !qrCode"
                :disabled="enabling"
                @confirmed="enable2fa"
                id="confirm-password-enable-2fa"
            >
                <LoadingButton
                    class="btn-primary btn-sm"
                    :title="
                        $t(
                            'admin.my_account.two_factor_authentication.btn_enable'
                        )
                    "
                    :loading="enabling"
                />
            </ConfirmPassword>

            <ConfirmPassword
                v-if="user.two_factor_enabled"
                :disabled="disabling"
                @confirmed="disable2fz"
                id="confirm-password-disable-2fa"
            >
                <LoadingButton
                    class="btn-danger btn-sm"
                    :title="
                        $t(
                            'admin.my_account.two_factor_authentication.btn_disable'
                        )
                    "
                    :loading="disabling"
                />
            </ConfirmPassword>
        </div>
    </div>
</template>

<style scoped>
.recovery-code {
    margin-bottom: 7px;
    font-size: 1rem;
}
</style>
