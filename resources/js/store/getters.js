let getters = {
    permissions: state => {
        return state.permissions
    },
    countryOpt: state => {
        return state.countryOpt
    },
    countryAll: state => {
        return state.countryAll
    },
    newTodo: state => {
        return state.newTodo
    },
    completedTodos: state => {
        return state.completedTodos
    },
    todos: state => {
        return state.todos
    },
    teamTodos: state => {
        return state.teamTodos
    },
    todoCompletedCount: state => {
        return state.todoCompletedCount
    },
    todoCount: state => {
        return state.todoCount
    },
    baseCurrency: state => {
        return state.baseCurrency
    },
    currentCurrency: state => {
        return state.currentCurrency
    },
    currencyValues: state => {
        return state.currencyValues
    },
    toRemoveToDo: state => {
        return state.toRemoveToDo
    },
    completeTodo: state => {
        return state.completeTodo
    },
    notifications: state => {
        return state.notifications
    },
    notificationCount: state => {
        return state.notificationCount
    },
    readNotificatio: state => {
        return state.readNotification
    },
    showSidePage: state => {
        return state.showSidePage
    }
}
export default getters