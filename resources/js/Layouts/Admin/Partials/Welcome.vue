<script setup>
import useAuth from "@/Uses/auth";
const { user } = useAuth();
</script>

<template>
    <div class="row mb-3 pb-1">
        <div class="col-12">
            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-16 mb-1">
                        {{ $t("admin.dashboard.welcome", { user: user.name }) }}
                    </h4>
                    <p class="text-muted mb-0">
                        {{
                            $t(
                                "admin.dashboard.whats_happening_with_your_account_today"
                            )
                        }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
