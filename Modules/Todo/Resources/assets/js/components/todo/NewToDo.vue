//../resources/js/components/NewTodo.vue
    <template>
  <div class="card shadow-none todo-options card-primary border-0 m-0">
    <!-- /.card-header -->
    <div class="card-body pt-2 pb-0" style="display: block;">
      <div class="row">
        <div class="col-12">
          <button
            class="new-todo-btn col-12 btn dummy-input"
            v-on:click="showTodoOptions = !showTodoOptions"
          >
            <span>Add task</span>
            <i class="fas fa-plus-square pl-2 orange font-big float-right"></i>
          </button>
        </div>
      </div>
      <!--todo Add options -->
      <transition name="slide">
        <div v-if="showTodoOptions" class="mt-2 p-0 newtodo-box col-12">
          <div class="holder" v-on:click.stop="showTodoOptions = false"></div>
          <div class="col-12 p-0 float-left bg-white">
            <div class="input-group border input-group mb-3">
              <input
                type="text"
                v-model="newTodo.title"
                @keyup.enter="addTodo"
                autofocus="autofocus"
                class="new-todo border-0 todo-nameinput pl-3 pr-2 form-control"
                aria-label="With textarea"
                placeholder="Add Task"
              />
            </div>
            <!--end visible main todo input -->

            <div v-if="todoType == 2" class="p-0 form-group col-12">
              <multiselect
                v-model="newTodo.assigned"
                tag-placeholder="Add this user"
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
            <div class="col-12 float-left row p-0">
              <div class="col-12 btn-group-toggle todo-priorities">
                <label
                  v-for="priority in priorities"
                  :key="priority.id"
                  :for="'me'+priority.id"
                  class="btn pty p-2"
                  :id="priority.name"
                  :class="{ active : toDoPriority === priority.id }"
                  :style="{ 
                      'border':'1px solid' + priority.color,
                      'background':priority.color
                      }"
                >
                  <input
                    v-model="toDoPriority"
                    type="radio"
                    :id="'me'+priority.id"
                    :value="priority.id"
                    :key="priority.id"
                    name="Priority"
                  />
                  <div class="schedule-picker" v-if="priority.id == todoSchedule">
                    <i class="fa fa-calendar-alt"></i>
                    <date-picker
                      format="DD-MM-YYYY"
                      v-model="newTodo.task_date"
                      value-type="format"
                      lang="en"
                      class="schedule"
                      title="Task Date"
                      placeholder
                    ></date-picker>
                  </div>
                  <span v-else>{{ priority.name }}</span>
                </label>
              </div>
              <div
                v-if="dateerror"
                class="alert alert-danger col-12 p-2 ml-3"
                role="alert"
              >Please select a task date!</div>
              <div class="col-12">
                <button @click="addTodo" class="btn btn-todo-subit btn-lg" type="button">Add Task</button>
              </div>
              <!-- <div class="form-group col-12">
              <label for="inputDescription">Description</label>
              <textarea v-model="newTodo.about" id="inputDescription" class="form-control" rows="4"></textarea>
              </div>-->
            </div>
          </div>
        </div>
      </transition>
      <!-- <pre>{{ newTodo }}</pre> -->
    </div>
    <!-- /.card-body -->
  </div>
</template>
    <script>
import { mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
// Vue.use(vOutsideEvents)
export default {
  props: ["todoType", "priorities", "userOptions"],
  name: "NewTodo",
  components: { datePicker: DatePicker },
  data() {
    return {
      toDoPriority: 0,
      dateerror: false,
      showTodoOptions: false,
      todoSchedule: utilsConstants.SCHEDULED
    };
  },
  methods: {
    addTodo() {
      if (this.toDoPriority == 0) {
        this.dateerror = true;
      } else {
        this.newTodo.type = this.todoType;
        this.newTodo.priority_id = this.toDoPriority;
        this.$store.dispatch("ADD_TODO", this.newTodo);
        this.dateerror = false;
        this.toDoPriority = 0;
      }
    },
    hideoption() {
      this.showTodoOptions = false;
    }
  },
  created() {},
  computed: {
    ...mapGetters(["newTodo"])
  }
};
</script>
<style scoped>
.new-todo .input-group-prepend .input-group-text {
  background: transparent;
  border: 0;
  padding-top: 0px;
  padding-bottom: 0px;
  height: 36px;
}
.new-todo .todo-nameinput::-webkit-input-placeholder {
  /* Chrome/Opera/Safari */
  font-size: 17px;
  color: #6245cc;
  padding-top: 10px;
  padding-left: 15px;
}
.new-todo .todo-nameinput::-moz-placeholder {
  /* Firefox 19+ */
  font-size: 17px;
  color: #6245cc;
}
.new-todo .todo-nameinput:-ms-input-placeholder {
  /* IE 10+ */
  font-size: 17px;
  color: #6245cc;
}
.new-todo .todo-nameinput:-moz-placeholder {
  /* Firefox 18- */
  font-size: 17px;
  color: #6245cc;
}
.todo-nameinput:focus {
  border: 0px !important;
}
.todo-nameinput {
  color: #6245cc !important;
  font-size: 16px !important;
  border: 0px;
}
.btn-todo-subit {
  background: #6245cc;
  color: #fff;
}
.btn-todo-subit:hover {
  background: #5134bb;
  color: #fff;
}
.pty:not(.active) {
  background: #fff !important;
}
.pty.active {
  color: #fff;
}
.pty:hover {
  border: 2px;
}
#Scheduled {
  width: 50px;
  padding: 0px !important;
  overflow: hidden;
  height: 40px;
  display: none;
}
#Scheduled .mx-datepicker {
  position: unset !important;
}
.new-todo-btn {
  background: transparent;
}
.new-todo-btn:hover i {
  color: #e3342f !important;
}
.new-todo-btn span {
  display: inline-block;
  line-height: 30px;
  /* float: left; */
}
.newtodo-box {
    float: left;
    position: relative;
    z-index: 1001;
    background: #fff;
    left: 0;
    top: -59px;
}
.dummy-input {
  border: 1px solid #efefef;
  padding: 8px 20px;
  text-align: left;
  color: #efefef;
}
.holder {
  position: fixed;
  height: 100%;
  background: rgba(0, 0, 0, 0);
  width: 283px;
  display: block;
  top: 57px;
  right: 17px;
  z-index: -1;
}
</style>
