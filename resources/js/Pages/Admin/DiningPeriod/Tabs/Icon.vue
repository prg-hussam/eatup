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
            :entityFile="entity.icon"
            v-model="form.files.icon"
            :error="form.errors['files.icon']"
            mime="image"
            :label="$t('admin.dining_periods.attributes.files.icon')"
        />
    </div>
</template>
