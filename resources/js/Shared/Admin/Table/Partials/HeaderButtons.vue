<script>
import useAuth from "@/Uses/auth";
import useTableActions from "@/Uses/table_actions";
export default {
    props: {
        buttons: Array,
        resource: String,
        name: String,
        hasFilter: Boolean,
    },
    setup() {
        const { can } = useAuth();
        const {
            onClick,
            visible,
            getPermissionName,
            getColorClass,
            getIcon,
            getLabel,
        } = useTableActions();
        return {
            can,
            onClick,
            getPermissionName,
            getColorClass,
            getIcon,
            getLabel,
            visible,
        };
    },
};
</script>

<template>
    <button
        v-if="hasFilter"
        class="btn btn-info me-2 btn-label"
        data-bs-toggle="offcanvas"
        data-bs-target="#table-filter-offcanvas"
        aria-controls="table-filter-offcanvas"
    >
        <i
            class="label-icon align-middle fs-16 me-2 mdi mdi-filter-outline"
        ></i>
        {{ $t("global.buttons.filter") }}
    </button>
    <template v-for="(button, index) in buttons" :key="index">
        <button
            @click="onClick(button, resource)"
            v-if="
                visible(button.visible) &&
                can(getPermissionName(button, resource))
            "
            class="btn me-2 btn-label"
            :class="['btn-' + getColorClass(button), index > 1 ? 'me-2' : '']"
        >
            <i
                class="label-icon align-middle fs-16 me-2"
                :class="getIcon(button)"
            ></i>
            {{ getLabel(button, name) }}
        </button>
    </template>
</template>
