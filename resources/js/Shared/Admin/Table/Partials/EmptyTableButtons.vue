<script >
import useAuth from "@/Uses/auth";
import useTableActions from "@/Uses/table_actions";
export default {
  props: {
    buttons: Array,
    resource: String,
    name: String,
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
  <span v-for="(button, index) in buttons" :key="index">
    <button
      @click="onClick(button, resource)"
      v-if="visible(button.visible) && can(getPermissionName(button, resource))"
      class="btn btn-label"
      :class="'btn-' + getColorClass(button)"
    >
      <i
        class="label-icon align-middle fs-16 me-2"
        :class="getIcon(button)"
      ></i>
      {{ getLabel(button, name) }}
    </button>
  </span>
</template>