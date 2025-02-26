import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import NotFound from '../components/NotFound.vue';
import RedirectorView from '../views/RedirectorView.vue';

const base = '';

const routes = [
    {
        path: '/:folder/:hash',
        sensitive: true,
        name: 'redirector-with-folder',
        component: RedirectorView,
    },
    {
        path: '/:hash',
        sensitive: true,
        name: 'redirector',
        component: RedirectorView,
    },
    {
        path: '/',
        sensitive: false,
        name: 'home',
        component: HomeView,
    },
];

// create router
const router = createRouter({
    history: createWebHistory(base),
    routes,
    strict: true,
});

// add 404 page
router.addRoute({
    path: '/:pathMatch(.*)*',
    component: NotFound,
});

export default router;
