<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="col-12">
          <div class="card-body row p-0">
            <div class="col-md-6 ">
              <Card class="card h-100">
                <div class="card-header">
                  <h3 class="card-title">Device Usage</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body ">
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
              </Card>
            </div>
            <div class="col-md-6 ">
              <Card class="card h-100">
                <div class>
                  <div class="card-header">
                    <h3 class="card-title">Country</h3>
                  </div>
                  <div class="col-md-12 px-0">
                    <div class="row">
                      <div class="col-md-12">
                        <line-chart
                          width="auto"
                          height="auto"
                          :chart-data="lineChartDataCollection"
                          class="chartjs-render-monitor"
                        ></line-chart>
                      </div>
                    </div>
                  </div>
                </div>
              </Card>
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
      pieDataCollection: null,
      lineChartDataCollection: null
    };
  },
  methods: {
    fillPieChartData() {
      let route = VisitorsAPI + "device_count";
      axios
        .get(route, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("visitors_token")}`
          }
        })
        .then(
          response => {
            this.pieDataCollection = {
              type: "pie",
              labels: ["Mobile", "Desktop", "Tablet"],
              datasets: [
                {
                  label: "Data One",
                  backgroundColor: ["#41B883", "#E46651", "#00D8FF"],
                  data: [
                    response.data.Mobile,
                    response.data.Desktop,
                    response.data.Tablet
                  ]
                }
              ]
            };
          },
          error => {
            if (error.response.status == 401) {
              this.visitorsApiLogin();
            }
          }
        )
        .catch(errors => console.log(errors));
    },
    visitorsApiLogin() {
      console;
      let route = VisitorsAPI + "login";
      const data = {
        email: VisitorsUserName,
        password: VisitorsPassword
      };
      axios
        .post(route, data)
        .then(response => {
          if (response.status == 200) {
            localStorage.setItem("visitors_token", response.data.token);
            this.fillPieChartData();
             this.fillChartData();
          }
        })
        .catch(errors => console.log(errors));
    },
    fillChartData() {
      let route = VisitorsAPI + "visitors_country_all";
      axios
        .get(route, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("visitors_token")}`
          }
        })
        .then(response => {
          if (response.data.data) {
            this.lineChartDataCollection = {
              labels: [],
              datasets: []
            };
            response.data.countries.map(cobj => {
              this.lineChartDataCollection.labels.push(cobj);
            });
            var color = ["rgba(54, 162, 235, 0.2)", "rgba(255, 99, 132, 0.2)"];
            var dataset = response.data.data;
            var years = [...new Set(dataset.map(obj => obj.year))];
            this.lineChartYears = years;
            years.forEach((result, index) => {
              let data = [];
              let i;
              for (
                i = 0;
                i < this.lineChartDataCollection.labels.length;
                i++
              ) {
                data.push(0);
              }

              dataset.forEach(element => {
                if (element.year == result) {
                  data[this.lineChartDataCollection.labels.indexOf(element.country)] = element.data;
                }
              });
              this.lineChartDataCollection.datasets.push({
                label: result,
                backgroundColor: color[index],
                data: data
              });
            });
          }
        })
        .catch(errors => {});
    }
  },
  mounted() {
    if (localStorage.getItem("visitors_token") == null) {
      this.visitorsApiLogin();
    } else {
      this.fillPieChartData();
      this.fillChartData();
    }
  }
};
</script>
