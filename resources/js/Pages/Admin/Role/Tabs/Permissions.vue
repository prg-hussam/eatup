<script setup>
const props = defineProps({
    form: Object,
    tab: Object,
});

const allowAll = (permissions) => {
    if (permissions == "global") {
        Object.keys(props.tab.data.permissions).forEach((groupKey) => {
            props.tab.data.permissions[groupKey]["permissions"].forEach(
                (permission) => props.form.permissions.push(permission.key)
            );
        });
    } else if (typeof permissions == "object") {
        permissions.forEach((permission) => {
            props.form.permissions.push(permission.key);
        });
    }
};

const denyAll = (permissions) => {
    if (permissions == "global") {
        props.form.permissions = [];
    } else if (typeof permissions == "object") {
        permissions.forEach((permission) => {
            props.form.permissions = props.form.permissions.filter(
                (key) => key != permission.key
            );
        });
    }
};

const allowOrDeny = (permissionKey) => {
    if (props.form.permissions.includes(permissionKey)) {
        props.form.permissions = props.form.permissions.filter(
            (key) => key != permissionKey
        );
    } else {
        props.form.permissions.push(permissionKey);
    }
};
</script>

<template>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <h5>{{ $t("admin.roles.control_all_services") }}</h5>
                        <div>
                            <span
                                role="button"
                                @click="allowAll('global')"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                :title="$t('admin.roles.allow_all')"
                                class="align-middle text-dark global-permission-toggle"
                                href="javascript:void(0);"
                            >
                                <i class="bx bx-check-circle"></i>
                            </span>
                            <span
                                role="button"
                                @click="denyAll('global')"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                :title="$t('admin.roles.deny_all')"
                                class="align-middle text-dark global-permission-toggle"
                                href="javascript:void(0);"
                            >
                                <i class="bx bx-x-circle"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div
                    class="col-lg-4"
                    v-for="(group, index) in tab.data.permissions"
                    :key="index"
                >
                    <div class="card">
                        <div class="card-header bg-primary">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-0 text-white">
                                        {{ $t(group.title) }}
                                    </h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul
                                        class="list-inline card-toolbar-menu d-flex align-items-center mb-0"
                                    >
                                        <li class="list-inline-item">
                                            <span
                                                role="button"
                                                @click="
                                                    allowAll(group.permissions)
                                                "
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                :title="
                                                    $t('admin.roles.allow_all')
                                                "
                                                class="align-middle text-white fs-18"
                                            >
                                                <i
                                                    class="bx bx-check-circle"
                                                ></i>
                                            </span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span
                                                role="button"
                                                @click="
                                                    denyAll(group.permissions)
                                                "
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                :title="
                                                    $t('admin.roles.deny_all')
                                                "
                                                class="align-middle text-white fs-18"
                                            >
                                                <i class="bx bx-x-circle"></i>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div
                                class="row permission-row"
                                v-for="permission in group.permissions"
                                :key="permission.key"
                            >
                                <div class="col-md-8">
                                    <span class="permission-label">
                                        {{
                                            $t(permission.name, {
                                                resource: $t(group.title),
                                            })
                                        }}
                                    </span>
                                </div>
                                <div class="col-md-4 col-8 p-0">
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                @click="
                                                    allowOrDeny(permission.key)
                                                "
                                                :checked="
                                                    form.permissions.includes(
                                                        permission.key
                                                    )
                                                        ? true
                                                        : false
                                                "
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.card {
    border: 1px solid rgb(75 57 179 / 12%);
    box-shadow: none;
}
.card-body {
    min-height: 175px;
}

.permission-row {
    padding: 6px 0 8px;
}
.permission-row .permission-label {
    display: block;
    font-weight: 600;
    padding-top: 0;
}
.global-permission-toggle {
    font-size: 1.5rem;
    margin-left: 10px;
}
</style>
