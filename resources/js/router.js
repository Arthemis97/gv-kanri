import useAuthStore from "@/stores/auth";
import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        name: "home",
        path: "/",
        component: () => import("./pages/home.vue"),
        meta: {
            requiresAuth: true,
            layout: 'defaultLayout'
        },
    },
    {
        name: "employee",
        path: "/employee",
        component: () => import("./pages/employee/index.vue"),
        meta: {
            requiresAuth: true,
            layout: 'defaultLayout'
        },
    },
    {
        name: "employee-add",
        path: "/employee/add",
        component: () => import("./pages/employee/form.vue"),
        meta: {
            requiresAuth: true,
            layout: 'defaultLayout'
        },
    },
    {
        name: "employee-edit",
        path: "/employee/:id",
        component: () => import("./pages/employee/form.vue"),
        meta: {
            requiresAuth: true,
            layout: 'defaultLayout'
        },
    },
    {
        name: "workers",
        path: "/workers",
        component: () => import("./pages/workers/index.vue"),
        meta: {
            requiresAuth: true,
            layout: 'defaultLayout'
        },
    },
    {
        name: "workers-add",
        path: "/workers/add",
        component: () => import("./pages/workers/form.vue"),
        meta: {
            requiresAuth: true,
            layout: 'defaultLayout'
        },
    },
    {
        name: "workers-edit",
        path: "/workers/:id",
        component: () => import("./pages/workers/form.vue"),
        meta: {
            requiresAuth: true,
            layout: 'defaultLayout'
        },
    },
    {
        name: "login",
        path: "/login",
        component: () => import("./pages/login.vue")
    },
    {
        path: "/:catchAll(.*)",
        component: () => import("./pages/404.vue"),
    },
]
const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        const authStore = useAuthStore();
        if (authStore.token) {
            next();
        } else {
            next({ name: "login" });
        }
    } else {
        next();
    }
});

export default router;
