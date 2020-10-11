<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Dashboard</div>

          <div class="card-body">
            <div class="col-md-12 p-0">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Device Usage</h3>

                  <div class="card-tools">
                    <button
                      type="button"
                      class="btn btn-tool"
                      data-card-widget="collapse"
                    >
                      <i class="fas fa-minus"></i>
                    </button>
                    <button
                      type="button"
                      class="btn btn-tool"
                      data-card-widget="remove"
                    >
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="chart-responsive">
                        <div class="chartjs-size-monitor">
                          <div class="chartjs-size-monitor-expand">
                            <div class></div>
                          </div>
                          <div class="chartjs-size-monitor-shrink">
                            <div class></div>
                          </div>
                        </div>
                        <!-- <canvas id="pieChart" height="147" width="296" class="chartjs-render-monitor" style="display: block; height: 118px; width: 237px;"></canvas> -->
                        <pie-chart
                          :width="300"
                          :height="200"
                          :chart-data="pieDataCollection"
                          class="chartjs-render-monitor"
                        ></pie-chart>
                      </div>
                      <!-- ./chart-responsive -->
                    </div>
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.card-body -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pieDataCollection: null
    };
  },
  methods: {
      fillPieChartData() {
      let route = VisitorsAPI + "device_count";
      axios
        .get(route, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("visitors_token")}`,
          },
        })
        .then(
          (response) => {           
              this.pieDataCollection = {
                type: "pie",
                labels: ["Mobile", "Desktop", "Tablet"],
                datasets: [
                  {
                    label: "Data One",
                    backgroundColor: ["#41B883", "#E46651", "#00D8FF"],
                    data: [response.data.Mobile, response.data.Desktop, response.data.Tablet],
                  },
                ],
              };
          },
          (error) => {
            if (error.response.status == 401) {
              this.visitorsApiLogin();
            }
          }
        )
        .catch((errors) => console.log(errors));
    },
    visitorsApiLogin() {
      console
      let route = VisitorsAPI + "login";
      const data = {
        email: VisitorsUserName,
        password: VisitorsPassword,
      };
      axios
        .post(route, data)
        .then((response) => {
          if (response.status == 200) {
            localStorage.setItem("visitors_token", response.data.token);
            this.fillPieChartData();
          }
        })
        .catch((errors) => console.log(errors));
    },
  },
  mounted() {
    if (localStorage.getItem("visitors_token") == null) {
      this.visitorsApiLogin();
    } else {
      this.fillPieChartData();
    }
  }
};
</script>
