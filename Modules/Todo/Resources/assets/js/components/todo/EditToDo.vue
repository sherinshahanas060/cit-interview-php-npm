<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit To Do</div>

                    <div class="card-body" style="display: block;">
                        
                            <div class="row">
                                <div class="form-group col-12">
                                <label for="inputName">Title</label>
                                <input type="text" v-model="toDo.title"
                                autofocus="autofocus"
                                placeholder="What are you trying to get done?" class="new-todo form-control">
                                </div>
                                <div class="form-group col-6">
                                <label for="inputDescription">Assign To User</label>
                                <multiselect
                                    v-model="toDo.assigned"
                                    tag-placeholder="Add this user"
                                    placeholder="Select User"
                                    label="name"
                                    track-by="id"
                                    class="dropdaown-select2"
                                    :options="userOptions"
                                    :multiple="true"
                                    :taggable="true"
                                    @remove="removeUser"
                                ></multiselect>
                                </div>
                                <div class="input-group col-sm-6">
                                    <label class="typo__label w-100">Status</label>
                                    <multiselect 
                                    v-model="toDo.status" 
                                    tag-placeholder="Add this as new Status" 
                                    placeholder="Search or add a Status" 
                                    label="name" 
                                    track-by="id" 
                                    class="dropdaown-select2"
                                    :options="statusOptions" 
                                    :multiple="false" 
                                    :taggable="true" 
                                    @tag="addNewStatus"></multiselect>
                                </div>
                                <div class="form-group col-12">
                                <label for="inputDescription">Description</label>
                                <textarea v-model="toDo.about" id="inputDescription" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="col">
                                <div @click="updateToDo()" class="btn" type="submit">Update</div>
                                </div>
                            </div>
                        
                        </div>
                        <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                toDo : [],
                // form : new Form({
                //     id: '',
                //     title: '',
                //     about: '',
                //     assigns: [],
                //     status: '',
                // }),
                userOptions : [],
                statusOptions : []
            }
        },
        methods: {
            removeUser(removedOption, id) {
                if (removedOption.map_id) {
                    let route = window.routes.removeToDoUser;
                    axios
                    .delete(route + removedOption.map_id)
                    .then(response => {
                        // let idx = this.form.attachments.indexOf(id)
                        if (response.data.status == 100) {
                            
                        } else {
                            toast.fire({
                                type: "warning",
                                title: "Failed"
                            });
                        }
                    })
                    .catch(() => {
                        swal.fire("Failed!", "There was something wrong.", "warning");
                    });
                }
            },
            updateToDo() {
                this.$store.dispatch("UPDATE_TODO", this.toDo);
            },
            loadToDo(id) {
                let route = window.routes.toDoShow
                axios.get(route + id)
                .then(response => {
                    if(response.data.status == 100) {
                        // this.form.fill(response.data.data)
                        this.toDo = response.data.data
                        this.toDo.assigned = response.data.data.assigned.map(function(value) {
                        let obj = {
                                id : value.user.id,
                                name : value.user.name,
                                map_id : value.id,
                            }
                            return obj;
                        });
                        this.toDo.status = {
                            id : response.data.data.to_do_status.id,
                            name : response.data.data.to_do_status.name
                        }
                        
                    }
                })
                .catch(errors => {

                })
            },
            loadUsers() {
                let route = window.routes.getUsers
                axios.get(route)
                .then(response => {
                    if(response.data.status == 100) {
                    
                    this.userOptions = response.data.data.map(function(value) {
                        let obj = {
                                id : value.id,
                                name : value.name,
                                map_id : ''
                            }
                            return obj;
                        });
                    }
                })
                .catch(errors => {
                    console.log(errors)
                })
            },
            loadStatus() {
                let route = window.routes.getStatus
                axios.get(route)
                .then(response => {
                    if(response.data.status == 100) {
                    
                    this.statusOptions = response.data.data.map(function(value) {
                        let obj = {
                                id : value.id,
                                name : value.name
                            }
                            return obj;
                        });
                    }
                })
                .catch(errors => {
                    console.log(errors)
                })
            },
            assignedUser() {
                this.toDo.assigned = this.toDo.assigned.map(function(value) {
                    let obj = {
                        id : value.user.id,
                        name : value.user.name,
                        map_id : value.id,
                    }
                    return obj;
                });
            },
            exStatus() {
                // console.log(this.toDo)
                // this.toDo.status = {
                //     id : this.toDo.to_do_status.id,
                //     name : this.toDo.to_do_status.name
                // }
            },
            addNewStatus(newTag) {
                let route = window.routes.addToDoStatus;
                    axios.post(route + '/' + newTag)
                    .then(response => {
                        if(response.data.status == 100) {
                            let newStatus = {
                                id : response.data.data.id,
                                name : newTag
                            }
                            this.toDo.status = newStatus
                            this.statusOptions.push(newStatus)
                           
                        } else {
                            toast.fire({
                                type: "warning",
                                title: "Failed"
                            });
                        }
                    })
                    .catch(() => {
                        
                    });
            }
        },
        created() {
            this.loadUsers()
            this.loadStatus()
            // this.toDo = this.$route.params.todo
            
            
            if(this.$route.params.id != 0) {
                this.loadToDo(this.$route.params.id);
            }
            // this.assignedUser()
            // this.exStatus()
        }
    }
</script>
