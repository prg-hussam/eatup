import { usePage } from "@inertiajs/vue3"

export default function useAuth() {
    const page = usePage();
    const user = page.props.auth.user;
    const check = page.props.auth.check;

    function can(permission) {
        if (
            check &&
            (
                permission == 'all' ||
                user.is_super_admin ||
                user.permissions.includes(permission)
            )
        ) {
            return true;
        }
        return false;
    }

    function canAny(permissions) {
        if (check) {
            if (user.is_super_admin) {
                return true;
            } else {
                let hasAccess = false;
                let userPermissions = user.permissions;
                for (let i = 0; i < permissions.length; i++) {
                    if (permissions[i] == 'all' || userPermissions.includes(permissions[i])) {
                        hasAccess = true;
                        break;
                    }
                }
                return hasAccess;
            }

        }
        return false;
    }

    function hasRole(role) {
        if (check && user.roles.includes(role)) {
            return true;
        }
        return false;
    }

    function hasAnyRoles(roles) {
        if (check) {
            let hasAccess = false;
            let userRoles = user.roles;
            for (let i = 0; i < roles.length; i++) {
                if (userRoles.includes(roles[i])) {
                    hasAccess = true;
                    break;
                }
            }
            return hasAccess;
        }
        return false;
    }

    return { user, check, can, canAny, hasRole, hasAnyRoles }
}