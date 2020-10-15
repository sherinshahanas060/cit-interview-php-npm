export const todoModuleRoutes = [
    { path: '/admin/todo', component: require('./components/todo/ToDo.vue').default, name: 'todo',meta: {title: 'To-Do' } },
    { path: '/admin/newtodo', component: require('./components/todo/NewToDo.vue').default, name: 'newtodo',meta: {title: 'New To-Do' } },
    { path: '/admin/todolist', component: require('./components/todo/ToDoList.vue').default, name: 'todolist',meta: {title: 'To-Do List' } },
    { path: '/admin/todoapp', component: require('./components/todo/ToDoApp.vue').default, name: 'todoapp',meta: {title: 'To-Do App' } },
    { path: '/admin/viewtodo/:id', component: require('./components/todo/ViewToDo.vue').default, name: 'viewtodo',meta: {title: 'View To-Do' } },
    { path: '/admin/edittodo/:id', component: require('./components/todo/EditToDo.vue').default, name: 'edittodo',meta: {title: 'Edit To-Do' } },
];

