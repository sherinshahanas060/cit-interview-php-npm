
<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Add Or Edit Blog</div>

          <div class="card-body">
            <form @submit.prevent="editMode ? updateBlog() : createBlog()">
              <div class="row">
                <div class="form-group col-sm-12">
                  <div class="input-group">
                    <vue-dropzone
                      ref="dropzoneImage"
                      id="drop1"
                      title="Logo Smal"
                      :options="dropOptions"
                      class="col"
                      v-on:vdropzone-removed-file="removeThisFileImage"
                      @vdropzone-complete="afterCompleteImage"
                      :class="{ 'is-invalid': form.errors.has('logo_small') }"
                    ></vue-dropzone>
                    <has-error :form="form" field="logo_small"></has-error>
                  </div>
                </div>
                <div class="form-group col-sm-12">
                  <label for="exampleInputFile">Title</label>
                  <input
                    v-model="form.title"
                    type="text"
                    name="title"
                    placeholder="title"
                    class="form-control"
                    id="title"
                    title="title"
                    aria-describedby
                    :class="{ 'is-invalid': form.errors.has('title') }"
                  />
                  <has-error :form="form" field="title"></has-error>
                </div>
                <div class="form-group col-sm-12">
                  <label for="exampleInputFile">Content</label>
                  <div class="input-group">
                    <ckeditor
                      type="classic"
                      v-model="form.content"
                      class="w-100"
                      :class="{ 'is-invalid': form.errors.has('content') }"
                    ></ckeditor>
                  </div>
                  <has-error :form="form" field="content"></has-error>
                </div>
                <div class="form-group col-sm-12">
                  <BaseButton
                    v-if="!editMode"
                    class="float-right"
                    nativeType="submit"
                    :loading="isLoading"
                    type="primary"
                    rounded="0"
                    >Update</BaseButton
                  >
                  <BaseButton
                    v-else
                    class="float-right"
                    nativeType="submit"
                    :loading="isLoading"
                    type="primary"
                    rounded="0"
                    >Create</BaseButton
                  >
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import vue2Dropzone from "vue2-dropzone";
export default {
  components: {
    vueDropzone: vue2Dropzone
  },
  data() {
    return {
      editMode: false,
      form: new Form({
        id: "",
        title: "",
        content: "",
        image: ""
      }),
      dropOptions: {
        url: window.routes.fileUpload,
        maxFilesize: 1, // MB
        maxFiles: 1,
        acceptedFiles: ".jpg,.png,.gif,.jpeg",
        headers: {
          "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]")
            .content
        },
        addRemoveLinks: true
      }
    };
  },
  methods: {
    removeThisFileImage(file) {
      this.form.image = "";
    },
    afterCompleteImage(file) {
      this.form.image = file.name.replace(/ /g, "_");
    },
    createBlog() {
      this.isLoading = true;
      this.$mouse_disable();
      this.$Progress.start();
      // const url = `${API_URL}/api/phonebookapi/`;
      let route = window.routes.blogStore;
      this.form
        .post(route)
        .then(response => {
          this.isLoading = false;
          if (response.data.status == 101) {
            toast.fire({
              type: "success",
              title: "Blog created successfully"
            });
            fire.$emit("afterAction");
          } else {
            toast.fire({
              type: "warning",
              title: "Failed"
            });
            this.$Progress.fail();
          }
          this.$mouse_enable();
        })
        .catch(error => {
          this.isLoading = false;
          this.$Progress.fail();
          this.$mouse_enable();
        });
    },
    /*
     * Author: Iqbal
     * Date: 
     * Requirement: load form data for edit
     */
    loadBlog(id) {
      let route = window.routes.blogShow;
      axios
        .get(route + id)
        .then(response => {
          if (response.data.status == 100) {
            this.form.fill(response.data.data);
          }
        })
        .catch(errors => {});
    },
    /*
     * Author: Iqbal
     * Date: 
     * Requirement:
     */
    updateBlog() {
      this.isLoading = true;
      this.$mouse_disable();
      let route = window.routes.blogUpdate;
      this.$Progress.start();
      this.form
        .put(route + this.form.id)
        .then(response => {
          this.isLoading = false;
          if (response.data.status == 101) {
            toast.fire({
              type: "success",
              title: "Blog Updated Successfully"
            });
            this.$Progress.finish();
            fire.$emit("updateAfterAction");
          } else {
            toast.fire({
              type: "warning",
              title: "Failed"
            });
            this.$Progress.fail();
          }
          this.$mouse_enable();
        })
        .catch(errors => {
          this.isLoading = false;
          this.$Progress.fail();
          this.$mouse_enable();
        });
    }
  },
  created() {
    if (this.$route.params.id != 0) {
      this.editMode = true;
      this.loadBlog(this.$route.params.id);
    }
    fire.$on("afterAction", () => {
      this.form.reset();
      this.$Progress.finish();
      this.$refs.dropzoneImage.removeAllFiles();
    });
    fire.$on("updateAfterAction", () => {
      this.form.reset();
      this.$Progress.finish();
      this.$router.push({ name: "blogs" });
    });
  }
};
</script>