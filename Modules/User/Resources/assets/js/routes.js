export const userModuleRoutes = [
    { path: '/user/permissions', component: require('./components/permissions/Permissions.vue').default, name: 'permissions', meta: { title: 'Permissions' } },
    { path: '/user/users', component: require('./components/Users.vue').default, name: 'users', meta: { title: 'Users' } },
    { path: '/user/addoredituser/:id', component: require('./components/AddOrEditUser.vue').default, name: 'addOrEditUser', meta: { title: 'Add User' } },
    { path: '/user/viewuser/:id', component: require('./components/ViewUser.vue').default, name: 'viewUser', meta: { title: 'View User' } },
    { path: '/user/myprofile/:id', component: require('./components/MyProfile.vue').default, name: 'myProfile', meta: { title: 'My Profile' } },
    { path: '/user/editmyprofile/:id', component: require('./components/EditMyProfile.vue').default, name: 'editMyProfile', meta: { title: 'Edit My Profile' } },
    { path: '/user/webusers', component: require('./components/web/Users.vue').default, name: 'webUsers', meta: { title: 'Users' } },
];