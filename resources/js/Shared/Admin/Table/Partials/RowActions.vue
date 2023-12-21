<script >
import useAuth from "@/Uses/auth";
import useTableActions from "@/Uses/table_actions";
export default {
  props: {
    actions: {
      type: Array,
      default: [],
    },
    resource: String,
    name: String,
    recordId: String,
    record: Object,
  },
  setup() {
    const { can } = useAuth();
    const {
      onClick,
      getPermissionName,
      getColorClass,
      getIcon,
      getLabel,
      visible,
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
  <div class="btn-group">
    <button
      type="button"
      class="btn btn-primary dropdown-toggle"
      data-bs-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      {{ $t("global.buttons.actions") }}
    </button>
    <div class="dropdown-menu">
      <span v-for="action in actions" :key="action.key">
        <template v-if="visible(action.visible, record)">
          <div v-if="action.hasPreviousDivider" class="dropdown-divider"></div>
          <button
            class="dropdown-item"
            :class="action.colored ? `text-${getColorClass(action)}` : ''"
            @click="onClick(action, resource, name, { id: recordId }, record)"
            v-if="can(getPermissionName(action, resource))"
          >
            <i class="me-1" :class="getIcon(action)"></i>
            {{ getLabel(action) }}
          </button>
        </template>
      </span>
    </div>
  </div>
</template>
