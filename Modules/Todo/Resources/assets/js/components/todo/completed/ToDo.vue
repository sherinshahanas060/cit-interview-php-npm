<style>
.modal-dialog {
  display: table;
}
.modal-backdrop.fade.show {
  z-index: 999;
}
.todo-title-show {
  float: left;
  width: calc(100% - 30px);
  word-break: break-word;
  display: block;
  white-space: pre-wrap;
  padding-left: 10px;
}
.todo-listings label {
  top: 3px;
}
.todo-listings {
    background: #F4F6F9;
    width: 96% !important;
    border-radius: 10px;
    padding: 10px !important;
}
.todo-user-image {
  width: 20px;
  height: 20px;
  overflow: hidden;
  position: relative;
  border-radius: 50%;
  overflow: hidden;
  margin-right: 5px;
  display: inline-block;
}
.todo-user-image img {
  min-width: auto;
  height: 100%;
  min-height: 100%;
  width: auto;
  max-width: unset;
  max-height: unset;
}
.forward-btn {
  font-size: 11px !important;
}
</style>
<template>
  <div>
    <!-- Own Task Tab -->
    <ul class="list-unstyled" data-widget="todo-list">
      <li class="todo">
        <a href="#" class="dropdown-item p-0">
          <!-- Message Start -->
          <div class="media">
            <div class="media-body col-12 p-0">
              <div class="icheck-success todo-listings col-12 float-left">
                <input
                  trueValue="1"
                  falseValue="0"
                  v-model="todo.completed"
                  @change="checkCompleted(todo)"
                  class="toggle"
                  type="radio"
                  :id="todo.id"
                />
                <label :for="todo.id" class="font-reguler float-left"></label>
                <div class="todo-title-show">
                  <div class="col-12 p-0 float-left" @click="seenTodoDet = !seenTodoDet">
                    <p class="col-12 float-left font-med p-0 m-0">{{todo.title}}</p>
                    <div class="col-12 float-left mt-2 p-0">
                      <div class="col-5 float-left p-0">
                        <span
                          @click="$emit('forwardTodo', todo)"
                          class="float-left text-sm orange forward-btn mr-2"
                        >
                          <i class="fa fa-forward"></i>
                          <span>Forward</span>
                        </span>
                      </div>
                      <div class="col-6 float-right p-0">
                        <ul class="list-unstyled col-12 p-0 text-right">
                          <li
                            class="float-right"
                            v-for="(assignedUser, index) in todo.assigned"
                            :key="assignedUser.id"
                          >
                            <span v-if="index <=5">
                              <div
                                :title="assignedUser.user.name"
                                v-if="assignedUser.user.user_details"
                                class="todo-user-image img-circle"
                              >
                                <img
                                  :src="`/file?name=profile/${assignedUser.user.user_details.profile_image}&disk=user_uploads`"
                                  :alt="assignedUser.user.name"
                                  class="both-center"
                                />
                              </div>
                            </span>
                            <span v-else>...</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <transition name="slide">
                    <div class="todo-filter" v-if="seenTodoDet">
                      <div class="col-12 font-min p-0 float-left">
                        <span class="col-12 p-0 float-left grayLight">
                          <div
                            :title="todo.user.user_details.first_name"
                            v-if="todo.user.user_details"
                            class="todo-user-image float-left img-circle"
                          >
                            <img
                              :src="`/file?name=profile/${todo.user.user_details.profile_image}&disk=user_uploads`"
                              :alt="todo.user.user_details.first_name"
                              class="both-center"
                            />
                          </div>
                          <p class="p-0 float-left pr-2">Created By</p>
                          <p class="p-0 float-left">{{ todo.user.user_details.first_name }}</p>
                        </span>
                        <span
                          class="col-12 pr-0 pl-4 text-right float-left"
                          v-b-tooltip.hover
                          :title="todo.created_at | myDateTime"
                        >{{ todo.created_at | DateDiff }}</span>
                      </div>
                    </div>
                  </transition>
                </div>
              </div>
            </div>
          </div>

          <!-- Message End -->
        </a>
      </li>
    </ul>
  </div>
</template>
    <script>
export default {
  name: "Todo",
  props: ["todo", "todoType", "userOptions"],
  data() {
    return {
      user: user,
      ownGroup: true,
      seenTodoDet: false
    };
  },

  methods: {
    removeTodo(todo) {
      this.$store.commit("CACHE_REMOVED_TODO", todo);
      this.$store.dispatch("DELETE_TODO", todo);
    },
    checkCompleted(todo) {
      this.$store.dispatch("COMPLETE_TODO", todo);
    }
  },
  created() {
    this.ownGroup = false;
    this.ownGroup = this.todo.assigned.some(obj => obj.assigned_to == user.id);
  }
};
</script>