<script setup>
import Layout from "../../Layout/Index.vue";
import GeneralInformation from "./Partials/GeneralInformation.vue";

defineProps({
    shared: Object,
    userInfo: Object,
});
</script>
<template>
    <Layout :shared="shared">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">
                            <GeneralInformation
                                :userInfo="userInfo"
                                :shared="shared"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
