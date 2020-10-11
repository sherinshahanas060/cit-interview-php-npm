let mutations = {
    ADD_PERMISSION(state, permission) {
        state.permissions.unshift(permission)
    },
    GET_PERMISSIONS(state, permissions) {
        state.permissions = permissions
    },
    DELETE_PERMISSION(state, permission) {
        state.permissions.splice(state.permissions.indexOf(permission), 1)
        state.toRemovePermission = null;
    },
    ADD_TODO(state, todo) {
        // console.log('Added')
        if (todo.type == 1) {
            state.todos[todo.priority_id].unshift(todo)
        } else {
            state.teamTodos[todo.priority_id].unshift(todo)
            if (todo.assigned.some(obj => obj.assigned_to == user.id)) {
                state.todos[todo.priority_id].unshift(todo);
            }
        }
    },
    FORWARD_TODO(state, todo) {

        if (todo.type == 1) {
            let index = state.todos.findIndex(obj => obj.id === todo.id)

            if (index > 0 || index == 0) {
                state.todos.splice(index, 1)
                state.todos.unshift(todo)
            }
        } else {
            let index = state.teamTodos.findIndex(obj => obj.id === todo.id)

            if (index > 0 || index == 0) {
                state.teamTodos.splice(index, 1)
                state.teamTodos.unshift(todo)
            }
        }
    },
    CACHE_REMOVED_TODO(state, todo) {
        state.toRemoveToDo = todo;
    },
    GET_TODOS(state, todos) {
        state.todos = todos
    },
    GET_TEAMTODOS(state, teamTodos) {
        state.teamTodos = teamTodos
    },
    SET_TEAMTODOS(state, teamTodos) {
        state.teamTodos = teamTodos
    },
    SET_TODOS(state, todos) {
        state.todos = todos
    },
    GET_COMPLETED_TODOS(state, completedTodos) {
        state.completedTodos = completedTodos
    },
    TODO_COUNT(state, count) {
        state.todoCount = count
    },
    BASE_CURRENCY(state, baseCurrency) {
        state.baseCurrency = baseCurrency
    },
    CURRENT_CURRENCY(state, currentCurrency) {
        state.currentCurrency = currentCurrency
    },
    CURRENCY_VALUES(state, currencyValues) {
        state.currencyValues = currencyValues
    },
    TODO_COMPLETED_COUNT(state, count) {
        state.todoCompletedCount = count
    },
    DELETE_TODO(state, todo) {
        if (todo.type == 1) {
            let indexTodo = state.todos[todo.priority_id].map(item => item.id).indexOf(todo.id);
            state.todos[todo.priority_id].splice(indexTodo, 1);
            state.toRemoveToDo = null;
        } else {
            let indexTodo = state.teamTodos[todo.priority_id].map(item => item.id).indexOf(todo.id);
            state.teamTodos[todo.priority_id].splice(indexTodo, 1)
            if (todo.assigned.some(obj => obj.assigned_to == user.id)) {
                let indexTodo = state.todos[todo.priority_id].map(item => item.id).indexOf(todo.id);
                state.todos[todo.priority_id].splice(indexTodo, 1);
            }
            state.toRemoveToDo = null;
        }
    },
    COMPLETE_TODO(state, todo) {
        if (todo.type == 1) {
            let indexTodo = state.todos[todo.priority_id].map(item => item.id).indexOf(todo.id);
            state.todos[todo.priority_id].splice(indexTodo, 1);
            state.toRemoveToDo = null;
        } else {
            
            let indexTodo = state.teamTodos[todo.priority_id].map(item => item.id).indexOf(todo.id);
            state.teamTodos[todo.priority_id].splice(indexTodo, 1)
            if (todo.assigned.some(obj => obj.assigned_to == user.id)) {
                let indexTodo = state.todos[todo.priority_id].map(item => item.id).indexOf(todo.id);
                state.todos[todo.priority_id].splice(indexTodo, 1);
            }
           
            state.toRemoveToDo = null;
        }
    },
    UPDATE_TODO(state, todo) {
        let toUpdate = state.todos.findIndex(updateTodo =>
            updateTodo.id == todo.id
        )
        state.todos[toUpdate] = todo
        state.toRemoveToDo = null;
    },
    GET_NOTIFICATIONS(state, notifications) {
        state.notifications = notifications
    },
    NOTIFICATION_COUNT(state, notificationCount) {
        if(notificationCount != -1) {
            state.notificationCount = notificationCount
        } else {
            state.notificationCount = state.notificationCount - 1
        }
        
    },
    READ_NOTIFICATION(state, notifyId) {
        let readNotificationIndex = _.findIndex(state.notifications, {
            id: notifyId
        });
        if (readNotificationIndex >= 0) {
            state.notifications.splice(readNotificationIndex, 1)
        }
    },
    ADD_NOTIFICATION(state, notify) {
        state.notifications.unshift(notify)
    },
    NOTIFICATION_COUNT_INC(state, increment) {
        state.notificationCount++
    },
    SHOW_SIDE_PAGE(state, boolean) {
        state.showSidePage = boolean
    },
}
export default mutations