<template>
    <div class="row p-4">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info mb-0 mt-3" id="example2_info" role="status" aria-live="polite">
                Showing 
                <span v-if="pagination.from">{{ pagination.from }}</span> 
                <span v-else>0</span> 
                to 
                <span v-if="pagination.to">{{ pagination.to }}</span>
                <span v-else>0</span>
                 of {{ pagination.total }} entries
            </div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination float-right mb-0 mt-3">
                    <li v-if="pagination.currentPage > 1" class="paginate_button page-item previous">
                        <a href="javascript:void(0)" class="page-link" aria-label="Previous" v-on:click.prevent="changePage(pagination.currentPage - 1)">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                    <li v-for="(page, index) in pagesNumber" 
                        :key="index" 
                        :class="{'active': page == pagination.currentPage}"
                        class="paginate_button page-item">
                        <a href="javascript:void(0)" class="page-link" v-on:click.prevent="changePage(page)">{{ page }}</a>
                    </li>
                     <li v-if="pagination.currentPage < pagination.lastPage" class="paginate_button page-item next">
                        <a class="page-link" href="javascript:void(0)" aria-label="Next" v-on:click.prevent="changePage(pagination.currentPage + 1)">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
</template>


<script>
export default{
      props: {
      pagination: {
          type: Object,
          required: true
      },
      offset: {
          type: Number,
          default: 4
      }
    },
    computed: {
      pagesNumber() {
        if (!this.pagination.to) {
          return [];
        }
        let from = this.pagination.currentPage - this.offset;
        if (from < 1) {
          from = 1;
        }
        let to = from + (this.offset * 2);
        if (to >= this.pagination.lastPage) {
          to = this.pagination.lastPage;
        }
        let pagesArray = [];
        for (let page = from; page <= to; page++) {
          pagesArray.push(page);
        }
          return pagesArray;
      }
    },
    methods : {
      changePage(page) {
        this.pagination.currentPage = page;
        this.$emit('paginate');
      }
    }
  }
</script>

