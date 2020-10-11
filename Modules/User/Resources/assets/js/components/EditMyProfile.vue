<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Edit Component</div>

          <div class="card-body">
            <div v-if="form.profile_image" class="col-6 col-sm-2 mb-3 p-0">
              <img
                :src="
                  `/file?name=profile/${form.profile_image}&disk=user_uploads`
                "
                alt
                class="img-fluid"
              />
            </div>
            <form @submit.prevent="updateUser()" enctype="multipart/form-data">
              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">User Name / Email</label>
                  <input
                    v-model="form.email"
                    type="text"
                    autocomplete="off"
                    name="email"
                    placeholder="Enter Email"
                    class="form-control"
                    id="email"
                    title="User Name/Email"
                    aria-describedby
                    :class="{ 'is-invalid': form.errors.has('email') }"
                  />
                  <has-error :form="form" field="email"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">Password</label>
                  <input
                    v-model="form.password"
                    type="password"
                    name="password"
                    placeholder="Enter Password"
                    class="form-control"
                    id="password"
                    title="Password"
                    aria-describedby
                    :class="{ 'is-invalid': form.errors.has('password') }"
                  />
                  <has-error :form="form" field="password"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">Join Date</label>
                  <date-picker
                    v-model="form.join_date"
                    format="DD-MM-YYYY"
                    value-type="format"
                    lang="en"
                    class="w-100"
                    title="Join Date"
                    :class="{ 'is-invalid': form.errors.has('join_date') }"
                  ></date-picker>

                  <has-error :form="form" field="join_date"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">Status</label>
                  <Select2
                    name="type"
                    v-model="form.user_status"
                    :options="StatusOptions"
                    id="employee-status"
                    title="Status"
                    class="dropdaown-select2"
                    :class="{
                      'is-invalid': form.errors.has('employee_status')
                    }"
                  ></Select2>
                  <has-error :form="form" field="user_status"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">Title</label>
                  <Select2
                    v-model="form.title"
                    name="title"
                    :options="titleOptions"
                    id="title"
                    title="Tilte"
                    class="dropdaown-select2"
                    :class="{
                      'is-invalid': form.errors.has('title')
                    }"
                  ></Select2>
                  <has-error :form="form" field="title"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">First Name</label>
                  <input
                    v-model="form.first_name"
                    type="text"
                    name="first_name"
                    placeholder="Enter First Name"
                    class="form-control"
                    id="first-name"
                    title="First Name"
                    aria-describedby
                    :class="{ 'is-invalid': form.errors.has('first_name') }"
                  />
                  <has-error :form="form" field="first_name"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">Middle Name</label>
                  <input
                    v-model="form.middle_name"
                    type="text"
                    name="middle_name"
                    placeholder="Enter Middle Name"
                    class="form-control"
                    id="middle-name"
                    title="Middle Name"
                    aria-describedby
                    :class="{ 'is-invalid': form.errors.has('middle_name') }"
                  />
                  <has-error :form="form" field="middle_name"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">Second Name</label>
                  <input
                    v-model="form.second_name"
                    type="text"
                    name="second_name"
                    placeholder="Enter Second Name"
                    class="form-control"
                    id="second-name"
                    title="Second Name"
                    aria-describedby
                    :class="{ 'is-invalid': form.errors.has('second_name') }"
                  />
                  <has-error :form="form" field="second_name"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">Gender</label>
                  <Select2
                    name="type"
                    v-model="form.gender"
                    :options="GenderOptions"
                    id="employee-gender"
                    title="Gender"
                    class="dropdaown-select2"
                    :class="{ 'is-invalid': form.errors.has('gender') }"
                  ></Select2>
                  <has-error :form="form" field="gender"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">Date Of Birth</label>
                  <date-picker
                    v-model="form.date_of_birth"
                    format="DD-MM-YYYY"
                    value-type="format"
                    lang="en"
                    class="w-100"
                    title="Date Of Birth"
                    :class="{ 'is-invalid': form.errors.has('date_of_birth') }"
                  ></date-picker>
                  <has-error :form="form" field="date_of_birth"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">Mobile Number</label>
                  <vue-tel-input
                    v-model="form.mobile_number"
                    type="text"
                    name="mobile_number"
                    placeholder="Enter Mobile Number"
                    class="form-control"
                    :valid-characters-only="true"
                    id="mobile-number"
                    title="Mobile Number"
                    aria-describedby
                    :class="{ 'is-invalid': form.errors.has('mobile_number') }"
                  ></vue-tel-input>
                  <has-error :form="form" field="mobile_number"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">Nationality</label>
                  <Select2
                    name="type"
                    v-model="form.nationality"
                    :options="countryOpt"
                    id="employee-nationality"
                    title="Nationality"
                    class="dropdaown-select2"
                    :class="{ 'is-invalid': form.errors.has('nationality') }"
                  ></Select2>
                  <has-error :form="form" field="nationality"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">Department</label>
                  <Select2
                    name="type"
                    v-model="form.department"
                    :options="DepartmentOptions"
                    id="employee-department"
                    title="Department"
                    class="dropdaown-select2"
                    :class="{ 'is-invalid': form.errors.has('department') }"
                  ></Select2>
                  <has-error :form="form" field="department"></has-error>
                </div>
                <div class="form-group col-sm-6">
                  <label for="exampleInputFile">Profession</label>
                  <input
                    v-model="form.profession"
                    type="text"
                    name="profession"
                    placeholder="Enter"
                    class="form-control"
                    id="profession"
                    title="Profession"
                    aria-describedby
                    :class="{ 'is-invalid': form.errors.has('profession') }"
                  />
                  <has-error :form="form" field="profession"></has-error>
                </div>
                <div class="form-group col-sm-12">
                  <label for="exampleInputFile">File</label>
                  <div class="input-group">
                    <vue-dropzone
                      ref="dropzone"
                      id="drop1"
                      title="File"
                      :options="dropOptions"
                      class="col"
                      v-on:vdropzone-removed-file="removeThisFile"
                      @vdropzone-complete="afterComplete"
                      :class="{
                        'is-invalid': form.errors.has('profile_image')
                      }"
                    ></vue-dropzone>

                    <has-error :form="form" field="profile_image"></has-error>
                  </div>
                </div>
              </div>
              <BaseButton
                class="float-right"
                nativeType="submit"
                :loading="isLoading"
                type="primary"
                rounded="0"
                >Update</BaseButton
              >
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import DatePicker from "vue2-datepicker";
export default {
  components: { vueDropzone: vue2Dropzone, datePicker: DatePicker },
  data() {
    return {
      editMode: false,
      user: user,
      form: new Form({
        id: "",
        user_id: "",
        email: "",
        password: "",
        role: [],
        join_date: "",
        user_status: "",
        title: "",
        first_name: "",
        second_name: "",
        middle_name: "",
        gender: "",
        date_of_birth: "",
        mobile_number: "",
        nationality: "",
        department: "",
        profession: "",
        profile_image: ""
      }),
      titleOptions: [
        { id: "", text: "Select Title" },
        { id: "Dr", text: "Dr" },
        { id: "Prof", text: "Prof" },
        { id: "Mr", text: "Mr" },
        { id: "Miss", text: "Miss" },
        { id: "Mrs", text: "Mrs" },
        { id: "Ms", text: "Ms" },
        { id: "Master", text: "Master" }
      ],
      dropOptions: {
        url: window.routes.fileUpload,
        acceptedFiles: ".jpg,.png,.gif,.jpeg",
        maxFiles: 1,
        headers: {
          "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]")
            .content
        },
        addRemoveLinks: true
      },
      StatusOptions: [
        { id: 1, text: "Active" },
        { id: 0, text: "In-active" }
      ],
      GenderOptions: [
        { id: 0, text: "Select Gender" },
        { id: 1, text: "Male" },
        { id: 2, text: "Female" }
      ],
      DepartmentOptions: [
        { id: 0, text: "Select Department" },
        { id: "Management", text: "Management" },
        { id: "Operations", text: "Operations" },
        { id: "Sales", text: "Sales" },
        { id: "Design", text: "Design" },
        { id: "Production", text: "Production" }
      ],
      roleOptions: []
    };
  },
  methods: {
    removeThisFile(file) {
      this.form.profile_image = "";
    },
    afterComplete(file) {
      this.form.profile_image = file.name.replace(/ /g, "_");
    },
    /*
     * Author: Iqbal
     * Date:
     * Requirement: edit my profile
     */
    updateUser() {
      this.isLoading = true;
      this.$mouse_disable();
      this.$Progress.start();
      // const url = `${API_URL}/api/phonebookapi/`;
      let route = window.routes.updateMyProfile;
      this.form
        .put(route + this.$route.params.id)
        .then(response => {
          this.isLoading = false;
          if (response.data.status == 100) {
            
            toast.fire({
              type: "success",
              title: "My Profile updated successfully"
            });
            this.$Progress.finish();
            fire.$emit("afterActionUpdate");
            
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
     * Requirement: load Role options
     */
    loadRoleOption() {
      let route = window.routes.getAllRoles;
      axios.get(route).then(response => {
        response.data.data.forEach(result => {
          if (result.name != "super-admin") {
            let roleArray = {
              code: result.id,
              id: result.id,
              name: result.name
            };
            this.roleOptions.push(roleArray);
          }
        });
      });
    },
    /*
     * Author: Iqbal
     * Date:
     * Requirement: load User details
     */
    loadUser(user_id) {
      let route = window.routes.showMyProfile + user_id;
      axios
        .get(route)
        .then(response => {
          this.form.reset();
          this.form.fill(response.data.data.user_details);
          if (response.data.data.roles.length > 0) {
            this.form.role = [];
            response.data.data.roles.forEach(result => {
              let roleArray = {
                code: result.id,
                id: result.id,
                name: result.name
              };
              this.form.role.push(roleArray);
            });
          }
        })
        .catch(errors => {
          console.log(errors);
        });
    }
  },
  created() {
    if (this.$route.params.id > 0) {
      this.editMode = true;
      this.loadUser(this.$route.params.id);
    }
    // load roleOptions
    this.loadRoleOption();
    fire.$on("afterAction", () => {
      this.$Progress.finish();
      this.form.reset();
      this.$refs.dropzone.removeAllFiles();
    });

    fire.$on("afterActionUpdate", () => {
      this.$router.push({ name: "AdminDashboard" });
    });
  }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>