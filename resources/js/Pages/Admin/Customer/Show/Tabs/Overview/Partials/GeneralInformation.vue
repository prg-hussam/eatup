<script setup>
defineProps({
    shared: Object,
    userInfo: Object,
});
</script>
<template>
    <h6 class="mb-3 fw-semibold text-uppercase">
        {{ trans("modules.customers.show.general_information") }}
    </h6>
    <div class="row">
        <div class="col-lg-3 col-sm-6 mt-3">
            <div>
                <p class="mb-2 text-uppercase fw-medium">
                    {{ trans("modules.customers.show.name") }} :
                </p>
                <h5 class="fs-15 mb-0">{{ userInfo.name }}</h5>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 mt-3">
            <div>
                <p class="mb-2 text-uppercase fw-medium">
                    {{ trans("modules.customers.show.phone_number") }} :
                </p>
                <h5 class="fs-15 mb-0">{{ userInfo.phone }}</h5>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mt-3">
            <div>
                <p class="mb-2 text-uppercase fw-medium">
                    {{ trans("modules.customers.show.activated") }} :
                </p>
                <h5
                    class="fs-15 mb-0"
                    :class="[
                        userInfo.is_active ? 'text-success' : 'text-danger',
                    ]"
                >
                    {{
                        trans(
                            `modules.customers.show.${
                                userInfo.is_active ? "yes" : "no"
                            }`
                        )
                    }}
                </h5>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mt-3">
            <div>
                <p class="mb-2 text-uppercase fw-medium">
                    {{ trans("modules.customers.show.create_date") }} :
                </p>
                <h5 class="fs-15 mb-0">{{ userInfo.create_date }}</h5>
            </div>
        </div>
    </div>
</template>
