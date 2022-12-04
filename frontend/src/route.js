import { createRouter, createWebHistory } from "vue-router"
import AuthLayout from '@layouts/Auth.vue'
import GuestLayout from '@layouts/Guest.vue'
import ErrorLayout from '@layouts/Error.vue'

import Login from '@components/Pages/Login.vue'
import Register from '@components/Pages/Register.vue'
import Password from '@components/Pages/Password.vue'
import Dashboard from '@components/Pages/Dashboard.vue'
import Parcelle from '@components/Pages/Parcelle.vue'
import Proprietaire from '@components/Pages/Proprietaire.vue'
import Agent from '@components/Pages/Agent.vue'
import Profile from '@components/Pages/Profile.vue'
import Village from '@components/Pages/Village.vue'
import Error404 from '@components/Pages/Error404.vue'

const baseURL = '/'

const routes = [
    {
        path: '/',
        name: 'Auth',
        component: AuthLayout,
        redirect: { name: 'Dashboard' },
        children: [
            {
                path: 'dashboard',
                name: 'Dashboard',
                component: Dashboard,
            },
            {
                path: 'parcelle',
                name: 'Parcelle',
                component: Parcelle,
            },
            {
                path: 'proprietaire',
                name: 'Proprietaire',
                component: Proprietaire,
            },
            {
                path: 'village',
                name: 'Village',
                component: Village,
            },
            {
                path: 'agent',
                name: 'Agent',
                component: Agent,
            },
            {
                path: 'profile',
                name: 'Profile',
                component: Profile,
            },
        ]
    },
    {
        path: '/',
        name: 'Guest',
        component: GuestLayout,
        redirect: { name: 'Login' },
        children: [
            {
                path: 'login',
                name: 'Login',
                component: Login,
            },
            {
                path: 'register',
                name: 'Register',
                component: Register,
            },
            {
                path: 'password',
                name: 'Password',
                component: Password,
            },
        ]
    },
    {
        path: '/',
        name: 'Error',
        component: ErrorLayout,
        children: [
            {
                path: '404',
                name: 'Error404',
                component: Error404,
            },
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        beforeEnter: (to, from, next) => {
            next({ name: 'Error404' })
        }
    }
]

const router = createRouter({
    history: createWebHistory(baseURL),
    routes: routes
})

export default router
