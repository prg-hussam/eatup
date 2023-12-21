import { trans } from "laravel-vue-i18n";
import useActionOptions from "./action_options";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import { inject } from "vue";

export default function useTableActions(prefix = "admin") {
    const actionOptions = useActionOptions();
    const swal = inject("$swal");

    function getPermissionName(action, resource) {
        if (typeof action == "object") {
            return action.permission || `${prefix}.${resource}.${action.key}`;
        } else {
            return `${prefix}.${resource}.${action}`;
        }
    }

    function getRoute(action, resource) {
        if (typeof action == "object") {
            return action.route || `${prefix}.${resource}.${action.key}`;
        } else {
            return `${prefix}.${resource}.${action}`;
        }
    }

    function getIcon(action) {
        if (typeof action == "object") {
            return action.icon || actionOptions[action.key].icon;
        } else {
            return actionOptions[action].icon;
        }
    }

    function getColorClass(action) {
        if (typeof action == "object") {
            return action.colorClass || actionOptions[action.key].colorClass;
        } else {
            return actionOptions[action].colorClass;
        }
    }

    function getLabel(action, name) {
        let key = null;
        if (typeof action == "object") {
            if (action.label) {
                return action.label;
            }
            key = action.key;
        } else {
            key = action;
        }

        return trans(`resource.${key}`, { resource: trans(name) });
    }

    function onClick(action, resource, name, params = {}, record) {
        if (typeof action == "object") {
            if (action.visitModal) {
                router.visitInModal(route(getRoute(action, resource), params));
                return;
            } else if (action.onClick) {
                return action.onClick(record);
            } else if (action.key == "destroy") {
                destroy(action, resource, name, params.ids || params.id);
                return;
            }
        }
        router.get(route(getRoute(action, resource), params));
    }

    function destroy(action, resource, name, ids) {
        swal.fire({
            title: trans("global.delete_modal.confirmation"),
            text: trans("global.delete_modal.confirmation_message"),
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: trans("global.delete_modal.confirmation_button"),
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(route(getRoute(action, resource), { ids }), {
                    preserveState: false,
                    replace: true,
                    onSuccess: () => {
                        useToast().success(
                            trans("messages.resource_deleted", {
                                resource: trans(name),
                            })
                        );
                    },
                });
            }
        });
    }

    function visible(callBack, record) {
        if (typeof callBack == "function") {
            return callBack(record);
        } else if (typeof callBack == "boolean") {
            return callBack;
        }
        return true;
    }

    return {
        getPermissionName,
        getRoute,
        getIcon,
        getColorClass,
        getLabel,
        onClick,
        destroy,
        visible,
    };
}
