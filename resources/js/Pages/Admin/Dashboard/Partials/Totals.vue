<script setup>
import Analytics from "@/Widgets/BuildIn/Analytics.vue";
import useAuth from "@/Uses/auth";
defineProps({ totals: Object });
const { can } = useAuth();
</script>

<template>
    <div class="row">
        <Analytics
            :visible="can('admin.customers.index')"
            :title="$t('admin.dashboard.total_customers')"
            :value="totals.customers"
            iconClass="mdi mdi-account-outline"
        />
        <Analytics
            :visible="can('admin.subscriptions.index')"
            :title="$t('admin.dashboard.total_active_subscriptions')"
            :value="totals.activeSubscriptions"
            iconClass="mdi mdi-check-circle-outline"
            bgColor="bg-success"
        />
        <Analytics
            :visible="can('admin.subscriptions.index')"
            :title="$t('admin.dashboard.total_expired_subscriptions')"
            :value="totals.expiredSubscriptions"
            iconClass="mdi mdi-close-circle-outline"
            bgColor="bg-danger"
        />
        <Analytics
            :visible="can('admin.subscriptions.index')"
            :title="$t('admin.dashboard.total_unpaid_subscriptions')"
            :value="totals.unpaidSubscriptions"
            iconClass="mdi mdi-close-outline"
            bgColor="bg-danger"
        />
    </div>
</template>
