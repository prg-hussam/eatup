<script>
import useAuth from "@/Uses/auth";
import useTableActions from "@/Uses/table_actions";

export default {
    props: {
        actions: Array,
        resource: String,
        name: String,
        selected: Array,
    },
    setup() {
        const { can } = useAuth();
        const {
            onClick,
            getPermissionName,
            visible,
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
            visible,
            getLabel,
        };
    },
};
</script>

<template>
    <span class="me-2" v-for="action in actions" :key="action.key">
        <transition name="fade">
            <button
                @click="onClick(action, resource, name, { ids: selected })"
                v-if="
                    visible(action.visible) &&
                    can(getPermissionName(action, resource)) &&
                    (action.alwaysShow || selected.length > 0)
                "
                class="btn btn-label"
                :class="'btn-' + getColorClass(action)"
            >
                <i
                    class="label-icon align-middle fs-16 me-2"
                    :class="getIcon(action)"
                ></i>
                {{ getLabel(action, name) }}
            </button>
        </transition>
    </span>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
