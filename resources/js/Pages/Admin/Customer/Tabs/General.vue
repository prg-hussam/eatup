<script setup>
import Input from "@/Shared/Form/Input.vue";
import Checkbox from "@/Shared/Form/Checkbox.vue";
import MultiSelect from "@/Shared/Form/MultiSelect.vue";
defineProps({
    form: Object,
    tab: Object,
    user: Object,
    formLocale: String,
});
</script>

<template>
    <div>
        <Input
            asterisk
            v-model="form.username"
            :error="form.errors.username"
            :label="$t('admin.users.attributes.username')"
            name="username"
        />
        <Input
            asterisk
            v-model="form.name"
            :error="form.errors.name"
            :label="$t('admin.users.attributes.name')"
            name="name"
        />
        <Input
            asterisk
            type="email"
            v-model="form.email"
            :error="form.errors.email"
            :label="$t('admin.users.attributes.email')"
            name="email"
        />

        <template v-if="route().current('admin.users.create')">
            <Input
                asterisk
                type="password"
                v-model="form.password"
                :error="form.errors.password"
                :label="$t('admin.users.attributes.password')"
                name="password"
            />
            <Input
                asterisk
                type="password"
                v-model="form.password_confirmation"
                :error="form.errors.password"
                :label="$t('admin.users.attributes.password_confirmation')"
                name="password_confirmation"
            />
        </template>

        <MultiSelect
            :label="$t('admin.users.attributes.roles')"
            :error="form.errors.roles"
            v-model="form.roles"
            :options="tab.data.roles"
            name="roles"
            asterisk
            multiple
        />

        <Checkbox
            class="mt-3"
            v-model:checked="form.is_active"
            id="is_active"
            :label="$t('admin.users.attributes.is_active')"
        />
    </div>
</template>
