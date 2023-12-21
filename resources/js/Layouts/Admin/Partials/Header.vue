<script setup>
import { Link, router } from "@inertiajs/vue3";
import Dropdown from "@/Shared/Admin/Dropdown.vue";
import DropdownItem from "@/Shared/Admin/DropdownItem.vue";
import DropdownDivider from "@/Shared/Admin/DropdownDivider.vue";
import { onMounted } from "vue";
import useHelpers from "@/Uses/helpers";
import useAuth from "@/Uses/auth";
import useGeneral from "@/Uses/general";

const { user } = useAuth();
const { supportedLocales, locale, currentLocaleName } = useGeneral();
const helpers = useHelpers();
onMounted(() => {
    document.addEventListener("scroll", function () {
        var pageTopbar = document.getElementById("page-topbar");
        if (pageTopbar) {
            document.body.scrollTop >= 50 ||
            document.documentElement.scrollTop >= 50
                ? pageTopbar.classList.add("topbar-shadow")
                : pageTopbar.classList.remove("topbar-shadow");
        }
    });
    if (document.getElementById("topnav-hamburger-icon"))
        document
            .getElementById("topnav-hamburger-icon")
            .addEventListener("click", toggleHamburgerMenu);

    if (document.documentElement.getAttribute("data-sidebar-size") == "sm") {
        document.querySelector(".hamburger-icon").classList.toggle("open");
    }
});

const setLanguage = (language) => {
    location.href = language.localized_url;
};

const logout = () => {
    router.post(route("logout"));
};

const lockScreen = () => {
    router.put(route("admin.users.lock_screen.lock"));
};

const toggleDarkMode = () => {
    let mode =
        document.documentElement.getAttribute("data-layout-mode") == "dark"
            ? "light"
            : "dark";

    document.documentElement.setAttribute("data-layout-mode", mode);

    helpers.storeUiOptions("layout_mode", mode);
};

const storeSidebarSize = () => {
    helpers.storeUiOptions(
        "sidebar_size",
        document.documentElement.getAttribute("data-sidebar-size") == "lg"
            ? "sm"
            : "lg"
    );
};

const initFullScreen = () => {
    document.body.classList.toggle("fullscreen-enable");
    if (
        !document.fullscreenElement &&
        /* alternative standard method */
        !document.mozFullScreenElement &&
        !document.webkitFullscreenElement
    ) {
        // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(
                Element.ALLOW_KEYBOARD_INPUT
            );
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
};

const toggleHamburgerMenu = () => {
    var windowSize = document.documentElement.clientWidth;

    if (windowSize > 767) {
        document.querySelector(".hamburger-icon").classList.toggle("open");
    }
    //For collapse vertical menu
    if (windowSize < 1025 && windowSize > 767) {
        document.body.classList.remove("vertical-sidebar-enable");
        document.documentElement.getAttribute("data-sidebar-size") == "sm"
            ? document.documentElement.setAttribute("data-sidebar-size", "")
            : document.documentElement.setAttribute("data-sidebar-size", "sm");
    } else if (windowSize > 1025) {
        document.body.classList.remove("vertical-sidebar-enable");
        document.documentElement.getAttribute("data-sidebar-size") == "lg"
            ? document.documentElement.setAttribute("data-sidebar-size", "sm")
            : document.documentElement.setAttribute("data-sidebar-size", "lg");
    } else if (windowSize <= 767) {
        document.body.classList.add("vertical-sidebar-enable");
        document.documentElement.setAttribute("data-sidebar-size", "lg");
    }
};
</script>
<template>
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <button
                        type="button"
                        @click="storeSidebarSize"
                        class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                        id="topnav-hamburger-icon"
                    >
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>

                <div class="d-flex align-items-center">
                    <div
                        v-if="Object.keys(supportedLocales).length > 1"
                        class="dropdown ms-1 topbar-head-dropdown header-item"
                    >
                        <button
                            type="button"
                            class="btn btn-ghost-secondary shadow-none"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            {{ currentLocaleName }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="d-flex flex-column">
                                <Link
                                    v-for="(
                                        language, languageLocale
                                    ) in supportedLocales"
                                    @click="setLanguage(language)"
                                    :href="language.localized_url"
                                    :class="
                                        locale == languageLocale
                                            ? 'active order-1'
                                            : 'order-2'
                                    "
                                    :key="languageLocale"
                                    class="dropdown-item notify-item language py-2"
                                    title=""
                                >
                                    <span class="align-middle">
                                        {{ language.name }}</span
                                    >
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button
                            type="button"
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                            data-toggle="fullscreen"
                            @click="initFullScreen"
                        >
                            <i class="bx bx-fullscreen fs-22"></i>
                        </button>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button
                            type="button"
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none"
                            @click="toggleDarkMode"
                        >
                            <i class="bx bx-moon fs-22"></i>
                        </button>
                    </div>

                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button
                            type="button"
                            class="btn shadow-none"
                            id="page-header-user-dropdown"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <span class="d-flex align-items-center">
                                <img
                                    class="rounded-circle header-profile-user"
                                    :src="user.profile_photo_url"
                                />
                                <span class="text-start ms-xl-2">
                                    <span
                                        class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"
                                        >{{ user.name }}</span
                                    >
                                    <span
                                        class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"
                                    >
                                        @{{ user.username }}
                                    </span>
                                </span>
                            </span>
                        </button>
                        <Dropdown
                            :header="
                                $t('admin.dashboard.welcome', {
                                    user: user.name,
                                })
                            "
                        >
                            <DropdownItem
                                as="a"
                                :href="route('admin.my_account.index')"
                                icon="mdi mdi-account-circle"
                                :title="$t('admin.sidebar.my_account')"
                                :class="
                                    route().current('admin.my_account.index')
                                        ? 'active'
                                        : ''
                                "
                            />
                            <DropdownDivider />
                            <form @submit.prevent="lockScreen" method="POST">
                                <DropdownItem
                                    as="button"
                                    icon="mdi mdi-lock"
                                    :title="$t('admin.sidebar.lock_screen')"
                                />
                            </form>
                            <form @submit.prevent="logout" method="POST">
                                <DropdownItem
                                    as="button"
                                    icon="mdi mdi-logout"
                                    :title="$t('admin.sidebar.sign_out')"
                                />
                            </form>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
