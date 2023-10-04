import { createRouter, createWebHistory } from 'vue-router'
import HomeView from './views/HomeView.vue'

import BenchmarksMapsView from './views/benchmarks/MapsView.vue'
import BenchmarksFishingView from './views/benchmarks/FishingView.vue'

import TimersAuricBasinView from './views/timers/AuricBasinView.vue'
import TimersTangledDepthsView from './views/timers/TangledDepthsView.vue'

const routes = [
    {
        path: '/',
        component: HomeView,
        name: 'home',
    },
    {
        path: '/benchmarks/maps',
        component: BenchmarksMapsView,
        name: 'benchmarks-maps',
    },
    {
        path: '/benchmarks/fishing',
        component: BenchmarksFishingView,
        name: 'benchmarks-fishing',
    },
    // *
    // * TIMERS
    // *
    {
        path: '/timers/auric-basin',
        component: TimersAuricBasinView,
        name: 'timers-auric-basin',
    },
    {
        path: '/timers/tangled-depths',
        component: TimersTangledDepthsView,
        name: 'timers-tangled-depths',
    },
]

const router = createRouter({
    history: createWebHistory('/peuresearchcenterv2/public'),
    routes,
});

export default router