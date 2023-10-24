import { createRouter, createWebHistory } from 'vue-router'
import HomeView from './views/HomeView.vue'

import BenchmarksMapsView from './views/benchmarks/MapsView.vue'
import BenchmarksFishingView from './views/benchmarks/FishingView.vue'

import CurrenciesUnboundMagicView from '@/js/vue/views/currencies/UnboundMagicView.vue'
import CurrenciesVolatileMagicView from '@/js/vue/views/currencies/VolatileMagicView.vue'

import TimersAuricBasinView from './views/timers/AuricBasinView.vue'
import TimersTangledDepthsView from './views/timers/TangledDepthsView.vue'
import TimersDragonfallView from '@/js/vue/views/timers/DragonfallView.vue'

import TimersSkywatchArchipelagoView from '@/js/vue/views/timers/SkywatchArchipelagoView.vue'

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
    // * CURRENCIES
    // *
    // * LS3
    {
        path: '/currencies/unbound-magic',
        component:  CurrenciesUnboundMagicView,
        name: 'currencies-unbound-magic',
    },
    // * LS4
    {
        path: '/currencies/volatile-magic',
        component:  CurrenciesVolatileMagicView,
        name: 'currencies-volatile-magic',
    },
    // *
    // * TIMERS
    // *
    // * HOT
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
    // LS4
    {
        path: '/timers/dragonfall',
        component: TimersDragonfallView,
        name: 'timers-dragonfall',
    },
    // SOTO
    {
        path: '/timers/skywatch-archipelago',
        component: TimersSkywatchArchipelagoView,
        name: 'timers-skywatch-archipelago',
    },
]

const router = createRouter({
    history: createWebHistory('/peuresearchcenterv2/public'),
    routes,
});

export default router