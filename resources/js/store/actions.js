let actions = {
    ADD_PERMISSION({ commit }, permission) {
        axios.post('/api/todos', permission).then(res => {
            if (res.data === "added")
                console.log('ok')
        }).catch(err => {
            console.log(err)
        })
    },
    DELETE_PERMISSION({ commit }, permission) {
        axios.delete(`/api/todos/${permission.id}`)
            .then(res => {
                if (res.data === 'deleted')
                    console.log('deleted')
            }).catch(err => {
                console.log(err)
            })
    },
    GET_PERMISSIONS({ commit }) {
        let route = window.routes.getUserPermissions;
        axios.get(route)
            .then(res => {
                {
                    if (res.data.status == 100) {
                        let permissionArray = [];
                        res.data.data.forEach(result => {
                            // let name = result.name.replace(/-/g,'');
                            result.permissions.forEach(permissionResult => {
                                permissionArray.push(permissionResult.name)
                            })
                        });
                        commit('GET_PERMISSIONS', Array.from(new Set(permissionArray)))
                    }
                }
            }).catch(err => {
                console.log(err)
            })
    },
    ADD_TODO({ commit }, todo) {
        let route = window.routes.toDoStore
        axios.post(route, todo)
            .then(res => {
                //
            }).catch(err => {
                console.log(err)
            })
    },
    FORWARD_TODO({ commit }, todoForward) {
        let route = window.routes.forwardTodo
        axios.post(route, todoForward)
            .then(res => {
                if (res.data.status == 101) {
                    // console.log('forwarded')
                    // let addTodo = res.data.data
                    commit('FORWARD_TODO', addTodo)
                }
            }).catch(err => {
                console.log(err)
            })
    },
    UPDATE_TODO({ commit }, todo) {
        // console.log(todo)
        let route = window.routes.toDoUpdate
        axios.put(route + todo.id, todo).then(res => {
            if (res.data.status == 101)
                console.log('updated')
            let updatedTodo = res.data.data
            commit('UPDATE_TODO', updatedTodo)

        }).catch(err => {
            console.log(err)
        })
    },
    DELETE_TODO({ commit }, todo) {
        let route = window.routes.toDoDestroy
        axios.delete(route + todo.id)
            .then(res => {
                if (res.data.status == 101)
                    console.log('deleted')
                // commit('DELETE_TODO', todo)
            }).catch(err => {
                console.log(err)
            })
    },
    COMPLETE_TODO({ commit }, todo) {
        let route = window.routes.toDoUpdateCompleted
        axios.put(route + todo.id)
            .then(res => {
                if (res.data.status == 101);
            }).catch(err => {
                console.log(err)
            })
    },
    GET_TODOS({ commit }) {
        let route = window.routes.toDoIndex
        axios.get(route)
            .then(res => {
                {
                    commit('GET_TODOS', res.data.data)
                }
            }).catch(err => {
                console.log(err)
            })
    },
    GET_TEAMTODOS({ commit }) {
        let route = window.routes.TeamTodos

        axios.get(route)
            .then(res => {
                {
                    commit('GET_TEAMTODOS', res.data.data)
                }
            }).catch(err => {
                console.log(err)
            })
    },

    TODO_COUNT({ commit }) {
        let route = window.routes.getuserCount;
        axios
            .get(route)
            .then(res => {
                if (res.data.status == 100) {
                    commit('TODO_COUNT', res.data.data)
                }
            })
            .catch(error => {
                this.todoCount = 0;
            });
    },
    BASE_CURRENCY({ commit }) {
        commit('BASE_CURRENCY', currency)
    },
    CURRENT_CURRENCY({ commit }) {
        commit('CURRENT_CURRENCY', currency)
    },
    CURRENCY_VALUES({ commit }) {
        let route = window.routes.currencyvalues

        axios.get(route)
            .then(res => {
                {
                    commit('CURRENCY_VALUES', res.data.data)
                }
            }).catch(err => {
                console.log(err)
            })
    },

    SEARCH_TODOS({ commit }, query) {
        if (query.todoType == 1) {
            let route = window.routes.toDoIndex
            let params = {
                query
            };
            axios.get(route, { params })
                .then(res => {
                    {
                        commit('SET_TODOS', res.data.data)
                    }
                }).catch(err => {
                    console.log(err)
                })
        } else if (query.todoType == 2) {
            let route = window.routes.TeamTodos
            let params = {
                query
            };
            axios.get(route, { params })
                .then(res => {
                    {
                        commit('SET_TEAMTODOS', res.data.data)
                    }
                }).catch(err => {
                    console.log(err)
                })
        }
        else if (query.todoType == 3) {
            let route = window.routes.getTodoCompleted
            let params = {
                query
            };
            axios.get(route, { params })
                .then(res => {
                    {
                        commit('GET_COMPLETED_TODOS', res.data.data)
                    }
                }).catch(err => {
                    console.log(err)
                })
        }
    },
    GET_COMPLETED_TODOS({ commit }) {
        let route = window.routes.getTodoCompleted
        axios.get(route)
            .then(res => {
                {
                    commit('GET_COMPLETED_TODOS', res.data.data)
                }
            }).catch(err => {
                console.log(err)
            })
    },
    GET_NOTIFICATIONS({ commit }) {
        let route = window.routes.notificationsIndex
        axios.get(route)
            .then(res => {
                commit('GET_NOTIFICATIONS', res.data.data)
                commit('NOTIFICATION_COUNT', res.data.data.length)
            })
            .catch(errors => {

            })
    },
    READ_NOTIFICATION({ commit }, notification) {
        let route = window.routes.readNotification
        axios.put(route + notification.id)
            .then(res => {
                if (res.data.status == 101) {
                    commit('READ_NOTIFICATION', res.data.data)
                    commit('NOTIFICATION_COUNT', -1)
                }
            })
            .catch(errors => {

            })
    },
    READ_ALL_NOTIFICATIONS({ commit }) {
        let route = window.routes.readAllNotifications
        axios.get(route)
            .then(res => {
                if (res.data.status == 101) {
                    commit('GET_NOTIFICATIONS', [])
                    commit('NOTIFICATION_COUNT', 0)
                }
            })
            .catch(errors => {

            })
    },

}
export default actions