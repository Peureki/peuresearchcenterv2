import { createRouter, createWebHistory } from 'vue-router'
import HomeView from './views/HomeView.vue'

import BenchmarksMapsView from './views/benchmarks/MapsView.vue'
import BenchmarksFishingView from './views/benchmarks/FishingView.vue'

/*
 * 
 * CURRENCIES
 * 
 */

import CurrenciesLaurelView from '@/js/vue/views/currencies/LaurelView.vue'
import CurrenciesSpiritShardsView from '@/js/vue/views/currencies/SpiritShardsView.vue'
import CurrenciesTradeContractView from '@/js/vue/views/currencies/TradeContractView.vue'
import CurrenciesUnboundMagicView from '@/js/vue/views/currencies/UnboundMagicView.vue'
import CurrenciesVolatileMagicView from '@/js/vue/views/currencies/VolatileMagicView.vue'

/*
 * 
 * TOOLS
 * 
 */
import ToolsRecipeValueView from '@/js/vue/views/tools/RecipeValueView.vue'
import ToolsResearchNotesView from '@/js/vue/views/tools/ResearchNotesView.vue'
import ToolsSalvageablesView from '@/js/vue/views/tools/SalvageablesView.vue'


import TimersAuricBasinView from './views/timers/AuricBasinView.vue'
import TimersTangledDepthsView from './views/timers/TangledDepthsView.vue'
import TimersEmberBayView from './views/timers/EmberBayView.vue'
import TimersDomainOfIstanView from './views/timers/DomainOfIstanView.vue'
import TimersSandsweptIslesView from './views/timers/SandsweptIslesView.vue'
import TimersDomainOfKournaView from '@/js/vue/views/timers/DomainOfKournaView.vue'
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
    // * CORE
    {
        path: '/currencies/laurel',
        component: CurrenciesLaurelView,
        name: 'currencies-laurel',
    },
    {
        path: '/currencies/spirit-shards',
        component: CurrenciesSpiritShardsView,
        name: 'currencies-spirit-shards',
    },
    // * POF
    {
        path: '/currencies/trade-contract',
        component: CurrenciesTradeContractView,
        name: 'currencies-trade-contract',
    },
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
    // * TOOLS
    // *
    {
        path: '/tools/recipe-value',
        component: ToolsRecipeValueView,
        name: 'tools-recipe-value',
    },
    {
        path: '/tools/research-notes',
        component: ToolsResearchNotesView,
        name: 'tools-research-notes',
    },
    {
        path: '/:requestedRecipe',
        component: ToolsRecipeValueView,
        name: '/:requestedRecipe',
        props: true
    },
    {
        path: '/tools/salvageables',
        component: ToolsSalvageablesView,
        name: 'tools-salvageables',
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
    // * LS3
    {
        path: '/timers/ember-bay',
        component: TimersEmberBayView,
        name: 'timers-ember-bay',
    },
    // * LS4
    {
        path: '/timers/domain-of-istan',
        component: TimersDomainOfIstanView,
        name: 'timers-domain-of-istan',
    },
    {
        path: '/timers/sandswept-isles',
        component: TimersSandsweptIslesView,
        name: 'timers-sandswept-isles',
    },
    {
        path: '/timers/domain-of-kourna',
        component: TimersDomainOfKournaView,
        name: 'timers-domain-of-kourna',
    },
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