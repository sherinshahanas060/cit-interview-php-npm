//../resources/js/components/TodoList.vue
<style scoped>
.todo-listing h5 {
  font-size: 15px;
}
.todo-drag-list {
  padding: 0px !Important;
  border: 0px !important;
}
</style>
    <template>
    
  <div class="todo-listing">
      <h6 class="col-12">
      <span class="orange">Hello, </span>  {{user.name}} <br/>
      You team have
      <span v-if="teamTodos">{{teamTodos[1].length}}</span> Tasks today
    </h6>
     <new-todo :todoType="todoType" :priorities="priorities" :userOptions="userOptions"></new-todo>
    <searchbar :userOptions="userOptions" :todoType="todoType"></searchbar>
   
    <div v-for="priority in priorities" :key="priority.id" class="card shadow-none border-0">
      <div class="card-header pl-3 border-0 bg-white">
        <h5 v-bind:style="{'color' : priority.color}" class="card-title">{{ priority.name }} 
           <b-badge v-if="(teamTodos[priority.id])" v-bind:style="{'background' : priority.color}">{{teamTodos[priority.id].length}}</b-badge>
          </h5>

        <div class="card-tools">
          <button
            type="button"
            aria-expanded="true"
            class="btn btn-tool"
            data-card-widget="collapse"
          >
            <i v-bind:style="{'color' : priority.color}" class="fas fa-angle-up"></i>
          </button>
        </div>
        <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body show pr-0 pl-2 pt-2 float-left">
        <draggable
          :id="priority.id"
          :list="teamTodos[priority.id]"
          class="list-group"
          draggable=".item"
          group="a"
          :todoType="todoType"
          :userOptions="userOptions"
        >
          <div
            class="list-group-item item todo-drag-list"
            v-for="(todo, index) in teamTodos[priority.id]"
            :key="index"
          >
            <div>
              <todo
                @forwardTodo="forwardToDoModal"
                :todo="todo"
                :todoType="todoType"
                :userOptions="userOptions"
              />
            </div>
          </div>
        </draggable>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- Forward Modal -->
    <div
      class="modal fade"
      id="forward-todo-modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Forward Todo</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
              title="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-12">
                <label for="inputDescription">User</label>
                <multiselect
                  v-if="todoForward.type == 2"
                  v-model="todoForward.assigned"
                  tag-placeholder="Add this user"
                  placeholder="Select User"
                  label="name"
                  track-by="id"
                  class="dropdaown-select2"
                  :options="userOptions"
                  :multiple="true"
                  :taggable="true"
                ></multiselect>
                <multiselect
                  v-else
                  v-model="todoForward.assigned"
                  tag-placeholder="Add this user"
                  placeholder="Select User"
                  label="name"
                  :limit="1"
                  :max="1"
                  track-by="id"
                  class="dropdaown-select2"
                  :options="userOptions"
                  :multiple="true"
                  :taggable="true"
                ></multiselect>
              </div>
              <div class="col-12 float-right">
                <button @click="forwardTodo" type="button" class="btn btn-success">Done</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Forward Modal -->
  </div>
</template>

    <script>
import { mapGetters } from "vuex";
import moment from "moment";
import draggable from "vuedraggable";
import todo from "../ToDo";
import searchbar from "../SearchBar";
import newTodo from "../../todo/NewToDo.vue";
let id = 1;
export default {
  name: "list_teamTodos",
  props: ["todoType", "priorities", "userOptions"],
  components: {
    todo,
    newTodo,
    draggable,
    searchbar
  },
  name: "TodoList",
  data() {
    return {
      user: user,
      todoForward: {
        to_do_id: "",
        assigned: [],
        type: ""
      },
    };
  },
  methods: {
    
    forwardTodo() {
      this.$store.dispatch("FORWARD_TODO", this.todoForward);
      $("#forward-todo-modal").modal("hide");
    },
    forwardToDoModal(toForwardTodo) {
      this.todoForward.to_do_id = toForwardTodo.id;
      this.todoForward.type = toForwardTodo.type;
      $("#forward-todo-modal").modal("show");
    }
  },
  mounted() {
    this.$store.dispatch("GET_TEAMTODOS");
    window.Echo.channel("search").listen(".searchResults", e => {
      this.$store.commit("SET_TEAMTODOS", e.todos);
    });
  },
  computed: {
    ...mapGetters(["teamTodos"])
  },
  created() {}
};
</script>