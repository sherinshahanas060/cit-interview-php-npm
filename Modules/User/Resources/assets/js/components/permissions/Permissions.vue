<style scoped>
.parent-permission {
  position: absolute;
  top: 8px;
  right: 50px;
}
</style>
<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Roles</div>
          <div class="card-body">
            <section class="content">
              <div class="row">
                <div class="col-md-3">
                  <button
                    v-if="permissions.includes('role-create')"
                    @click="addRole()"
                    type="button"
                    class="btn mb-2 btn-success w-100"
                    title="New Role"
                  >
                    New Role <i class="fa fa-plus"></i>
                  </button>
                  <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                      <ul class="nav nav-pills ml-auto p-2">
                        <li
                          v-for="(role, index) in roles"
                          :key="index"
                          class="nav-item col-12 p-0 border mb-2"
                        >
                          <div
                            v-if="
                              user.roles && user.roles[0].name == 'super-admin'
                            "
                          >
                            <div
                              class="btn-group w-100"
                              role="group"
                              aria-label="Basic example"
                            >
                              <button type="button" class="btn btn-default">
                                <a
                                  @click="selectedRole(role.id, role.name)"
                                  :class="{
                                    'show active': selectedRoleId === role.id
                                  }"
                                  class="nav-link"
                                  href="#"
                                >
                                  {{ role.name }}
                                </a>
                              </button>
                              <button
                                type="button"
                                class="btn btn-default dropdown-toggle"
                                data-toggle="dropdown"
                                aria-expanded="false"
                              >
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <!-- <div
                                class="dropdown-menu"
                                role="menu"
                                x-placement="bottom-start"
                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(68px, 38px, 0px);"
                              >
                                <a
                                  v-if="permissions.includes('role-edit')"
                                  class="dropdown-item"
                                  href="#"
                                >
                                  <a
                                    class="d-table w-100"
                                    href="#"
                                    @click="editRole(role)"
                                  >
                                    Edit <i class="fa fa-edit"></i>
                                  </a>
                                </a>
                                <a
                                  v-if="permissions.includes('role-delete')"
                                  class="dropdown-item"
                                  href="#"
                                >
                                  <a
                                    class="d-table w-100"
                                    href="#"
                                    @click="deleteRole(role.id)"
                                  >
                                    Delete <i class="fa fa-trash red"></i>
                                  </a>
                                </a>
                              </div> -->
                            </div>
                          </div>
                          <div v-else-if="role.name != 'super-admin'">
                            <div
                              class="btn-group w-100"
                              role="group"
                              aria-label="Basic example"
                            >
                              <button type="button" class="btn btn-default">
                                <a
                                  @click="selectedRole(role.id, role.name)"
                                  :class="{
                                    'show active': selectedRoleId === role.id
                                  }"
                                  class="nav-link"
                                  href="#"
                                >
                                  {{ role.name }}
                                </a>
                              </button>
                              <button
                                type="button"
                                class="btn btn-default dropdown-toggle"
                                data-toggle="dropdown"
                                aria-expanded="false"
                              >
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <div
                                class="dropdown-menu"
                                role="menu"
                                x-placement="bottom-start"
                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(68px, 38px, 0px);"
                              >
                                <a
                                  v-if="permissions.includes('role-edit')"
                                  class="dropdown-item"
                                  href="#"
                                >
                                  <a
                                    class="d-table w-100"
                                    href="#"
                                    @click="editRole(role)"
                                  >
                                    Edit <i class="fa fa-edit"></i>
                                  </a>
                                </a>
                                <a
                                  v-if="permissions.includes('role-delete')"
                                  class="dropdown-item"
                                  href="#"
                                >
                                  <a
                                    class="d-table w-100"
                                    href="#"
                                    @click="deleteRole(role.id)"
                                  >
                                    Delete <i class="fa fa-trash red"></i>
                                  </a>
                                </a>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="card">
                    <div v-if="selectedRoleName" class="card-header">
                      {{ selectedRoleName }}
                    </div>
                    <div class="card-body">
                      <div
                        v-for="(modulePermission, index) in modulePermissions"
                        :key="index"
                        class="col-md-12 p-0"
                      >
                        <div class="card card-primary collapsed-card">
                          <div class="card-header">
                            <h3 class="card-title">
                              {{ modulePermission.name }}
                            </h3>

                            <div class="card-tools">
                              <button
                                type="button"
                                class="btn btn-tool"
                                data-card-widget="collapse"
                              >
                                <i class="fas fa-plus"></i>
                              </button>
                            </div>
                            <!-- /.card-tools -->
                          </div>
                          <!-- /.card-header -->
                          <div
                            v-for="(permission,
                            permissionIndex) in modulePermission.module_permission"
                            :key="permissionIndex"
                            class="card-body"
                          >
                            <div
                              v-if="permission.name == modulePermission.name"
                              class="row"
                            >
                              <!-- <div class="col">{{ permission.name }}</div> -->
                              <span
                                class="info-box-icon parent-permission border border-whites p-2 rounded"
                              >
                                <div class="col text-right">
                                  <b-form-checkbox
                                    switch
                                    :id="'permission-' + permission.id"
                                    :value="permission.id"
                                    v-model="selectedPermissions"
                                    unchecked-value="not_accepted"
                                  >
                                  </b-form-checkbox>
                                </div>
                              </span>
                            </div>
                            <div v-else class="row">
                              <div class="col">{{ permission.name }}</div>
                              <div class="col text-right">
                                <b-form-checkbox
                                  switch
                                  :id="'permission-' + permission.id"
                                  :value="permission.id"
                                  v-model="selectedPermissions"
                                  unchecked-value="not_accepted"
                                >
                                </b-form-checkbox>
                              </div>
                            </div>
                          </div>
                          <!-- /.card-body -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="add-or-edit-role"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-show="roleEditmode" id="">Update Role</h5>
            <h5 class="modal-title" v-show="!roleEditmode" id="">
              Add New Role
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="roleEditmode ? updateRole() : createRole()">
            <div class="modal-body">
              <div class="form-group col-sm-12">
                <label for="exampleInputFile">Role</label>
                <input
                  v-model="roleForm.name"
                  type="text"
                  name="name"
                  placeholder="Enter role name"
                  class="form-control"
                  id="roleName"
                  aria-describedby=""
                  :class="{ 'is-invalid': roleForm.errors.has('name') }"
                />
                <has-error :form="roleForm" field="name"></has-error>
              </div>
            </div>

            <div class="modal-footer">
              <button v-if="roleEditmode" type="submit" class="btn btn-success">
                Update
              </button>
              <button v-else type="submit" class="btn btn-success">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- / Modal -->
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      user: user,
      roles: [],
      accessPermissions: [],
      modulePermissions: [],
      selectedPermissions: [],
      selectedRoleId: "",
      selectedRoleName: "",
      roleEditmode: false,
      roleForm: new Form({
        id: "",
        name: ""
      })
    };
  },
  methods: {
    /*
     * Author: Iqbal
     * Date: 
     * Requirement: assign permission to role
     */
    syncPermissionToRole() {
      this.$Progress.start();
      let data = {
        permissions: this.selectedPermissions,
        role: this.selectedRoleId
      };
      let route = window.routes.syncPermissionToRole;
      axios
        .post(route, data)
        .then(() => {
          // toast.fire({
          //     type: "success",
          //     title: "Permissions assigned to Role"
          // });
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },

    /*
     * Author: Iqbal
     * Date: 
     * Requirement: show Add new role form
     */
    addRole() {
      $("#add-or-edit-role").modal("show");
    },

    /*
     * Author: Iqbal
     * Date: 
     * Requirement: edit role
     */
    editRole(role) {
      this.roleEditmode = true;
      this.roleForm.reset();
      $("#add-or-edit-role").modal("show");
      this.roleForm.fill(role);
    },

    /*
     * Author: Iqbal
     * Date: 
     * Requirement: delete role
     */
    deleteRole(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          // Send request to the server
          if (result.value) {
            let route = window.routes.destroyRole;
            this.roleForm
              .delete(route + "/" + id)
              .then(response => {
                toast.fire({
                  type: "success",
                  title: "Role added"
                });
                fire.$emit("afterAction");
              })
              .catch(errors => {
                swal("Failed!", "There was something wrong.", "warning");
              });
          }
        });
    },

    /*
     * Author: Iqbal
     * Date: 
     * Requirement: show permission for selected role
     */
    selectedRole(id, name) {
      this.selectedRoleId = id;
      this.selectedRoleName = name;
      let route = window.routes.showRolePermission;
      axios
        .get(route + id)
        .then(response => {
          let data = response.data;
          this.selectedPermissions = [];
          for (let i in data.permissions) {
            this.selectedPermissions.push(data.permissions[i].id);
          }
        })
        .catch(() => {});
    },

    /*
     * Author: Iqbal
     * Date: 
     * Requirement: create new role
     */
    createRole() {
      this.$mouse_disable();
      this.$Progress.start();
      let route = window.routes.storeRole;
      this.roleForm
        .post(route)
        .then(response => {
          this.$Progress.finish();
          this.roleForm.reset();
          $("#add-or-edit-role").modal("hide");
          toast.fire({
            type: "success",
            title: "Role added"
          });
          fire.$emit("afterAction");
          this.$mouse_enable();
        })
        .catch(errors => {
          this.$Progress.fail();
          console.log(errors);
          this.$mouse_enable();
        });
    },

    /*
     * Author: Iqbal
     * Date: 
     * Requirement: update role
     */
    updateRole() {
      this.$mouse_disable();
      this.$Progress.start();
      let route = window.routes.updateRole;
      this.roleForm
        .put(route + "/" + this.roleForm.id)
        .then(response => {
          $("#add-or-edit-role").modal("hide");
          toast.fire({
            type: "success",
            title: "Role updated"
          });
          this.$Progress.finish();
          fire.$emit("afterAction");
          this.$mouse_enable();
        })
        .catch(errors => {
          this.$Progress.fail();
          console.log(errors);
          this.$mouse_enable();
        });
    },

    /*
     * Author: Iqbal
     * Date: 
     * Requirement: Load roles
     */
    loadRolesAndPermissions() {
      let route = window.routes.rolePermissionIndex;
      axios
        .get(route)
        .then(response => {
          this.roles = response.data.role;
          this.modulePermissions = response.data.modulePermission;
        })
        .catch(errors => {
          console.log(errors);
        });
    }
  },
  watch: {
    selectedPermissions(newVal, oldVal) {
      if (this.selectedRoleId) {
        this.syncPermissionToRole();
      } else {
        toast.fire({
          type: "warning",
          title: "Please chose a role"
        });
      }
    }
  },
  created() {
    // load roles when page load
    this.loadRolesAndPermissions();
    fire.$on("afterAction", () => {
      this.loadRolesAndPermissions();
    });
  },
  mounted() {},
  computed: {}
};
</script>
