import { createRouter, createWebHistory } from 'vue-router'


import HomeView from './views/HomeView.vue'
import ResetPasswordView from '@/js/vue/views/ResetPasswordView.vue'

import BenchmarksMapsView from './views/benchmarks/MapsView.vue'
import BenchmarksFishingView from './views/benchmarks/FishingView.vue'
import BenchmarksGlyphsView from '@/js/vue/views/benchmarks/GlyphsView.vue'
import BenchmarksNodesView from '@/js/vue/views/benchmarks/NodesView.vue'
import BenchmarksNodeFarmsView from '@/js/vue/views/benchmarks/NodeFarmsView.vue'
import BenchmarksSoloView from '@/js/vue/views/benchmarks/SoloView.vue'
/*
 * 
 * CURRENCIES
 * 
 */
import CurrenciesAirshipPartView from '@/js/vue/views/currencies/AirshipPartView.vue'
import CurrenciesBanditCrestView from '@/js/vue/views/currencies/BanditCrestView.vue'
import CurrenciesCalcifiedGaspView from '@/js/vue/views/currencies/CalcifiedGaspView.vue'
import CurrenciesGeodeView  from '@/js/vue/views/currencies/GeodeView.vue'
import CurrenciesImperialFavorView from '@/js/vue/views/currencies/ImperialFavorView.vue'
import CurrenciesJadeSliverView from '@/js/vue/views/currencies/JadeSliverView.vue'
import CurrenciesLaurelView from '@/js/vue/views/currencies/LaurelView.vue'
import CurrenciesLeyLineCrystalView  from '@/js/vue/views/currencies/LeyLineCrystalView.vue'
import CurrenciesLumpOfAurilliumView from '@/js/vue/views/currencies/LumpOfAurilliumView.vue'
import CurrenciesPinchOfStardustView from '@/js/vue/views/currencies/PinchOfStardustView.vue'
import CurrenciesResearchNoteView from '@/js/vue/views/currencies/ResearchNoteView.vue'
import CurrenciesSpiritShardsView from '@/js/vue/views/currencies/SpiritShardsView.vue'
import CurrenciesStaticChargeView from '@/js/vue/views/currencies/StaticChargeView.vue'
import CurrenciesTradeContractView from '@/js/vue/views/currencies/TradeContractView.vue'
import CurrenciesTyrianDefenseSealView from '@/js/vue/views/currencies/TyrianDefenseSealView.vue'
import CurrenciesUnboundMagicView from '@/js/vue/views/currencies/UnboundMagicView.vue'
import CurrenciesUrsusObligeView from '@/js/vue/views/currencies/UrsusObligeView.vue'
import CurrenciesVolatileMagicView from '@/js/vue/views/currencies/VolatileMagicView.vue'

/*
 * 
 * EXCHANGEABLES
 * 
 */
import ExchangeablesCuriousLowlandHoneycombView from '@/js/vue/views/exchangeables/CuriousLowlandHoneycombView.vue'
import ExchangeablesCuriousMursaatCurrencyView from '@/js/vue/views/exchangeables/CuriousMursaatCurrencyView.vue'
import ExchangeablesDragoniteOreView from '@/js/vue/views/exchangeables/DragoniteOreView.vue'
import ExchangeablesEmpyrealFragmentView from '@/js/vue/views/exchangeables/EmpyrealFragmentView.vue'
import ExchangeableFineRiftEssenceView from '@/js/vue/views/exchangeables/FineRiftEssenceView.vue'
import ExchangeableMasterworkRiftEssenceView from '@/js/vue/views/exchangeables/MasterworkRiftEssenceView.vue'
import ExchangeablePileOfBloodstoneDustView from '@/js/vue/views/exchangeables/PileOfBloodstoneDustView.vue'
import ExchangeableRareRiftEssenceView from '@/js/vue/views/exchangeables/RareRiftEssenceView.vue'
import ExchangeableWritOfDragonsEndView from '@/js/vue/views/exchangeables/WritOfDragonsEndView.vue'
import ExchangeableWritOfEchovaldWildsView from '@/js/vue/views/exchangeables/WritOfEchovaldWildsView.vue'
import ExchangeableWritOfNewKainengCityView from '@/js/vue/views/exchangeables/WritOfNewKainengCityView.vue'
import ExchangeableWritOfSeitungProvinceView from '@/js/vue/views/exchangeables/WritOfSeitungProvinceView.vue'
import ExchangeableWritsView from '@/js/vue/views/exchangeables/WritsView.vue'

/*
 * 
 * TOOLS
 * 
 */
import ToolsAscendedTrinketsView from '@/js/vue/views/tools/AscendedTrinketsView.vue'
import ToolsDrizzlewoodCommendationsView from '@/js/vue/views/tools/DrizzlewoodCommendationsView.vue'
import ToolsHomesteadView from '@/js/vue/views/tools/HomesteadView.vue'
import ToolsRecipeValueView from '@/js/vue/views/tools/RecipeValueView.vue'
import ToolsSalvageablesView from '@/js/vue/views/tools/SalvageablesView.vue'
import ToolsChecklistView from '@/js/vue/views/tools/ChecklistView.vue'

/*
 * 
 * PERSONAL TOOLS
 * 
 */
import ToolsGatheringTrackerView from '@/js/vue/views/tools/GatheringTrackerView.vue'

/*
 * 
 * TIMERS
 * 
 */
import TimersAuricBasinView from './views/timers/AuricBasinView.vue'


import TimersDomainOfIstanView from './views/timers/DomainOfIstanView.vue'
import TimersSandsweptIslesView from './views/timers/SandsweptIslesView.vue'
import TimersDomainOfKournaView from '@/js/vue/views/timers/DomainOfKournaView.vue'
import TimersDragonfallView from '@/js/vue/views/timers/DragonfallView.vue'
import TimersEmberBayView from './views/timers/EmberBayView.vue'
import TimersJahaiBluffsView from './views/timers/JahaiBluffsView.vue'
import TimersJanthirSyntri from '@/js/vue/views/timers/JanthirSyntriView.vue'
import TimersLakeDoricView from '@/js/vue/views/timers/LakeDoricView.vue'
import TimersLowlandShoreView from '@/js/vue/views/timers/LowlandShoreView.vue'
import TimersSkywatchArchipelagoView from '@/js/vue/views/timers/SkywatchArchipelagoView.vue'
import TimersTangledDepthsView from './views/timers/TangledDepthsView.vue'

import GeneralAboutView from '@/js/vue/views/general/AboutView.vue'
import PrivacyPolicyView from '@/js/vue/views/PrivacyPolicyView.vue'
import GeneralSupportView from '@/js/vue/views/general/SupportView.vue'

const routes = [
    {
        path: '/',
        component: HomeView,
        name: 'home',
    },
    {
        path: '/reset-password/:token',
        component: ResetPasswordView,
        name: 'reset-password',
        props: route => ({token: route.params.token, email: route.query.email})  
    },
    {
        path: '/privacy-policy',
        component: PrivacyPolicyView,
        name: 'privacy-policy',
    },
    // *
    // * BENCHMARKS
    // *
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
    {
        path: '/benchmarks/glyphs',
        component: BenchmarksGlyphsView,
        name: 'benchmarks-glyphs',
    },
    {
        path: '/benchmarks/nodes',
        component: BenchmarksNodesView,
        name: 'benchmarks-nodes',
    },
    {
        path: '/benchmarks/node-farms',
        component: BenchmarksNodeFarmsView,
        name: 'benchmarks-node-farms',
    },
    {
        path: '/benchmarks/solo',
        component: BenchmarksSoloView,
        name: 'benchmarks-solo',
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
        path: '/currencies/calcified-gasp',
        component: CurrenciesCalcifiedGaspView,
        name: 'currencies-calcified-gasp',
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
        path: '/currencies/pinch-of-stardust',
        component: CurrenciesPinchOfStardustView,
        name: 'currencies-pinch-of-stardust',
    },
    {
        path: '/currencies/research-note',
        component: CurrenciesResearchNoteView,
        name: 'currencies-research-note',
    },
    {
        path: '/currencies/static-charge',
        component: CurrenciesStaticChargeView,
        name: 'currencies-static-charge',
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
        path: '/currencies/ursus-oblige',
        component:  CurrenciesUrsusObligeView,
        name: 'currencies-ursus-oblige',
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
        path: '/exchangeables/curious-lowland-honeycomb',
        component: ExchangeablesCuriousLowlandHoneycombView,
        name: 'exchangeable-curious-lowland-honeycomb',
    },
    {
        path: '/exchangeables/curious-mursaat-currency',
        component: ExchangeablesCuriousMursaatCurrencyView,
        name: 'exchangeable-curious-mursaat-currency',
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
        path: '/exchangeables/pile-of-bloodstone-dust',
        component: ExchangeablePileOfBloodstoneDustView,
        name: 'exchangeable-pile-of-bloodstone-dust',
    },
    
    {
        path: '/exchangeables/rare-rift-essence',
        component: ExchangeableRareRiftEssenceView,
        name: 'exchangeable-rare-rift-essence',
    },
    
    {
        path: '/exchangeables/writ-of-dragons-end',
        component: ExchangeableWritOfDragonsEndView,
        name: 'exchangeable-writ-of-dragons-end',
    },
    {
        path: '/exchangeables/writ-of-echovald-wilds',
        component: ExchangeableWritOfEchovaldWildsView,
        name: 'exchangeable-writ-of-echovald-wilds',
    },
    {
        path: '/exchangeables/writ-of-new-kaineng-city',
        component: ExchangeableWritOfNewKainengCityView,
        name: 'exchangeable-writ-of-new-kaineng-city',
    },
    {
        path: '/exchangeables/writ-of-seitung-province',
        component: ExchangeableWritOfSeitungProvinceView,
        name: 'exchangeable-writ-of-seitung-province',
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
        path: '/tools/ascended-trinkets',
        component: ToolsAscendedTrinketsView,
        name: 'tools-ascended-trinkets',
    },
    {
        path: '/tools/drizzlewood-commendations',
        component: ToolsDrizzlewoodCommendationsView,
        name: 'tools-drizzlewood-commendations',
    },
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
    // * PERSONAL TOOLS
    // *
    {
        path: '/tools/gathering-tracker',
        component: ToolsGatheringTrackerView,
        name: 'tools-gathering-tracker'
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
        path: '/timers/jahai-bluffs',
        component: TimersJahaiBluffsView,
        name: 'timers-jahai-bluffs',
    },
    {
        path: '/timers/janthir-syntri',
        component: TimersJanthirSyntri,
        name: 'timers-janthir-syntri',
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
    {
        path: '/timers/lowland-shore',
        component: TimersLowlandShoreView,
        name: 'timers-lowland-shore',
    },
    // SOTO
    {
        path: '/timers/skywatch-archipelago',
        component: TimersSkywatchArchipelagoView,
        name: 'timers-skywatch-archipelago',
    },
    // *
    // * GENERAL
    // *
    {
        path: '/general/about',
        component: GeneralAboutView,
        name: 'general-about',
    },
    {
        path: '/general/support',
        component: GeneralSupportView,
        name: 'general-support',
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router