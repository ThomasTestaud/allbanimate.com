import { createRouter, createWebHistory } from 'vue-router';
import Home from './views/Home.vue';
import Gallerie from './views/Gallerie.vue';
import About from './views/About.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/gallerie',
        name: 'Gallerie',
        component: Gallerie
    },
    {
        path: '/about',
        name: 'About',
        component: About
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
