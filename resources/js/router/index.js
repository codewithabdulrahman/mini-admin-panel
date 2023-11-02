import { createRouter, createWebHistory } from "vue-router";
import companies from "../admin-panel/company/index.vue";
import empolyees from "../admin-panel/employee/index.vue";
import dashboard from "../admin-panel/dashboard.vue";
import notFound from "../admin-panel/404.vue";
import app from "../admin-panel/app.vue";
import loginPage from "../admin-panel/auth/login.vue";
import addCompany from "../admin-panel/company/add.vue";
import editCompany from "../admin-panel/company/edit.vue";
import addEmployee from "../admin-panel/employee/add.vue";
import editEmployee from "../admin-panel/employee/edit.vue";

const routes = [
    {
        path: "/",
        component: app,
    },
    {
        path: "/signin",
        component: loginPage,
    },
    {
        path: "/companies",
        name: "companies",
        component: companies,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/addCompany",
        name: "addCompany",
        component: addCompany,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/viewCompany/:companyId",
        name: "viewCompany",
        component: editCompany,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: dashboard,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/empolyees",
        name: "empolyees",
        component: empolyees,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/addEmployee",
        name: "addEmployee",
        component: addEmployee,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/viewEmployee/:employeeId",
        name: "viewEmployee",
        component: editEmployee,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/404",
        component: notFound,
    },
    {
        path: "/:pathMatch(.*)*",
        component: notFound,
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !localStorage.getItem("token")) {
        next("/signin"); // Redirect to the login page
    } else {
        next(); // Continue with the navigation
    }
});

export default router;