import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.config.productionTip = false

Vue.use(VueRouter);

import Dashboard from './components/Dashboard.vue';
import TriviaGame from './components/TriviaGame';
const routes = [
    {
        path:'/',
        component:Dashboard,
    },
    {
        path:'/trivia',
        component: TriviaGame
    },
]

const router = new VueRouter({
    mode:'history',
    routes
})

new Vue({
    router,
    render: h=>h(Dashboard)
}).$mount('#app')
