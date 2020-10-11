export const cmsModuleRoutes = [
    { path: '/cms/blogs', component: require('./components/Blogs.vue').default, name: 'blogs', meta: { title: 'Blogs' } },
    { path: '/cms/addoreditblog/:id', component: require('./components/AddOrEditBlog.vue').default, name: 'addOrEditBlog', meta: { title: 'Add / Edit Blog' } },
    { path: '/cms/viewblog/:id', component: require('./components/ViewBlog.vue').default, name: 'viewBlog', meta: { title: 'View Blog' } },
];

