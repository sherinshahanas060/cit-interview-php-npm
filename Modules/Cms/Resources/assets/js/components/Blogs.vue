<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card av-datatable">
                    <div class="card-header pt-4 pb-4 row m-0">
                        <h3 class="card-title col-md-4 col-12 p-0 mb-0">
                            Blogs
                            <span class="data-table-counts">{{
                                pagination.total
                            }}</span>
                            <p class="mb-0">View, Add and Edit Blogs</p>
                        </h3>
                        <div
                            class="card-tools p-0 text-right-md col-12 col-md-8"
                        >
                            <div class="search">
                                <label title="Set the number of rows per page">
                                    <select
                                        v-model="tableData.length"
                                        @input="searchText()"
                                        name="example1_length"
                                        aria-controls="example1"
                                        class="custom-select custom-select-sm form-control form-control-sm"
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
                                        @input="loadBlogs()"
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
                                <router-link
                                v-if="permissions.includes('user-create')"
                                    :to="{
                                        name: 'addOrEditBlog',
                                        params: { id: 0 }
                                    }"
                                    class="btn add-btn-theme"
                                >
                                    <i class="fa fa-plus"></i>
                                    Add New
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="table-filter"></div>
                    <div
                        class="card-body view-type p-0 m-0"
                        v-bind:class="{ boxTable: isTableBoxView }"
                    >
                        <DataTable
                            :columns="columns"
                            :sortKey="sortKey"
                            :columnSearchProp="false"
                            :sortOrders="sortOrders"
                            @sort="sortBy"
                        >
                            <tbody>
                                <tr v-for="blog in blogs" :key="blog.id">
                                    <td class="text-center">
                                        <div
                                            class="custom-control custom-checkbox"
                                        >
                                            <input
                                                type="checkbox"
                                                class="custom-control-input"
                                                :id="'blog-' + blog.id"
                                                name="selectblog[]"
                                                :value="blog.id"
                                            />
                                            <label
                                                class="custom-control-label"
                                                :for="'blog-' + blog.id"
                                            ></label>
                                        </div>
                                    </td>
                                    <td class="highlight-link">
                                        <router-link
                                        :style="
                                                !permissions.includes(
                                                    'blog-view'
                                                )
                                                    ? 'pointer-events:none'
                                                    : ''
                                            "
                                            :to="{
                                                name: 'viewBlog',
                                                params: { id: blog.id }
                                            }"
                                            class="highlight"
                                            ><div class="valign">
                                                {{ blog.title }}
                                            </div></router-link
                                        >
                                    </td>
                                    <td>{{ blog.created_at | myDate }}</td>
                                    <td class="action">
                                        <span class="mr-2">
                                            <router-link
                                            v-if="
                                                permissions.includes(
                                                    'blog-edit'
                                                )
                                            "
                                                :to="{
                                                    name: 'addOrEditBlog',
                                                    params: { id: blog.id }
                                                }"
                                                title="Edit"
                                            >
                                                <i class="fa fa-edit blue"></i>
                                            </router-link>
                                        </span>
                                        <span>
                                            <span
                                            v-if="
                                                permissions.includes(
                                                    'blog-delete'
                                                )
                                            "
                                                href="#"
                                                @click="deleteBlog(blog.id)"
                                                title="Delete"
                                            >
                                                <i class="fa fa-trash red"></i>
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </DataTable>
                        <Pagination
                            :pagination="pagination"
                            @paginate="loadFilterUsers()"
                            :offset="4"
                        ></Pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    components: {
    },
    data() {
        let sortOrders = {};
        let columns = [
            { width: "2%", label: "", name: "Select" },
            { width: "", label: "Title", name: "title" },
            { width: "", label: "Created At", name: "created_at" },
            { width: "8%", label: "Action", name: "", sort: 0 }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            isTableBoxView: false,
            columns: columns,
            sortKey: "id",
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
            blogs: []
        };
    },
    methods: {
        loadBlogs(
            url = window.routes.blogIndex +
                "?page=" +
                this.pagination.currentPage
        ) {
            this.$addParamsToLocation();
            this.tableData.draw++;
            axios
                .get(url, { params: this.tableData })
                .then(response => {
                    let data = response.data;
                    if (this.tableData.draw == data.draw) {
                        this.blogs = data.data.data;

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
         * Requirement: Delete blog
         */
        deleteBlog(id) {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                // Send request to the server
                if (result.value) {
                    let route = window.routes.blogDestroy;
                    axios
                        .delete(route + id)
                        .then(response => {
                            if (response.data.status == 101) {
                                toast.fire({
                                    type: "success",
                                    title: "Blog deleted successfully"
                                });
                                this.loadBlogs();
                            } else {
                                swal.fire(
                                    "Failed!",
                                    "There was something wrong.",
                                    "warning"
                                );
                            }
                        })
                        .catch(() => {
                            swal.fire(
                                "Failed!",
                                "There was something wrong.",
                                "warning"
                            );
                        });
                }
            });
        },
        /*
         * Author: Iqbal
         * Date: 
         * Requirement: Datatable method
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
            this.loadBlogs();
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value);
        },
        searchText() {
            this.pagination.currentPage = 1;
            this.loadBlogs();
        }
    },
    created() {
        this.$locationsToTableData();
        // load blogs when page load
        this.loadBlogs();
    }
};
</script>
