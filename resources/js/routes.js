import { userModuleRoutes } from '../../Modules/User/Resources/assets/js/routes';
import { cmsModuleRoutes } from '../../Modules/Cms/Resources/assets/js/routes';
import { reportModuleRoutes } from '../../Modules/Report/Resources/assets/js/routes';

export const routes = [
    { path: '/admin/dashboard', component: require('./components/Dashboard.vue').default, name: 'dashboard', meta: { title: 'Dashboard' } },
    { path: '/admin/developer', component: require('./components/passport/Developer.vue').default, name: 'developer', meta: { title: 'Developer' } },
    ...userModuleRoutes, 
    ...cmsModuleRoutes,
    ...reportModuleRoutes
];



// https://stackoverflow.com/questions/57923272/how-to-use-paths-urls-routes-dynamically-in-vue-js-laravel-components
// php artisan optimize:clear