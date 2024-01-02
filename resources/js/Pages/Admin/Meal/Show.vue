<script setup>
import Content from "@/Shared/Modal/Content.vue";
import Header from "@/Shared/Modal/Header.vue";
import { onMounted } from "vue";
import ContentHeader from "./Partials/Show/Header.vue";

const emits = defineEmits(["modal:options"]);

onMounted(() => {
    emits("modal:options", {
        scrollable: false,
        maxWidth: "lg",
    });
});

defineProps({
    meal: Object,
});
</script>
<template>
    <Content>
        <template #header>
            <Header
                :title="
                    $t('resource.show', {
                        resource: $t('admin.meals.meal'),
                    })
                "
            />
        </template>
        <template #body>
            <ContentHeader :meal="meal" />
            <dl class="row">
                <dt class="col-sm-3">Menus</dt>
                <dd class="col-sm-9">
                    <span
                        v-for="menu in meal.menus.data"
                        :key="menu.id"
                        class="badge border me-2 border-secondary text-secondary"
                        >{{ menu.name }}</span
                    >
                </dd>
            </dl>
        </template>
    </Content>
</template>
