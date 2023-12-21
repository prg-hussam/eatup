export default function useHelpers() {
    function storeUiOptions(key, value) {
        axios.put(route("admin.my_account.ui_options"), {
            key,
            value,
        });
    }

    return { storeUiOptions };
}
