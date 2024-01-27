import {createRouter, createWebHistory} from "vue-router";
import {get} from "./utils/localStorage.js";

import Home from './pages/home/Home.vue'
import Login from './pages/login/Login.vue'
import Register from './pages/register/Register.vue'
import Profile from './pages/profile/Profile.vue'
import CreateUrl from './pages/url/CreateUrl.vue'

const routes = [
    {path: '/', name: 'home', component: Home, meta: {requiresAuth: true}},
    {path: '/login', name: 'login', component: Login, meta: {guest: true}},
    {path: '/register', name: 'register', component: Register, meta: {guest: true}},
    {path: '/profile', name: 'profile', component: Profile, meta: {requiresAuth: true}},
    {path: '/urls/create', name: 'urls-create', component: CreateUrl, meta: {requiresAuth: true}},
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'link-secondary'
})

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (get('token')) {
            next();
            return;
        }
        next("/login");
    } else {
        next();
    }
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.guest)) {
        if (get('token')) {
            next("/");
            return;
        }
        next();
    } else {
        next();
    }
});


export default router;

