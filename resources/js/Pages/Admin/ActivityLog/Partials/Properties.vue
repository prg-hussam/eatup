<script setup>
import Card from "@/Shared/Admin/Card.vue";
import VueJsonPretty from "vue-json-pretty";
import "vue-json-pretty/lib/styles.css";
defineProps({ properties: Object });
</script>

<template>
    <Card v-if="properties.attributes || properties.old">
        <template #body>
            <div class="row">
                <div v-if="properties.attributes" class="col-sm-12 col-md-6">
                    <h4 class="card-title mb-0 flex-grow-1">
                        {{ $t("admin.activity_log.show_attributes") }}
                    </h4>
                    <div class="mt-3">
                        <VueJsonPretty :data="properties.attributes" />
                    </div>
                </div>
                <div v-if="properties.old" class="col-sm-12 col-md-6">
                    <h4 class="card-title mb-0 flex-grow-1">
                        {{ $t("admin.activity_log.old") }}
                    </h4>
                    <div class="mt-3">
                        <VueJsonPretty :data="properties.old" />
                    </div>
                </div>
            </div>
        </template>
    </Card>
</template>
