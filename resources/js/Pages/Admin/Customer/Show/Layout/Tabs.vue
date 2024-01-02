<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    shared: Object,
});
</script>

<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-n4 mx-n4">
                <div class="bg-soft-warning">
                    <div class="card-body pb-0 px-4">
                        <div class="row mb-3">
                            <div class="col-md">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-auto">
                                        <div class="avatar-md">
                                            <div
                                                class="avatar-title bg-white border border-2 rounded-circle"
                                                :class="[
                                                    shared.is_active
                                                        ? 'border-success'
                                                        : 'border-danger',
                                                ]"
                                            >
                                                <img
                                                    :src="
                                                        shared.profile_photo_url
                                                    "
                                                    alt=""
                                                    class="avatar-xs"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div>
                                            <h4 class="fw-bold">
                                                {{ shared.name }}
                                                <span v-if="shared.is_personal">
                                                    - {{ shared.nick_name }}
                                                </span>
                                            </h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div>
                                                    {{
                                                        trans(
                                                            "modules.customers.show.create_date"
                                                        )
                                                    }}
                                                    :
                                                    <span class="fw-medium">
                                                        {{ shared.create_date }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul
                            class="nav nav-tabs-custom border-bottom-0"
                            role="tablist"
                        >
                            <li class="nav-item" role="presentation">
                                <Link
                                    :href="
                                        route('platform.customers.show', {
                                            id: shared.id,
                                            tab: 'overview',
                                        })
                                    "
                                    class="nav-link fw-semibold"
                                    :class="{
                                        active: shared.tab == 'overview',
                                    }"
                                    role="tab"
                                >
                                    {{
                                        trans(
                                            "modules.customers.show.tabs.overview"
                                        )
                                    }}
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
