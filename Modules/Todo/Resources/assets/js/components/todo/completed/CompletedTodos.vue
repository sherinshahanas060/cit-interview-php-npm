<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
        <searchbar :userOptions="userOptions" :todoType="3"></searchbar>
      <div class="col-12 p-0">
        <div v-for="todos in completedTodos" :key="todos.id">
          <todo :todo="todos"></todo>
        </div>
      </div>
    </div>
  </div>
</template>

    <script>
import { mapGetters } from "vuex";
import todo from "./ToDo.vue";
import searchbar from "../SearchBar";
export default {
   props: ["userOptions"],
  name: "completedTodose",
  components: {
    todo,
    searchbar
  },
  mounted() {
    this.$store.dispatch("GET_COMPLETED_TODOS");
  },
  computed: {
    ...mapGetters(['completedTodos'])
  }
};
</script>
