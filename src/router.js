import { createRouter, createWebHistory } from 'vue-router';
import Project from './views/Project.vue';
import ConnectView from './views/Connect.vue';
import CreateUser from './views/CreateUser.vue';
import MyProjects from './views/MyProjects.vue';

const routes = [
    {
        path: '/project/:name',
        name: 'Project',
        component: Project
    },
    {
        path: '/my-projects',
        component: MyProjects
    },
    {
        path: '/connect',
        component: ConnectView
    },
    {
        path: '/create-account',
        component: CreateUser
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
