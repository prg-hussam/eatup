<script setup>
import Card from "@/Shared/Admin/Card.vue";
import Pagination from "./Partials/Pagination.vue";
import SearchBox from "./Partials/SearchBox.vue";
import HeaderButtons from "./Partials/HeaderButtons.vue";
import EmptyTableButtons from "./Partials/EmptyTableButtons.vue";
import RowActions from "./Partials/RowActions.vue";
import BulkActions from "./Partials/BulkActions.vue";
import { computed, ref, inject } from "@vue/runtime-core";
import { Link, router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import FilterOffcanvas from "./Partials/FilterOffcanvas.vue";

const toast = useToast();
const $swal = inject("$swal");

const props = defineProps({
    id: String,
    resource: String,
    name: String,
    buttons: Array,
    actions: {
        type: Array,
        default: [],
    },
    emptyTableButtons: {
        type: Array,
        default: [],
    },
    primary: {
        type: String,
        default: "id",
    },
    columns: Array,
    records: Object,
    bulkActions: {
        type: Array,
        default: [],
    },
    searchOptions: Object,
    filterForm: Object,
});

const hoveredRow = ref(false);
const isAllSelected = ref(false);
const selected = ref([]);
const searchLoading = ref(false);

const columnsLength = computed(() => {
    return (
        props.columns.length +
        (props.bulkActions.length > 0 ? 1 : 0) +
        (props.actions.length > 0 ? 1 : 0)
    );
});

const hasBulkActions = computed(() => {
    return props.bulkActions.length > 0;
});

const handlerCheckAllRows = () => {
    if (isAllSelected.value) {
        selected.value = props.records.data.map(
            (record) => record[props.primary]
        );
    } else {
        selected.value = [];
    }
};

const handlerCheckRow = (event, id) => {
    if (event.target.checked && !isSelected(id)) {
        selected.value.push(id);
    } else {
        selected.value = selected.value.filter((value) => value != id);
    }

    if (selected.value.length == 0) {
        isAllSelected.value = false;
    }
};

const hoverRow = (id) => {
    hoveredRow.value = id;
};

const unHoverRow = () => {
    hoveredRow.value = false;
};

const isSelected = (id) => {
    return selected.value.includes(id);
};

const search = ({ searchText }) => {
    searchLoading.value = true;
    router.get(
        props.searchOptions.url,
        { search: searchText.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => (searchLoading.value = false),
        }
    );
};
</script>

<template>
    <div class="row">
        <div class="col-12">
            <Card>
                <template #header>
                    <div class="row g-2">
                        <div v-if="search" class="col-sm-3">
                            <SearchBox
                                :loading="searchLoading"
                                :options="searchOptions"
                                @search="search"
                            />
                        </div>
                        <div class="col-sm-auto ms-auto">
                            <slot
                                v-if="$slots.headerButtons"
                                name="headerButtons"
                            />
                            <template v-else>
                                <BulkActions
                                    :name="name"
                                    :resource="resource"
                                    :actions="bulkActions"
                                    :selected="selected"
                                />
                                <HeaderButtons
                                    :name="name"
                                    :resource="resource"
                                    :buttons="buttons"
                                    :hasFilter="$slots.filter ? true : false"
                                />
                            </template>
                        </div>
                    </div>
                </template>
                <template #body>
                    <div
                        class="table-responsive table-card"
                        :style="
                            records.data.length !== 0 ? 'min-height: 40vh' : ''
                        "
                    >
                        <table
                            :id="id"
                            class="table table-hover align-middle table-nowrap mb-0"
                        >
                            <thead class="table-light">
                                <tr>
                                    <th
                                        v-if="hasBulkActions"
                                        scope="col"
                                        style="width: 46px"
                                    >
                                        <div class="form-check">
                                            <input
                                                :disabled="
                                                    records.data.length === 0
                                                "
                                                class="form-check-input"
                                                type="checkbox"
                                                @change="handlerCheckAllRows"
                                                v-model="isAllSelected"
                                            />
                                            <label
                                                class="form-check-label"
                                                for="select-all"
                                            ></label>
                                        </div>
                                    </th>
                                    <th
                                        v-for="column in columns"
                                        :key="'th-' + column.name"
                                    >
                                        {{ $t(column.label) }}
                                    </th>
                                    <th v-if="actions.length > 0">
                                        {{ $t("global.table.actions") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="records.data.length == 0">
                                    <td
                                        valign="top"
                                        :colspan="columnsLength"
                                        class="g-3 text-center border-0 p-5"
                                    >
                                        <div>
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="120"
                                                height="120"
                                                viewBox="0 0 65 51"
                                            >
                                                <path
                                                    fill="#A8B9C5"
                                                    d="M56 40h2c.552285 0 1 .447715 1 1s-.447715 1-1 1h-2v2c0 .552285-.447715 1-1 1s-1-.447715-1-1v-2h-2c-.552285 0-1-.447715-1-1s.447715-1 1-1h2v-2c0-.552285.447715-1 1-1s1 .447715 1 1v2zm-5.364125-8H38v8h7.049375c.350333-3.528515 2.534789-6.517471 5.5865-8zm-5.5865 10H6c-3.313708 0-6-2.686292-6-6V6c0-3.313708 2.686292-6 6-6h44c3.313708 0 6 2.686292 6 6v25.049375C61.053323 31.5511 65 35.814652 65 41c0 5.522847-4.477153 10-10 10-5.185348 0-9.4489-3.946677-9.950625-9zM20 30h16v-8H20v8zm0 2v8h16v-8H20zm34-2v-8H38v8h16zM2 30h16v-8H2v8zm0 2v4c0 2.209139 1.790861 4 4 4h12v-8H2zm18-12h16v-8H20v8zm34 0v-8H38v8h16zM2 20h16v-8H2v8zm52-10V6c0-2.209139-1.790861-4-4-4H6C3.790861 2 2 3.790861 2 6v4h52zm1 39c4.418278 0 8-3.581722 8-8s-3.581722-8-8-8-8 3.581722-8 8 3.581722 8 8 8z"
                                                ></path>
                                            </svg>
                                        </div>
                                        <p>
                                            {{
                                                $t(
                                                    route().params?.search
                                                        ? "messages.no_matching_records_found"
                                                        : "messages.no_data_available"
                                                )
                                            }}
                                        </p>

                                        <EmptyTableButtons
                                            :name="name"
                                            :resource="resource"
                                            :buttons="emptyTableButtons"
                                        />
                                    </td>
                                </tr>
                                <tr
                                    v-else
                                    v-for="record in records.data"
                                    :key="record[primary]"
                                    :class="
                                        isSelected(record[primary])
                                            ? 'bg-light'
                                            : ''
                                    "
                                    @mouseover="hoverRow(record[primary])"
                                    @mouseleave="unHoverRow()"
                                >
                                    <td v-if="hasBulkActions">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :checked="
                                                    isSelected(record[primary])
                                                "
                                                @change="
                                                    handlerCheckRow(
                                                        $event,
                                                        record[primary]
                                                    )
                                                "
                                            />
                                        </div>
                                    </td>
                                    <td
                                        v-for="(column, index) in columns"
                                        :key="
                                            `td-${record[primary]}-` +
                                            column.name
                                        "
                                    >
                                        <component
                                            v-if="column.component"
                                            :is="column.component"
                                            v-bind="column.props(record, index)"
                                        >
                                        </component>
                                        <span v-else>{{
                                            record[column.name]
                                        }}</span>
                                    </td>
                                    <td
                                        v-if="actions.length > 0"
                                        style="width: 10%"
                                    >
                                        <RowActions
                                            :recordId="
                                                record[primary].toString()
                                            "
                                            :record="record"
                                            :resource="resource"
                                            :actions="actions"
                                            :name="name"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <FilterOffcanvas
                        v-if="$slots.filter"
                        :resource="resource"
                        :form="filterForm"
                    >
                        <template #body>
                            <slot name="filter" />
                        </template>
                    </FilterOffcanvas>
                </template>
                <template #footer v-if="records.data.length !== 0">
                    <Pagination :meta="records.meta" :links="records.links" />
                </template>
            </Card>
        </div>
    </div>
</template>
