import { usePage } from "@inertiajs/vue3";

export default function useGeneral() {
    const page = usePage();
    const settings = page.props.settings;

    function setting(key, defaultValue = null) {
        return settings[key] || defaultValue;
    }

    return {
        supportedLocales: page.props.supported_locales,
        appName: page.props.app_name,
        settings,
        locale: page.props.locale,
        adminSidebar: page.props.admin_sidebar,
        authCover: page.props.dashboard_auth_cover,
        authLogo: page.props.dashboard_auth_logo,
        copyRightText: page.props.copyright_text,
        currentLocaleName: page.props.current_locale_name,
        setting,
    };
}
