import { createRouter, createWebHistory } from 'vue-router';
import Home from './views/Home.vue';
import ConnectView from './views/Connect.vue';
import CreateUser from './views/CreateUser.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/connect',
        component: ConnectView
    },
    {
        path: '/create-account',
        component: CreateUser
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
