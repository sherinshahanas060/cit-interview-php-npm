<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">View Blog</h3>
            <div class="card-tools" title="Add">
              <router-link
                v-if="permissions.includes('blog-edit')"
                :to="{ name: 'addOrEditBlog', params: { id : blog.id ? blog.id : 0 } }"
                title="Edit"
                class="btn btn-success"
              >
                Edit
                <i class="fa fa-edit"></i>
              </router-link>
            </div>
          </div>

          <div class="card-body">
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4 class="card-title mb-0">Blog</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <img
                        :src="`/file?name=image/${blog.image}&disk=blog_uploads`"
                        alt
                        class="img-fluid"
                      />
                    </div>
                      <h1 class="col-12 py-4">
                          {{blog.title}}
                      </h1>
                       <div v-html="blog.content"
                       class="col-12 text-center">

                       </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      blog: []
    };
  },
  methods: {
    /*
     * Author: Iqbal
     * Date: 
     * Requirement: Load partner By id
     */
    loadBlog(id) {
      let route = window.routes.blogView;
      axios
        .get(route + id)
        .then(response => {
          if (response.data.status == 101) {
            this.blog = response.data.data;
          } else {
            swal.fire("Failed!", "There was something wrong.", "warning");
          }
        })
        .catch(errors => {
          console.log(errors);
        });
    }
  },
  created() {
    if (this.$route.params.id != 0) {
      this.loadBlog(this.$route.params.id);
    }
  },
  mounted() {
  },
  computed: {
  }
};
</script>
