<style scoped>
.todo-search{
      border: 1px solid #efefef;
    height: 40px;
    padding-left: 10px;
    padding-right: 10px;
}
.todo-search>div>i{
  line-height: 40px;
  vertical-align: middle;
}
</style>
<template>
  <div class="container">
    <div class="input-group mb-3 mt-3 todo-search rounded-pill">
       <div class="input-group-prepend">
<i class="fas fa-search light-blue"></i>
  </div>
      <input
        v-model="filterQuery.keyword"
        type="text"
        class="form-control border-0 h-100"
        placeholder="Search Tasks"
        aria-label="Todo Title"
        aria-describedby="basic-addon2"
      />
      <div class="input-group-append">
       <i class="fas fa-sort-amount-down orange"></i>
      </div>
    </div>
    <div v-if="todoType!=1" class="input-group mb-3">
      <multiselect
        v-model="filterQuery.asignedUser"
        tag-placeholder="filter by user"
        placeholder="Select User"
        selectedLabel
        label="name"
        track-by="id"
        class="dropdaown-select2 rounded-0 todo-box"
        :options="userOptions"
        :multiple="true"
        :taggable="true"
      ></multiselect>
    </div>
  </div>
</template>
    <script>
import { mapGetters } from "vuex";
import _ from "lodash";
export default {
  props: ["todoType", "priorities", "userOptions"],
  name: "Searchbar",
  
  data() {
    return {
      filterQuery: {
        keyword: "",
        asignedUser: [],
        todoType:this.todoType
      }
    };
  },
  watch: {
    filterQuery: {
      handler: _.debounce(function() {
        this.searchTodos();
      }, 100),
      deep: true
    }
  },
  methods: {
    searchTodos() {
      this.filterQuery.todoType=this.todoType;
      this.$store.dispatch("SEARCH_TODOS", this.filterQuery);
    }
  }
};
</script>

    <style scoped>
</style>