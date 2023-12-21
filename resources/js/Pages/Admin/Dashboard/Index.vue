<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import Breadcrumb from "@/Shared/Admin/Breadcrumb.vue";
import Welcome from "@/Layouts/Admin/Partials/Welcome.vue";
import Analytics from "@/Widgets/BuildIn/Analytics.vue";
import useAuth from "@/Uses/auth";

defineProps({ totalUsers: Number });
const { can } = useAuth();
</script>

<template>
    <Head :title="$t('admin.dashboard.dashboard')" />
    <DashboardLayout>
        <template #breadcrumb>
            <Breadcrumb :title="$t('admin.dashboard.dashboard')" />
        </template>
        <template #content>
            <Welcome />
            <div class="row">
                <Analytics
                    :visible="can('admin.users.index')"
                    :title="$t('admin.dashboard.total_users')"
                    :value="totalUsers"
                    iconClass="mdi mdi-account-outline"
                />
            </div>
        </template>
    </DashboardLayout>
</template>
