<template>
  <div v-dragscroll="false" class="table-responsive">
    <table class="table table-bordered table-striped dataTable border">
      <thead>
        <tr>
          <th v-for="column in columns"
            :key="column.name"
            @click="$emit('sort', column.name)"
            :class="column.sort != 0 ? (sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'):''"
            :style="'width:'+column.width+';'+'cursor:pointer;'"
          >{{column.label}}</th>
        </tr>
        <tr v-if="columnSearchProp">
          <td v-for="(searchField, index) in columns"
           :key="index"
           >
          <input v-if="searchField.search" 
            type="search" 
            v-model="searchField.val"
            @input="searchColumn(index)"
            class="form-control form-control-sm" 
            :name=index 
            :id=index 
            :placeholder=searchField.label>
          </td>
        </tr>
      </thead>
      <slot></slot>
    </table>
  </div>
</template>


<script>
export default {
  props: ["columns", "sortKey", "sortOrders","columnSearchProp"],
  data () {
    return {
      columnSearch : {
        column: '',
        val: ''
      }
    }
  },
  methods : {
    searchColumn(index) {
      
      this.columnSearch.column = this.columns[index].name;
      this.columnSearch.val = this.columns[index].val;
      this.$emit("serchEachColumn", this.columnSearch);
    }
  }
};
</script>
