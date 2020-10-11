<style scoped>
.nav-count {
  width: 180px;
}
.nav-count li {
  display: inline-block;
}
.select2-container {
  width: 70px !important;
}
</style>
<template>
  <div class="nav-count">
    <!-- <li class="nav-item dropdown" title="Message">
      <Select2
        name="currency"
        @select="selectCountry($event)"
        v-model="currencyVal"
        :options="currencyOptions"
        id="currency"
        title="Status"
        class="dropdaown-select2"
      ></Select2>
    </li> -->
    <li class="nav-item dropdown position-static" title="To Do">
      <a @click="loadTodo=true" class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa fa-tasks"></i>
        <span class="badge badge-danger navbar-badge" data-count>{{ todoCount }}</span>
      </a>
      <div
        style="min-width:300px;height:calc(100vh - 60px);overflow-y:scroll;min-height:500px;"
        class="dropdown-menu todo-dropdown dropdown-menu-lg dropdown-menu-right p-0"
      >
        <keep-alive>
          <todo-app v-if="loadTodo"></todo-app>
        </keep-alive>
      </div>
    </li>
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown" title="Message">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa fa-comments"></i>
        <span class="badge badge-danger navbar-badge">0</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="#" class="dropdown-item dropdown-footer">0 Messages</a>
      </div>
    </li>

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown" title="Notification">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa fa-bell"></i>
        <span class="badge badge-warning navbar-badge">{{ notificationCount }}</span>
      </a>
      <div
        style="min-width:300px;overflow-y:scroll;height:500px;"
        class="dropdown-menu dropdown-menu-lg dropdown-menu-right pt-0"
      >
        <!-- <span class="dropdown-header">0 Notifications</span> -->
        <!-- <notification-app></notification-app> -->
      </div>
    </li>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      loadTodo: false,
      currencyVal: "",
      currencyOptions: [
        { id: "USD", text: "USD" },
        { id: "INR", text: "INR" },
        { id: "GBP", text: "GBP" },
        { id: "AED", text: "AED" }
      ]
    };
  },
  methods: {
    selectCountry(event) {
      // this.$store.commit("CURRENT_CURRENCY", this.currencyVal);
      // let route = window.routes.updateDefaultCUrrency;
      // axios
      //   .put(route + companyId, { currency: this.currencyVal })
      //   .then(response => {
      //     if (response.data.status == 101) {
      //     }
      //   })
      //   .catch(errors => {});
    }
  },
  created() {},
  mounted() {
    this.$store.dispatch("TODO_COUNT");
    // this.$store.dispatch("BASE_CURRENCY");
    // this.$store.dispatch("CURRENCY_VALUES");
    // this.$store.dispatch("CURRENT_CURRENCY");
    this.$store.dispatch("GET_PERMISSIONS");
    // this.currencyVal = this.baseCurrency;
  },
  computed: {
    
    ...mapGetters(["todoCount", "notificationCount", "baseCurrency"])
  }
};
</script>