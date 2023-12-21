<script setup>
import { Head } from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/Admin/DashboardLayout.vue";
import InfoCard from "./Partials/InfoCard.vue";
import Cover from "./Partials/Cover.vue";
import NavTabs from "./Partials/Tabs/NavTabs.vue";
import ChangePasswordPane from "./Partials/Tabs/Panes/ChangePassword/Index.vue";
import ProfileInformationPane from "./Partials/Tabs/Panes/ProfileInformation/Index.vue";
import PrivacyPolicyPane from "./Partials/Tabs/Panes/PrivacyPolicy/Index.vue";
import useAuth from "@/Uses/auth";
const { user } = useAuth();
defineProps(["sessions"]);
</script>
<template>
    <Head :title="$t('admin.my_account.my_account')" />
    <DashboardLayout>
        <template #content>
            <Cover />
            <div class="row">
                <div class="col-xl-3">
                    <InfoCard />
                </div>
                <div class="col-xl-9">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <NavTabs />
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <ProfileInformationPane :user="user" />
                                <ChangePasswordPane :sessions="sessions" />
                                <PrivacyPolicyPane />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </DashboardLayout>
</template>
