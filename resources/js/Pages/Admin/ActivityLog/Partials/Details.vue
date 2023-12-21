<script setup>
import Card from "@/Shared/Admin/Card.vue";
import LogType from "../Table/LogType.vue";
import HttpMethod from "../Table/HttpMethod.vue";

defineProps({ record: Object });
</script>

<template>
    <Card>
        <template #body>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="info-container">
                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.activity_log.log_date") }}
                            </span>
                            :
                            <span class="value">{{ record.created_at }}</span>
                        </div>
                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.activity_log.batch_uuid") }}
                            </span>
                            :
                            <span class="value">{{ record.batch_uuid }}</span>
                        </div>
                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.activity_log.log_type") }}
                            </span>
                            :
                            <span class="value">
                                <LogType
                                    :type="record.log_type"
                                    :action="record.action"
                                />
                            </span>
                        </div>
                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.activity_log.description") }}
                            </span>
                            :
                            <span class="value">{{ record.description }}</span>
                        </div>

                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.activity_log.subject_id") }}
                            </span>
                            :
                            <span class="value">{{ record.subject_id }}</span>
                        </div>
                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.activity_log.subject_type") }}
                            </span>
                            :
                            <span class="value">{{ record.subject_type }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="info-container">
                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.activity_log.causer_id") }}
                            </span>
                            :
                            <span class="value">{{ record.causer_id }}</span>
                        </div>
                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.activity_log.causer") }}
                            </span>
                            :
                            <span class="value">{{ record.causer }}</span>
                        </div>
                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.activity_log.causer_type") }}
                            </span>
                            :
                            <span class="value">{{ record.causer_type }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4">
                    <div class="info-container">
                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.activity_log.ip") }}
                            </span>
                            :
                            <span class="value">{{ record.ip }}</span>
                        </div>
                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.activity_log.http_method") }}
                            </span>
                            :
                            <span class="value"
                                ><HttpMethod :method="record.http_method"
                            /></span>
                        </div>

                        <div class="info">
                            <span class="title me-2">
                                {{ $t("admin.activity_log.user_agent") }}
                            </span>
                            :
                            <span class="value">{{ record.user_agent }}</span>
                        </div>

                        <template v-if="record.agent">
                            <div class="info">
                                <span class="title me-2">
                                    {{ $t("admin.activity_log.is_desktop") }}
                                </span>
                                :
                                <span class="value">{{
                                    $t(
                                        `admin.activity_log.${
                                            record.agent.is_desktop
                                                ? "yes"
                                                : "no"
                                        }`
                                    )
                                }}</span>
                            </div>

                            <div class="info">
                                <span class="title me-2">
                                    {{ $t("admin.activity_log.platform") }}
                                </span>
                                :
                                <span class="value">{{
                                    record.agent.platform
                                }}</span>
                            </div>

                            <div class="info">
                                <span class="title me-2">
                                    {{ $t("admin.activity_log.browser") }}
                                </span>
                                :
                                <span class="value">
                                    {{ record.agent.browser }}
                                </span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </Card>
</template>

<style scoped>
.info-container .info {
    margin-top: 8px;
    display: flex;
}
.info-container .info .title {
    font-weight: bold;
    width: 100px;
    display: inline-block;
}

.info-container .info .value {
    max-width: 300px;
    display: inline-block;
    padding: 0 10px;
}
</style>
