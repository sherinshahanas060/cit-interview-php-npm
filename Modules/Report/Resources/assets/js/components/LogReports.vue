<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card av-datatable">
          <div class="card-header pt-4 pb-4 row m-0">
            <h3 class="card-title col-md-4 col-12 p-0 mb-0">
              Log Report
              <span class="data-table-counts">{{ pagination.total }}</span>
            </h3>
            <div class="card-tools p-0 text-right-md col-12 col-md-8">
              <div class="search">
                <label title="Set the number of rows per page">
                  <select
                    v-model="tableData.length"
                    @change="loadLogReports()"
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
                    @input="loadLogReports()"
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
                      @click="isTableBoxView = isTableBoxView ? false : true"
                    >
                      <i class="fas fa-th"></i>
                    </span>
                  </div>
                </label>
                <label>
                  <div @click="moreFilter" class="viewType" title="more">
                    <span>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                  </div>
                </label>
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
                <tr v-for="(reports, index) in logreports" :key="index">
                  <!-- <th>{{ reports.user }}</th> -->
                  <td>{{ reports.login_ip }}</td>
                  <td>{{ reports.name }}</td>
                  <td>{{ reports.address }}</td>
                  <td>
                    {{
                      reports.lat
                        ? reports.lat
                        : "" + "," + reports.lon
                        ? reports.lon
                        : ""
                    }}
                  </td>
                  <td>{{ reports.time_zone }}</td>
                  <td>{{ reports.created_at | myDateTime }}</td>
                  <td v-if="reports.logout_time != '0000-00-00 00:00:00'">
                    {{ reports.logout_time | myDateTime }}
                  </td>
                  <td v-else></td>
                  <td>{{ reports.device_information }}</td>
                  <td>{{ reports.attempt_count }}</td>
                  <td>{{ reports.failure_reason }}</td>
                </tr>
              </tbody>
            </DataTable>
            <Pagination
              :pagination="pagination"
              @paginate="loadLogReports()"
              :offset="4"
            ></Pagination>
          </div>
          <!-- /.card-body -->
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
      // { width: "9%", label: "User", name: "user"},
      { width: "9%", label: "IP", name: "login_ip" },
      { width: "9%", label: "User Name", name: "name" },
      { width: "9%", label: "Address", name: "address" },
      { width: "9%", label: "Latitude & Longitude", name: "lat" },
      { width: "8%", label: "Time Zone", name: "time_zone" },
      { width: "8%", label: "Login Time", name: "created_at" },
      { width: "8%", label: "Logout Time", name: "logout_time" },
      { width: "8%", label: "Device Info", name: "device_information" },
      { width: "8%", label: "Attempt Count", name: "attempt_count" },
      { width: "8%", label: "Reason", name: "failure_reason" }
    ];
    columns.forEach(column => {
      sortOrders[column.name] = -1;
    });
    return {
      isTableBoxView: false,
      columns: columns,
      sortKey: "created_at",
      sortOrders: sortOrders,
      tableData: {
        draw: 0,
        length: 10,
        search: "",
        column: 5,
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
      logreports: []
    };
  },
  methods: {
    moreFilter() {},
    /*
     * Author: 
     * Date: 
     * Requirement: load logreports
     */
    loadLogReports(
      url = window.routes.logreportIndex +
        "?page=" +
        this.pagination.currentPage
    ) {
      this.tableData.draw++;
      axios
        .get(url, { params: this.tableData })
        .then(response => {
          console.log(response.data);
          let data = response.data;
          if (this.tableData.draw == data.draw) {
            this.logreports = data.data.data;
            this.configpagination(data.data);
          }
        })
        .catch(errors => {
          console.log(errors);
        });
    },
    /*
     * Author: 
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
      this.loadLogReports();
    },
    getIndex(array, key, value) {
      return array.findIndex(i => i[key] == value);
    }
  },
  created() {
    // load logreports when page load
    this.loadLogReports();
  }
};
</script>
