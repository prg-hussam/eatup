<script setup>
import { nextTick, ref, onMounted } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/Admin/AuthLayout.vue";
import Input from "@/Shared/Form/Input.vue";
import LoadingButton from "@/Shared/Form/LoadingButton.vue";
import ValidationErrors from "@/Shared/ValidationErrors.vue";

const form = useForm({
    code: "",
    recovery_code: "",
});

const recovery = ref(false);
const recoveryCodeInput = ref(null);

const toggleRecovery = async () => {
    recovery.value ^= true;

    await nextTick();
    if (recovery.value) {
        recoveryCodeInput.value.focus();
        form.code = "";
    } else {
        initTwoStepsForm();
        form.recovery_code = "";
    }
};
onMounted(() => {
    initTwoStepsForm();
});

const submit = () => {
    form.post(route("two-factor.login"));
};

const initTwoStepsForm = () => {
    document.getElementById("first-input").focus();
    for (let t of document.querySelector(".numeral-mask-wrapper").children)
        t.onkeyup = function (e) {
            t.nextElementSibling &&
                this.value.length ===
                    parseInt(this.attributes.maxlength.value) &&
                t.nextElementSibling.focus(),
                !t.previousElementSibling ||
                    (8 !== e.keyCode && 46 !== e.keyCode) ||
                    t.previousElementSibling.focus();
        };
    const n = document.querySelector("#twoStepsForm");
    const i = n.querySelectorAll(".numeral-mask"),
        t = function () {
            let t = !0,
                o = "";
            i.forEach((e) => {
                o += e.value;
            }),
                (form.code = o);
            if (o.length == 6) submit();
        };
    i.forEach((e) => {
        e.addEventListener("keyup", t);
    });
};
</script>

<template>
    <Head :title="$t('admin.auth.two_factor_confirmation')" />
    <AuthLayout>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">
                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">
                                {{ $t("admin.auth.two_factor_confirmation") }}
                            </h5>
                            <p class="text-muted text-left">
                                <template v-if="!recovery">
                                    {{
                                        $t(
                                            "admin.auth.two_factor_confirmation_text1"
                                        )
                                    }}
                                </template>
                                <template v-else>
                                    {{
                                        $t(
                                            "admin.auth.two_factor_confirmation_text2"
                                        )
                                    }}
                                </template>
                            </p>
                        </div>
                        <div class="p-2 mt-4">
                            <ValidationErrors class="mb-3" />
                            <form @submit.prevent="submit" id="twoStepsForm">
                                <div class="mb-3" v-if="!recovery">
                                    <div
                                        class="d-flex align-items-center justify-content-sm-between numeral-mask-wrapper"
                                    >
                                        <input
                                            type="text"
                                            id="first-input"
                                            class="form-control form-control-lg bg-light numeral-mask text-center mx-1 my-2"
                                            maxlength="1"
                                        />
                                        <input
                                            type="text"
                                            class="form-control form-control-lg bg-light numeral-mask text-center mx-1 my-2"
                                            maxlength="1"
                                        />
                                        <input
                                            type="text"
                                            class="form-control form-control-lg bg-light numeral-mask text-center mx-1 my-2"
                                            maxlength="1"
                                        />
                                        <input
                                            type="text"
                                            class="form-control form-control-lg bg-light numeral-mask text-center mx-1 my-2"
                                            maxlength="1"
                                        />
                                        <input
                                            type="text"
                                            class="form-control form-control-lg bg-light numeral-mask text-center mx-1 my-2"
                                            maxlength="1"
                                        />
                                        <input
                                            type="text"
                                            class="form-control form-control-lg bg-light numeral-mask text-center mx-1 my-2"
                                            maxlength="1"
                                        />
                                    </div>
                                </div>
                                <Input
                                    v-else
                                    asterisk
                                    ref="recoveryCodeInput"
                                    v-model="form.recovery_code"
                                    autocomplete="one-time-code"
                                    autofocus
                                    :label="
                                        $t(
                                            'admin.auth.attributes.recovery_code'
                                        )
                                    "
                                />

                                <div class="mt-4 text-center">
                                    <p
                                        role="button"
                                        class="mb-0 text-muted text-decoration-underline"
                                        @click.prevent="toggleRecovery"
                                    >
                                        <small>
                                            <template v-if="!recovery">
                                                {{
                                                    $t(
                                                        "admin.auth.use_a_recovery_code"
                                                    )
                                                }}
                                            </template>
                                            <template v-else>
                                                {{
                                                    $t(
                                                        "admin.auth.use_an_authentication_code"
                                                    )
                                                }}
                                            </template>
                                        </small>
                                    </p>
                                </div>
                                <div class="mt-4" v-if="recovery">
                                    <LoadingButton
                                        class="btn-success w-100"
                                        :title="$t('admin.auth.signin')"
                                        :loading="form.processing"
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
