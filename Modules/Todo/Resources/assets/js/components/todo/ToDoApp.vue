//../resources/js/components/TodoApp.vue
<style scoped>
.todo-nav li a {
  height: 60px;
  font-size: 14px;
  line-height: 44px;
  border: 0px;
  border-radius: 0px;
}
</style>
     <template>
  <div class="container-fluid p-0 b-0">
    <div class="row m-0 p-0 justify-content-center w-100">
      <div class="col-md-12 p-0 todo-nav">
        <div>
          <b-tabs v-model="todotabIndex" content-class="mt-3" justified>
            <b-tab @click="selectType(1)" title="My Task" active>
              <keep-alive>
                <todo-list
                  v-if="todotabIndex==0"
                  :todoType="type"
                  :priorities="priorities"
                  :userOptions="userOptions"
                ></todo-list>
              </keep-alive>
            </b-tab>
            <b-tab @click="selectType(2)" title="Team Task">
              <keep-alive>
                <teamTodos
                  v-if="todotabIndex==1"
                  :todoType="type"
                  :priorities="priorities"
                  :userOptions="userOptions"
                ></teamTodos>
              </keep-alive>
            </b-tab>
            <b-tab title="Completed">
              <keep-alive>
                <completedTodos v-if="todotabIndex==2" :userOptions="userOptions"></completedTodos>
              </keep-alive>
            </b-tab>
          </b-tabs>
        </div>
      </div>
    </div>
  </div>
</template>
     <script>
import todoList from "../todo/ToDoList.vue";
import completedTodos from "../todo/completed/CompletedTodos.vue";
import teamTodos from "../todo/team/TeamTodos.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    todoList,
    completedTodos,
    teamTodos
  },
  name: "TodoApp",
  data() {
    return {
      count: 0,
      type: 1,
      priorities: [],
      userOptions: [],
      todotabIndex: 0
    };
  },
  methods: {
    selectType(todoType) {
      this.type = todoType;
    },
    loadPriorities() {
      let route = window.routes.priorityIndex;
      axios
        .get(route)
        .then(response => {
          if (response.data.status == 100) {
            this.priorities = response.data.data;
          }
        })
        .catch(errors => {
          console.log(errors);
        });
    },
    loadUsers() {
      let route = window.routes.getUsers;
      axios
        .get(route)
        .then(response => {
          if (response.data.status == 100) {
            this.userOptions = response.data.data.map(function(value) {
              let obj = {
                id: value.id,
                name: value.name,
                image: value.profile_image
              };
              return obj;
            });
          }
        })
        .catch(errors => {
          console.log(errors);
        });
    }
  },
  created() {
    this.loadPriorities();
    this.loadUsers();
  },
  mounted() {
    window.Echo.channel("newToDoTask").listen(".todo-task-created", e => {
      this.$store.commit("ADD_TODO", e.toDoTask);
      this.newTodo.title = "";
      this.newTodo.about = "";
      this.newTodo.assigned = [];
    });
    window.Echo.channel("toDoTaskForward").listen(".todo-task-forward", e => {
      this.$store.commit("FORWARD_TODO", e.toDoTask);
    });
    window.Echo.channel("toDoTaskRemoved").listen(".todo-task-removed", e => {
      this.$store.commit("DELETE_TODO", e.toDoTask);
    });
    window.Echo.channel("toDoTaskCompleted").listen(
      ".todo-task-completed",
      e => {
        this.$store.commit("COMPLETE_TODO", e.toDoTask);
      }
    );
  },
  computed: {
    ...mapGetters([
      "toRemoveToDo",
    ]),
    ...mapGetters(["newTodo"])
  }
};
</script>