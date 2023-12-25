<script setup>
import SinglePicker from "@/Shared/Form/FilePicker/Single.vue";
defineProps({
    form: Object,
    tab: Object,
    entity: Object,
});
</script>

<template>
    <div>
        <SinglePicker
            asterisk
            :entityFile="entity.thumbnail"
            v-model="form.files.thumbnail"
            :error="form.errors['files.thumbnail']"
            mime="image"
            :label="$t('admin.meals.attributes.files.thumbnail')"
        />
    </div>
</template>
