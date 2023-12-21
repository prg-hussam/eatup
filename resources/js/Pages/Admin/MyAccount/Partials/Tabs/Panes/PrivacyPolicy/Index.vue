<script setup>
import TwoFactorAuthentication from "./Partials/TwoFactorAuthentication.vue";
</script>

<template>
    <div class="tab-pane" id="privacyPolicy" role="tabpanel">
        <div class="mb-4 pb-2">
            <h5 class="card-title text-decoration-underline mb-3">
                {{ $t("admin.my_account.security") }}:
            </h5>
            <TwoFactorAuthentication />
        </div>
    </div>
</template>
