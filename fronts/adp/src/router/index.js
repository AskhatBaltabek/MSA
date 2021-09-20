import Vue from "vue"
import Router from "vue-router"
import Login from "@/views/Login"
import Home from "@/views/Home"
import Polices from "@/views/policies/Main"

import NewsIndex from "@/views/news/index"
import News from "@/views/news/Main"
import SingleNew from "@/views/news/SingleNew"

import KaskoIndex from "@/views/kasko/index"
import Kasko from "@/views/kasko/Main"
import Order from "@/views/kasko/order/Order"

import OgpoMain from "@/views/ogpo/Main"
import OgpoIndex from "@/views/ogpo/Index"
import OgpoCreate from "@/views/ogpo/Create"

import store from "../store"
import middlewarePipeline from './middleware/pipeline'
import guest from './middleware/guest'
import auth from './middleware/auth'

Vue.use(Router);

function loggedIn(to, from, next) {
    if(!store.getters.isAuthenticated) {
        return next({
            name: 'Login'
        })
    }

    return next()
}

const router = new Router({
    mode: "history",
    routes: [
        {
            path: "/login",
            name: "Login",
            component: Login,
            meta: {
                middleware: [
                    guest
                ]
            }
        },
        {
            path: "/",
            name: "Home",
            component: Home,
            meta: {
                middleware: [
                    auth
                ]
            },
        },
        {
            path: "/policies",
            name: "Policies",
            component: Polices,
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: "/news",
            component: NewsIndex,
            beforeEnter: (to, from, next) => loggedIn(to, from, next),
            children: [
                {
                    path: '',
                    name: 'News',
                    component: News,
                    middleware: [
                        auth
                    ]
                },
                {
                    path: ':id',
                    name: 'New',
                    component: SingleNew,
                    middleware: [
                        auth
                    ]
                }
            ]
        },
        {
            path: "/kasko",
            component: KaskoIndex,
            beforeEnter: (to, from, next) => loggedIn(to, from, next),
            children: [
                {
                    path: '',
                    name: "Kasko",
                    component: Kasko,

                },
                {
                    path: ':id',
                    name: 'policy',
                    component: Order,
                },
            ],
        },
        {
            path: '/ogpo',
            component: OgpoMain,
            children: [
                {
                    path: '',
                    name: 'Ogpo Index',
                    component: OgpoIndex,
                    middleware: [
                        auth
                    ]
                },
                {
                    path: 'create',
                    name: 'Ogpo Create',
                    component: OgpoCreate,
                    middleware: [
                        auth
                    ]
                },
                {
                    path: ':id',
                    name: 'Ogpo Edit',
                    component: OgpoCreate,
                    middleware: [
                        auth
                    ]
                },
            ],
        },
    ]
})
router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next()
    }
    const middleware = to.meta.middleware
    const context = {
        to,
        from,
        next,
        store
    }
    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1)
    })
})

export default router