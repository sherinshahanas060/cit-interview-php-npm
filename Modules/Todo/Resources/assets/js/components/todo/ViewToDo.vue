<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">View TO Do </h3>
                        <div class="card-tools" title="Add">
                            <router-link :to="{ name: 'edittodo', params : { id : toDo.id, todo: toDo} }" class="btn btn-success">
                                Edit
                            </router-link>
                        </div>
                    </div>

                    <div class="card-body">
                        <p>Title : {{ toDo.title }}</p>
                        <p>Description : {{ toDo.about }}</p>
                        <p v-if="toDo.to_do_status">Status : {{ toDo.to_do_status.name }}</p>
                        <p>Assigned To :</p>
                        <table class="table table-bordered table-striped dataTable border">
                            <tr v-for="(user, userIndex) in toDo.assigned" :key="userIndex">
                                <td>{{ user.user.name }}</td>
                                <td>{{ user.about }}</td>
                                <td>{{ user.status }}</td>
                            </tr>
                        </table>
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
                toDoId : '',
                toDo : []
            }
        },
        methods : {
            loadToDo(id) {
                let route = window.routes.toDoView
                axios.get(route + id)
                .then(response => {
                    if(response.data.status == 100) {
                        this.toDo = response.data.data
                    }
                })
                .catch(errors => {

                })
            }
        },
        created() {
            // this.toDo = this.$route.params.todo
            if(this.$route.params.id != 0) {
                this.toDoId = this.$route.params.id
                this.loadToDo(this.$route.params.id)
            }
        },
        // mounted() {
        //     this.$store.dispatch("GET_TODOS");
        // },
        // computed: {
        //     ...mapGetters(["todos"]),
        // }

    }
</script>
