<script setup>
import { useToast } from "vue-toastification";
import Input from "@/Shared/Form/Input.vue";
import LoadingButton from "@/Shared/Form/LoadingButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "@vue/reactivity";
import { trans } from "laravel-vue-i18n";

const toast = useToast();
const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const form = useForm({
    current_password: null,
    password: null,
    password_confirmation: null,
});

const submit = () => {
    form.put(route("user-password.update"), {
        errorBag: "updatePassword",
        onSuccess: () => {
            form.reset();
            toast.success(trans("messages.password_updated"));
        },
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>
<template>
    <div class="p-2 mt-4">
        <form @submit.prevent="submit">
            <div class="row">
                <div class="col-lg-4">
                    <Input
                        ref="currentPasswordInput"
                        asterisk
                        v-model="form.current_password"
                        :error="form.errors.current_password"
                        :label="
                            $t('admin.my_account.attributes.current_password')
                        "
                        type="password"
                        name="current_password"
                    />
                </div>
                <div class="col-lg-4">
                    <Input
                        asterisk
                        ref="passwordInput"
                        v-model="form.password"
                        :error="form.errors.password"
                        :label="$t('admin.my_account.attributes.new_password')"
                        type="password"
                        name="password"
                    />
                </div>
                <div class="col-lg-4">
                    <Input
                        asterisk
                        v-model="form.password_confirmation"
                        :error="form.errors.password_confirmation"
                        :label="
                            $t('admin.my_account.attributes.confirm_password')
                        "
                        type="password"
                        name="password_confirmation"
                    />
                </div>
            </div>
            <div class="col-lg-12">
                <div class="text-end">
                    <LoadingButton
                        class="btn-success"
                        :title="$t('admin.my_account.change_password')"
                        :loading="form.processing"
                        :disabled="
                            form.processing ||
                            !form.current_password ||
                            !form.password ||
                            !form.password_confirmation
                        "
                    />
                </div>
            </div>
        </form>
    </div>
</template>
