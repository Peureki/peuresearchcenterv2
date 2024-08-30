import { createRouter, createWebHistory } from 'vue-router'
import HomeView from './views/HomeView.vue'

import BenchmarksMapsView from './views/benchmarks/MapsView.vue'
import BenchmarksFishingView from './views/benchmarks/FishingView.vue'

/*
 * 
 * CURRENCIES
 * 
 */
import CurrenciesAirshipPartView from '@/js/vue/views/currencies/AirshipPartView.vue'
import CurrenciesBanditCrestView from '@/js/vue/views/currencies/BanditCrestView.vue'
import CurrenciesGeodeView  from '@/js/vue/views/currencies/GeodeView.vue'
import CurrenciesImperialFavorView from '@/js/vue/views/currencies/ImperialFavorView.vue'
import CurrenciesJadeSliverView from '@/js/vue/views/currencies/JadeSliverView.vue'
import CurrenciesLaurelView from '@/js/vue/views/currencies/LaurelView.vue'
import CurrenciesLeyLineCrystalView  from '@/js/vue/views/currencies/LeyLineCrystalView.vue'
import CurrenciesLumpOfAurilliumView from '@/js/vue/views/currencies/LumpOfAurilliumView.vue'
import CurrenciesSpiritShardsView from '@/js/vue/views/currencies/SpiritShardsView.vue'
import CurrenciesTradeContractView from '@/js/vue/views/currencies/TradeContractView.vue'
import CurrenciesTyrianDefenseSealView from '@/js/vue/views/currencies/TyrianDefenseSealView.vue'
import CurrenciesUnboundMagicView from '@/js/vue/views/currencies/UnboundMagicView.vue'
import CurrenciesVolatileMagicView from '@/js/vue/views/currencies/VolatileMagicView.vue'

/*
 * 
 * EXCHANGEABLES
 * 
 */
import ExchangeableBloodstoneDustView from '@/js/vue/views/exchangeables/BloodstoneDustView.vue'
import ExchangeablesDragoniteOreView from '@/js/vue/views/exchangeables/DragoniteOreView.vue'
import ExchangeablesEmpyrealFragmentView from '@/js/vue/views/exchangeables/EmpyrealFragmentView.vue'
import ExchangeableFineRiftEssenceView from '@/js/vue/views/exchangeables/FineRiftEssenceView.vue'
import ExchangeableMasterworkRiftEssenceView from '@/js/vue/views/exchangeables/MasterworkRiftEssenceView.vue'
import ExchangeableRareRiftEssenceView from '@/js/vue/views/exchangeables/RareRiftEssenceView.vue'
import ExchangeableWritsView from '@/js/vue/views/exchangeables/WritsView.vue'

/*
 * 
 * TOOLS
 * 
 */
import ToolsHomesteadView from '@/js/vue/views/tools/HomesteadView.vue'
import ToolsRecipeValueView from '@/js/vue/views/tools/RecipeValueView.vue'
import ToolsResearchNotesView from '@/js/vue/views/tools/ResearchNotesView.vue'
import ToolsSalvageablesView from '@/js/vue/views/tools/SalvageablesView.vue'
import ToolsChecklistView from '@/js/vue/views/tools/ChecklistView.vue'

/*
 * 
 * TIMERS
 * 
 */
import TimersAuricBasinView from './views/timers/AuricBasinView.vue'
import TimersTangledDepthsView from './views/timers/TangledDepthsView.vue'
import TimersEmberBayView from './views/timers/EmberBayView.vue'
import TimersDomainOfIstanView from './views/timers/DomainOfIstanView.vue'
import TimersSandsweptIslesView from './views/timers/SandsweptIslesView.vue'
import TimersDomainOfKournaView from '@/js/vue/views/timers/DomainOfKournaView.vue'
import TimersDragonfallView from '@/js/vue/views/timers/DragonfallView.vue'
import TimersLakeDoricView from '@/js/vue/views/timers/LakeDoricView.vue'

import TimersSkywatchArchipelagoView from '@/js/vue/views/timers/SkywatchArchipelagoView.vue'
import { compact } from 'lodash'

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
        path: '/currencies/bandit-crest',
        component: CurrenciesBanditCrestView,
        name: 'currencies-bandit-crest',
    },
    {
        path: '/currencies/geode',
        component: CurrenciesGeodeView,
        name: 'currencies-geode',
    },
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
    // * HOT
    {
        path: '/currencies/airship-part',
        component: CurrenciesAirshipPartView,
        name: 'currencies-airship-part',
    },
    {
        path: '/currencies/ley-line-crystal',
        component: CurrenciesLeyLineCrystalView,
        name: 'currencies-ley-line-crystal',
    },
    {
        path: '/currencies/lump-of-aurillium',
        component: CurrenciesLumpOfAurilliumView,
        name: 'currencies-lump-of-aurillium',
    },
    {
        path: '/currencies/trade-contract',
        component: CurrenciesTradeContractView,
        name: 'currencies-trade-contract',
    },
    {
        path: '/currencies/tyrian-defense-seal',
        component: CurrenciesTyrianDefenseSealView,
        name: 'currencies-tyrian-defense-seal',
    },
    {
        path: '/currencies/unbound-magic',
        component:  CurrenciesUnboundMagicView,
        name: 'currencies-unbound-magic',
    },
    {
        path: '/currencies/volatile-magic',
        component:  CurrenciesVolatileMagicView,
        name: 'currencies-volatile-magic',
    },
    {
        path: '/currencies/jade-sliver',
        component: CurrenciesJadeSliverView,
        name: 'currencies-jade-sliver'
    },
    {
        path: '/currencies/imperial-favor',
        component:  CurrenciesImperialFavorView,
        name: 'currencies-imperial-favor',
    },
    // *
    // * EXCHANGEABLES
    // *
    {
        path: '/exchangeables/pile-of-bloodstone-dust',
        component: ExchangeableBloodstoneDustView,
        name: 'exchangeable-pile-of-bloodstone-dust',
    },
    {
        path: '/exchangeables/dragonite-ore',
        component: ExchangeablesDragoniteOreView,
        name: 'exchangeable-dragonite-ore',
    },
    {
        path: '/exchangeables/empyreal-fragment',
        component: ExchangeablesEmpyrealFragmentView,
        name: 'exchangeable-empyreal-fragment',
    },
    {
        path: '/exchangeables/fine-rift-essence',
        component: ExchangeableFineRiftEssenceView,
        name: 'exchangeable-fine-rift-essence',
    },
    {
        path: '/exchangeables/masterwork-rift-essence',
        component: ExchangeableMasterworkRiftEssenceView,
        name: 'exchangeable-masterwork-rift-essence',
    },
    {
        path: '/exchangeables/rare-rift-essence',
        component: ExchangeableRareRiftEssenceView,
        name: 'exchangeable-rare-rift-essence',
    },
    {
        path: '/exchangeables/writs',
        component: ExchangeableWritsView,
        name: 'exchangeable-writs',
    },
    // *
    // * TOOLS
    // *
    {
        path: '/tools/homestead',
        component: ToolsHomesteadView,
        name: 'tools-homestead',
    },
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
    {
        path: '/tools/checklist',
        component: ToolsChecklistView,
        name: 'tools-checklist',
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
    {
        path: '/timers/lake-doric',
        component: TimersLakeDoricView,
        name: 'timers-lake-doric',
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