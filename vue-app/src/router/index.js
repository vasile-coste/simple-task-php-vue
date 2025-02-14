import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";

Vue.use(VueRouter);

const routes = [{
        path: "/",
        name: "Home",
        component: Home
    },
    {
        path: "/auth",
        name: "Auth",
        component: () =>
            import ("../views/Auth.vue")
    },
    {
        path: "/profile",
        name: "Profile",
        component: () =>
            import ("../views/Profile.vue")
    },
    {
        path: "/new-task",
        name: "NewTask",
        component: () =>
            import ("../views/NewTask.vue")
    },
    {
        path: "/page",
        name: "Page",
        component: () =>
            import ("../views/Page.vue")
    },
    {
        path: "*",
        name: "Page404",
        component: () =>
            import ("../views/Page404.vue")
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});
router.beforeEach((to, from, next) => {
    if ((to.name !== 'Auth') && !router.app.$session.exists()) {
        next({ name: 'Auth' });
    } else {
        next();
    }
});

export default router;