<template>
    <div v-dragscroll="false" class="table-responsive">
        <table class="table m-0 p-0 av-data-table table-striped">
            <thead>
                <tr>
                    <th
                        v-for="column in columns"
                        :key="column.name"
                        @click="
                            column.sort != 0 ? $emit('sort', column.name) : ''
                        "
                        :class="
                            column.sort != 0
                                ? sortKey === column.name
                                    ? sortOrders[column.name] > 0
                                        ? 'sorting_asc'
                                        : 'sorting_desc'
                                    : 'sorting'
                                : ''
                        "
                        :style="
                            'width:' + column.width + ';' + 'cursor:pointer;'
                        "
                    >
                        <div v-if="column.name == 'select_all'" class="d-flex">
                            <span class="mr-1 pt-1">All</span>
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    @change="$emit('checkAll', allSelect)"
                                    v-model="allSelect"
                                    class="custom-control-input"
                                    :id="'select-all'"
                                    name="select-all"
                                    :value="allSelect"
                                />
                                <label
                                    class="custom-control-label"
                                    :for="'select-all'"
                                ></label>
                            </div>
                        </div>
                        <span v-else>{{ column.label }}</span>
                    </th>
                </tr>
                <tr v-if="columnSearchProp">
                    <td v-for="(searchField, index) in columns" :key="index">
                        <input
                            v-if="searchField.search"
                            type="search"
                            v-model="searchField.val"
                            @input="searchColumn(index)"
                            class="form-control form-control-sm"
                            :name="index"
                            :id="index"
                            :placeholder="searchField.label"
                        />
                    </td>
                </tr>
            </thead>
            <slot></slot>
        </table>
    </div>
</template>

<script>
export default {
    props: ["columns", "sortKey", "sortOrders", "columnSearchProp"],
    data() {
        return {
            allSelect: false,
            columnSearch: {
                column: "",
                val: ""
            }
        };
    },
    methods: {
        searchColumn(index) {
            this.columnSearch.column = this.columns[index].name;
            this.columnSearch.val = this.columns[index].val;
            this.$emit("serchEachColumn", this.columnSearch);
        }
    }
};
</script>
