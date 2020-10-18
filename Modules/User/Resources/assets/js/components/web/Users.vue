<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card av-datatable">
                    <div class="card-header pt-4 pb-4 row m-0">
                        <h3 class="card-title col-md-3 col-12 p-0 mb-0">
                            Users
                            <span class="data-table-counts">{{
                                pagination.total
                            }}</span>
                            <p class="mb-0">View, Add and Edit Users</p>
                        </h3>
                        <div
                            class="card-tools p-0 text-right-md col-12 col-md-9"
                        >
                            <div class="search">
                                <label title="Set the number of rows per page">
                                    <select
                                        v-model="tableData.length"
                                        @change="loadUsers()"
                                        name="example1_length"
                                        aria-controls="example1"
                                        class="custom-select custom-select-sm form-control form-control-sm"
                                        title="Count"
                                    >
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </label>
                                <label title="live search">
                                    <input
                                        v-model="tableData.search"
                                        placeholder="Search Table"
                                        @input="searchText()"
                                        type="search"
                                        class="form-control form-control-sm"
                                        aria-controls="example1"
                                    />
                                </label>
                                <label>
                                    <div class="filter">
                                        <span>
                                            Filter
                                            <i class="fas fa-filter"></i>
                                        </span>
                                    </div>
                                </label>
                                <label>
                                    <div class="viewType">
                                        <span
                                            @click="
                                                isTableBoxView = isTableBoxView
                                                    ? false
                                                    : true
                                            "
                                        >
                                            <i class="fas fa-th"></i>
                                        </span>
                                    </div>
                                </label>
                                <label>
                                    <div class="viewType" title="more">
                                        <span>
                                            <i class="fas fa-ellipsis-v"></i>
                                        </span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div
                        class="card-body view-type p-0 m-0"
                        v-bind:class="{ boxTable: isTableBoxView }"
                    >
                        <DataTable
                            :columns="columns"
                            :sortKey="sortKey"
                            :sortOrders="sortOrders"
                            @sort="sortBy"
                        >
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>
                                        
                                    </td>
                                    <td class="highlight-link">
                                        {{ user.firstName }}
                                    </td>
                                    <td>
                                        {{ user.lastName }}
                                    </td>
                                    <td>
                                        {{ user.email }}
                                    </td>
                                    <td>{{ user.userName }}</td>
                                    <td>{{ user.mobile }}</td>
                                    
                                </tr>
                            </tbody>
                        </DataTable>
                        <Pagination
                            :pagination="pagination"
                            @paginate="loadUsers()"
                            :offset="4"
                        ></Pagination>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="invite-user-modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Invite User
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            title="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="invite()">
                        <div class="modal-body">
                            <div>
                                <label class="typo__label"
                                    >Select Employee</label
                                >
                                <multiselect
                                    v-model="form.inviteEmp"
                                    :options="employeeOptions"
                                    :custom-label="nameWithEmail"
                                    placeholder="Select one"
                                    label="name"
                                    track-by="name"
                                ></multiselect>
                                <pre
                                    class="language-json"
                                ><code>{{ form.inviteEmp  }}</code></pre>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- / Modal -->
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    components: {
    },
    data() {
        let sortOrders = {};
        let columns = [
            { width: "5%", label: "", name: "id", sort: 0 },
            { width: "12%", label: "First Name", name: "firstName" },
            { width: "12%", label: "Last Name", name: "lastName", sort: 0 },
            { width: "12%", label: "Email", name: "email" },
            { width: "12%", label: "User Name", name: "userName" },
            { width: "12%", label: "Mobile", name: "mobile" },
        ];

        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            isTableBoxView: false,
            users: [],
            columns: columns,
            sortKey: "name",
            sortOrders: sortOrders,
            tableData: {
                draw: 0,
                length: 10,
                search: "",
                column: 0,
                dir: "desc"
            },
            pagination: {
                lastPage: "",
                currentPage: "",
                total: "",
                lastPageUrl: "",
                nextPageUrl: "",
                prevPageUrl: "",
                from: "",
                to: ""
            },
            form: new Form({
                inviteEmp: [
                    {
                        name: "",
                        email: ""
                    }
                ]
            }),
            employeeOptions: []
        };
    },
    methods: {
        nameWithEmail({ name, email }) {
            if (name) {
                return `${name} — [${email}]`;
            }
        },
        /*
         * Author: Iqbal
         * Date: 
         * Requirement: Invite user submit
         */
        invite() {},
        /*
         * Author: Iqbal
         * Date: 
         * Requirement: Invite user popup
         */
        inviteUser() {
            $("#invite-user-modal").modal("show");
            let route = window.routes.employeeList;
            axios
                .get(route)
                .then(response => {
                    this.employeeOptions = response.data.data;
                })
                .catch(errors => {
                    console.log(errors);
                });
        },
        /*
         * Author: Iqbal
         * Date: 
         * Requirement: edit user
         */
        editUser() {},
        /*
         * Author: Iqbal
         * Date: 
         * Requirement: delete user
         */
        
        /*
         * Author: Iqbal
         * Date: 
         * Requirement: load user
         */
        loadUsers(
            url = window.routes.webUserIndex +
                "?page=" +
                this.pagination.currentPage
        ) {
            this.$addParamsToLocation();
            this.tableData.draw++;
            // const url = `${API_URL}/api/phonebookapi/`;
            axios
                .get(url, { params: this.tableData })
                .then(response => {
                    let data = response.data;
                    if (this.tableData.draw == data.draw) {
                        this.users = data.data.data;
                        this.configpagination(data.data);
                    }
                })
                .catch(errors => {
                    console.log(errors);
                });
        },

        /*
         * Author: Iqbal
         * Date: 
         * Requirement: Data table methods
         */
        configpagination(data) {
            this.pagination.lastPage = data.last_page;
            this.pagination.currentPage = data.current_page;
            this.pagination.total = data.total;
            this.pagination.lastPageUrl = data.last_page_url;
            this.pagination.nextPageUrl = data.next_page_url;
            this.pagination.prevPageUrl = data.prev_page_url;
            this.pagination.from = data.from;
            this.pagination.to = data.to;
        },
        sortBy(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            this.tableData.column = this.getIndex(this.columns, "name", key);
            this.tableData.dir = this.sortOrders[key] === 1 ? "asc" : "desc";
            this.loadUsers();
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value);
        },
        searchText() {
            this.pagination.currentPage = 1;
            this.loadUsers();
        }
    },
    created() {
        this.$locationsToTableData();
        this.loadUsers();
        fire.$on("afterAction", () => {
            this.loadUsers();
        });
    },
    mounted() {},
    computed: {}
};
</script>
