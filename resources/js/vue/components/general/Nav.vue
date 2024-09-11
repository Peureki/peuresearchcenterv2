<template>
    <Transition :name="isMobile ? 'fade-down' : ''">
        <nav class="main-nav" v-if="mainNavToggle">
            <div class="nav-container">
                <div class="top" v-if="!isMobile">
                    <router-link class="page-link" to="/">
                        <div class="logo-container">
                            <img src="@/imgs/choyas/Peu_Choya.png" alt="Logo of Peu Research Center" title="Logo of Peu Research Center of a green pinata choya wearing a commander tag">
                        </div>
                    </router-link>

                    <!-- <div class="credits">
                        <p>Created by: Peureki.3647</p>
                    </div> -->

                    
                </div>

                <div class="support">
                    <button class="support-button">
                        <img class="rolling-choya" :src="RollingChoya" alt="Rolling Choya" title="Rolling Choya">
                        <p>Support the choyas</p>
                        <img class="rolling-choya" :src="RollingChoya" alt="Rolling Choya" title="Rolling Choya">
                        <p>Support the choyas</p>
                        <img class="rolling-choya" :src="RollingChoya" alt="Rolling Choya" title="Rolling Choya">
                        <p>Support the choyas</p>
                        <img class="rolling-choya" :src="RollingChoya" alt="Rolling Choya" title="Rolling Choya">
                        <p>Support the choyas</p>
                        <img class="rolling-choya" :src="RollingChoya" alt="Rolling Choya" title="Rolling Choya">
                        <p>Support the choyas</p>
                        <img class="rolling-choya" :src="RollingChoya" alt="Rolling Choya" title="Rolling Choya">
                        <p>Support the choyas</p>
                        <img class="rolling-choya" :src="RollingChoya" alt="Rolling Choya" title="Rolling Choya">
                        <p>Support the choyas</p>
                        <img class="rolling-choya" :src="RollingChoya" alt="Rolling Choya" title="Rolling Choya">
                    </button>
                </div>

                <!-- 
                    * SHORTCUTS
                    *
                    * Settings | Dark/Light mode | Nav | Discord | Other
                -->

                <Shortcuts
                    :settings-toggle="settingsToggle"
                    :bookmarks-toggle="bookmarksToggle"
                    :filters-toggle="filtersToggle"
                    :login-toggle="loginToggle"
                    :api-key-toggle="apiKeyToggle"
                    @change-toggle-status="changeToggleStatus"
                />

                <div class="auth-welcome" v-if="user">
                    <p>Herro {{ user.name }}</p>
                </div>

                <!-- 
                    *
                    * LOGIN CONTAINER
                    * Users will be able to login or logout 
                    * Username
                    * Email
                    * Password
                -->

                <Transition name="fade-right">
                    <div class="form-container" v-if="loginToggle">
                        <form @submit.prevent="login">
                            

                            <label for="name">Username</label>
                            <input type="text" name="name" id="name" v-model="name">

                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" v-model="password">

                            <label v-if="registerToggle" for="email">Email</label>
                            <input v-if="registerToggle" type="email" name="email" id="email" v-model="email">

                            <span class="remember-container">
                                <label for="remember">Remember Me</label>
                                <input type="checkbox" name="remember" v-model="remember">
                            </span>
                            

                            <div class="form-button-container">
                                <button type="submit" v-if="!user">Login</button>
                                
                                <button v-if="user" type="button" @click="logout">Logout</button>

                                <button v-if="!registerToggle" type="button" @click="registerToggle = !registerToggle">I want to be a choya</button>

                                <button v-if="registerToggle" type="button" @click="register">Register</button>
                            </div>
                        </form>
                    </div>
                </Transition>
                <!--
                    *
                    * ENTER API KEY CONTAINER
                    *
                -->
                <Transition name="fade-right">
                    <div class="form-container"  v-if="apiKeyToggle">
                        <form @submit.prevent="enterAPIKey">
                            <label for="apiKey">Enter API Key</label>
                            <input type="text" name="apiKey" v-model="apiKey">

                            <button type="submit">Submit</button>
                        </form>

                        <button v-if="user" @click="getWizardsVault(user.api_key)">Test API Key</button>
                    </div>
                </Transition>

                <!-- 
                    *
                    * TYRIAN AND CANTHAN DAY/NIGHT CYCLE
                    *
                -->
                <DayAndNightTimers/>
                <!--
                    * SLOT - TIMERS
                    * 
                    * This changes depending on what timer page the website is currently on
                -->
                <slot name="timer"></slot>

                <!--
                    * 
                    * SETTINGS / OPTIONS
                    *
                -->
                <Transition name="fade-right">
                    <div v-if="settingsToggle">
                        <article class="shortcut-container">
                            <h3>Settings</h3>
                            <div class="settings-button-container">
                                <!-- 
                                    * SETTING BUTTONS
                                    *
                                    * BUY ORDER
                                    * Change the properties of the button depending on the buy/sell order settings
                                -->
                                <p>Buy Order </p>
                                    <div class="settings-button">
                                    <button
                                        @click="changeOrder('buy order')"
                                        :class="buyOrder == 'buy_price' ? 'active-button' : 'inactive-button'"
                                    >
                                        Buy Price
                                    </button>
                                    <button
                                        @click="changeOrder('buy order')"
                                        :class="buyOrder == 'sell_price' ? 'active-button' : 'inactive-button'"
                                    >
                                        Sell Price
                                    </button>
                                </div>
                            </div>

                            <div class="settings-button-container">
                                <!-- 
                                    * SETTING BUTTONS
                                    *
                                    * SELL ORDER
                                    * Change the properties of the button depending on the buy/sell order settings
                                -->
                                <p>Sell Order </p>
                                    <div class="settings-button">
                                        <button
                                        @click="changeOrder('sell order')"
                                        :class="sellOrder == 'buy_price' ? 'active-button' : 'inactive-button'"
                                    >
                                        Buy Price
                                    </button>
                                    <button
                                        @click="changeOrder('sell order')"
                                        :class="sellOrder == 'sell_price' ? 'active-button' : 'inactive-button'"
                                    >
                                        Sell Price
                                    </button>
                                </div>
                            </div>
                            <!-- 
                                * 
                                * TAX SETTINGS
                                *
                            -->
                            <div class="settings-button-container">
                                <label for="tax">Tax</label>
                                <span class="settings-tax-input">
                                    <input type="number" step="0.01" id="tax" name="tax" v-model="tax">
                                    <span class="settings-tax-model">
                                        <svg 
                                            :style="{transform: `rotate(${tax < 1 ? 90 : -90}deg)`}"
                                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path 
                                                :fill="tax < 1 ? 'var(--color-down)' : 'var(--color-up)'"
                                                d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z"
                                            />
                                        </svg>
                                        <p>{{ convertTaxToPercent(tax) }}</p>
                                    </span>
                                </span>
                            </div>

                            <!-- 
                                * 
                                * INCLUDE SETTINGS
                                *
                            -->
                            <div class="settings-button-container">
                                <h4>Include</h4>
                                <!-- 
                                    * 
                                    * INCLUDE AIRSHIP PARTS
                                    * 
                                -->
                                <IncludesCheckbox
                                    name="Airship Part"
                                    :icon="AirshipParts"
                                    label="AirshipPart"
                                />

                                <IncludesCheckbox
                                    name="Calcified Gasp"
                                    :icon="CalcifiedGasp"
                                    label="CalcifiedGasp"
                                />

                                <IncludesCheckbox
                                    name="Dragonite Ore"
                                    :icon="DragoniteOre"
                                    label="DragoniteOre"
                                />

                                <IncludesCheckbox
                                    name="Empyreal Fragment"
                                    :icon="EmpyrealFragment"
                                    label="EmpyrealFragment"
                                />

                                <IncludesCheckbox
                                    name="Fine Rift Essence"
                                    :icon="FineRiftEssence"
                                    label="FineRiftEssence"
                                />

                                <IncludesCheckbox
                                    name="Imperial Favor"
                                    :icon="ImperialFavor"
                                    label="ImperialFavor"
                                />

                                <IncludesCheckbox
                                    name="Ley Line Crystal"
                                    :icon="LeyLineCrystal"
                                    label="LeyLineCrystal"
                                />

                                <IncludesCheckbox
                                    name="Lump of Aurillium"
                                    :icon="LumpOfAurillium"
                                    label="LumpOfAurillium"
                                />

                                <IncludesCheckbox
                                    name="Masterwork Rift Essence"
                                    :icon="MasterworkRiftEssence"
                                    label="MasterworkRiftEssence"
                                />

                                <IncludesCheckbox
                                    name="Pile of Bloodstone Dust"
                                    :icon="PileOfBloodstoneDust"
                                    label="PileOfBloodstoneDust"
                                />

                                <IncludesCheckbox
                                    name="Pinch of Stardust"
                                    :icon="PinchOfStardust"
                                    label="PinchOfStardust"
                                />

                                <IncludesCheckbox
                                    name="Rare Rift Essence"
                                    :icon="RareRiftEssence"
                                    label="RareRiftEssence"
                                />

                                <IncludesCheckbox
                                    name="Salvageables"
                                    :icon="UnidentifiedGear"
                                    label="Salvageables"
                                />

                                <IncludesCheckbox
                                    name="Static Charge"
                                    :icon="StaticCharge"
                                    label="StaticCharge"
                                />

                                <IncludesCheckbox
                                    name="Trade Contract"
                                    :icon="TradeContract"
                                    label="TradeContract"
                                />

                                <IncludesCheckbox
                                    name="Tyrian Defense Seal"
                                    :icon="TyrianDefenseSeal"
                                    label="TyrianDefenseSeal"
                                />

                                <IncludesCheckbox
                                    name="Unbound Magic"
                                    :icon="UnboundMagic"
                                    label="UnboundMagic"
                                />

                                <IncludesCheckbox
                                    name="Volatile Magic"
                                    :icon="VolatileMagic"
                                    label="VolatileMagic"
                                />                      
                            </div>

                            <div class="settings-button-container">
                                <button @click="saveSettings()">Save</button>

                                <button 
                                    @click="handlePageRefresh()"    
                                    class="submit"
                                >
                                    Refresh
                                </button>
                            </div>
                            
                        </article>
                    </div>
                </Transition>

                <!--
                    * SLOT - FILTERS
                    * 
                    * This changes depending on what page the website is currently on
                -->
                <Transition name="fade-right">
                    <slot 
                        v-if="filtersToggle"
                        name="filters"
                    ></slot>
                </Transition>

                <!--
                    * SLOT - BOOKMARKS
                    * 
                    * This changes depending on what page the website is currently on
                -->
                <Transition name="fade-right">
                    <slot 
                        v-if="bookmarksToggle"
                        name="bookmarks"
                    ></slot>
                </Transition>

                

                <!--
                    *
                    * BENCHMARKS
                    *
                -->

                <NavSection 
                    @click="benchmarksToggle = !benchmarksToggle" 
                    header="Benchmarks" 
                    :toggle="benchmarksToggle"
                />

                <Transition name="fade-right">
                    <div v-if="benchmarksToggle">
                        <NavPage category="benchmarks" url="maps" name="Maps" :icon="BlueCommander"/>
                        <NavPage category='benchmarks' url="fishing" name="Fishing" :icon="FishingHook"/>
                    </div>
                </Transition>

                <!--
                    *
                    * CURRENCIES
                    *
                -->
                <NavSection 
                    @click="currenciesToggle = !currenciesToggle" 
                    header="Currencies" 
                    :toggle="currenciesToggle"
                />

                <Transition name="fade-right">
                    <div v-if="currenciesToggle">
                        <NavPage category="currencies" url="airship-part" name="Airship Parts" :icon="AirshipParts"/>

                        <NavPage category="currencies" url="bandit-crest" name="Bandit Crests" :icon="BanditCrest"/>

                        <NavPage category="currencies" url="geode" name="Geodes" :icon="Geode"/>

                        <NavPage category="currencies" url="imperial-favor" name="Imperial Favors" :icon="ImperialFavor"/>

                        <NavPage category="currencies" url="jade-sliver" name="Jade Slivers" :icon="JadeSliver"/>
                        <NavPage category="currencies" url="laurel" name="Laurels" :icon="Laurel"/>

                        <NavPage category="currencies" url="ley-line-crystal" name="Ley Line Crystals" :icon="LeyLineCrystal"/>

                        <NavPage category="currencies" url="lump-of-aurillium" name="Lump of Aurillium" :icon="LumpOfAurillium"/>

                        <NavPage category="currencies" url="research-note" name="Research Notes" :icon="ResearchNote"/>

                        <NavPage category="currencies" url="spirit-shards" name="Spirit Shards" :icon="SpiritShard"/>

                        <NavPage category="currencies" url="trade-contract" name="Trade Contracts" :icon="TradeContract"/>

                        <NavPage category="currencies" url="tyrian-defense-seal" name="Tyrian Defense Seal" :icon="TyrianDefenseSeal"/>

                        <NavPage category="currencies" url="unbound-magic" name="Unbound Magic" :icon="UnboundMagic"/>

                        <NavPage category="currencies" url="volatile-magic" name="Volatile Magic" :icon="VolatileMagic"/>
                    </div>
                </Transition>

                <!--
                    *
                    * EXCHANGEABLES
                    *
                -->
                <NavSection 
                    @click="exchangeablesToggle = !exchangeablesToggle" 
                    header="Exchangeables"
                    :toggle="exchangeablesToggle"
                />

                <Transition name="fade-right">
                    <div v-if="exchangeablesToggle">
                        <NavPage category="exchangeables" url="calcified-gasp" name="Calcified Gasp" :icon="CalcifiedGasp"/>

                        <NavPage category="exchangeables" url="dragonite-ore" name="Dragonite Ore" :icon="DragoniteOre"/>

                        <NavPage category="exchangeables" url="empyreal-fragment" name="Empyreal Fragment" :icon="EmpyrealFragment"/>

                        <NavPage category="exchangeables" url="fine-rift-essence" name="Fine Rift Essence" :icon="FineRiftEssence"/>

                        <NavPage category="exchangeables" url="masterwork-rift-essence" name="Masterwork Rift Essence" :icon="MasterworkRiftEssence"/>

                        <NavPage category="exchangeables" url="pile-of-bloodstone-dust" name="Pile of Bloodstone Dust" :icon="PileOfBloodstoneDust"/>

                        <NavPage category="exchangeables" url="pinch-of-stardust" name="Pinch of Stardust" :icon="PinchOfStardust"/>

                        <NavPage category="exchangeables" url="rare-rift-essence" name="Rare Rift Essence" :icon="RareRiftEssence"/>

                        <NavPage category="exchangeables" url="static-charge" name="Static Charge" :icon="StaticCharge"/>

                        <NavPage category="exchangeables" url="writs" name="Writs" :icon="WritOfNewKainengCity"/>  
                    </div>
                </Transition>

                <!--
                    *
                    * TOOLS
                    *
                -->
                <NavSection 
                    @click="toolsToggle = !toolsToggle" 
                    header="Tools"
                    :toggle="toolsToggle"
                />

                <Transition name="fade-right">
                    <div v-if="toolsToggle">
                        <NavPage category="tools" url="homestead" name="Homestead" :icon="Homestead"/>

                        <NavPage category="tools" url="recipe-value" name="Recipe Value" :icon="Armorer"/>

                        <NavPage category="tools" url="salvageables" name="Salvageables" :icon="UnidentifiedGear"/>

                        <NavPage category="tools" url="checklist" name="Checklist" :icon="EventSearch"/>  
                    </div>
                </Transition>

                <!--
                    *
                    * TIMERS
                    *
                -->
                <NavSection 
                    @click="timersToggle = !timersToggle" 
                    header="Timers"
                    :toggle="timersToggle"
                />

                <Transition name="fade-right">
                    <div v-if="timersToggle">

                        <NavPage category="timers" url="auric-basin" name="Auric Basin" :icon="LumpOfAurillium"/> 

                        <NavPage category="timers" url="ember-bay" name="Ember Bay" :icon="PetrifiedWood"/> 

                        <NavPage category="timers" url="domain-of-istan" name="Domain of Istan" :icon="KralkatiteOre"/> 

                        <NavPage category="timers" url="domain-of-kourna" name="Domain of Kourna" :icon="InscribedShard"/> 

                        <NavPage category="timers" url="dragonfall" name="Dragonfall" :icon="MistbornMote"/> 

                        <NavPage category="timers" url="lake-doric" name="Lake Doric" :icon="JadeShard"/> 

                        <NavPage category="timers" url="sandswept-isles" name="Sandswept Isles" :icon="DifluoriteCrystal"/> 

                        <NavPage category="timers" url="skywatch-archipelago" name="Skywatch Archipelago" :icon="StaticCharge"/> 

                        <NavPage category="timers" url="tangled-depths" name="Tangled Depths" :icon="LeyLineCrystal"/> 
                    </div>
                </Transition>
            </div>
        </nav>
    </Transition>

    <div class="mobile-nav-container" v-if="isMobile" @click="mainNavToggle = !mainNavToggle">
        <div class="mobile-nav">
            <img class="mobile-home" :src="PeuChoya" alt="Redirect to Home" title="Home">

            <svg v-if="mobileHamburger" @click="mobileHamburger = !mobileHamburger" class="hamburger" width="25" height="17" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.85938C0 1.54857 0.123465 1.2505 0.343234 1.03073C0.563003 0.810965 0.861074 0.6875 1.17188 0.6875H23.8281C24.1389 0.6875 24.437 0.810965 24.6568 1.03073C24.8765 1.2505 25 1.54857 25 1.85938C25 2.17018 24.8765 2.46825 24.6568 2.68802C24.437 2.90779 24.1389 3.03125 23.8281 3.03125H1.17188C0.861074 3.03125 0.563003 2.90779 0.343234 2.68802C0.123465 2.46825 0 2.17018 0 1.85938ZM0 8.5C0 8.1892 0.123465 7.89113 0.343234 7.67136C0.563003 7.45159 0.861074 7.32812 1.17188 7.32812H23.8281C24.1389 7.32812 24.437 7.45159 24.6568 7.67136C24.8765 7.89113 25 8.1892 25 8.5C25 8.8108 24.8765 9.10887 24.6568 9.32864C24.437 9.54841 24.1389 9.67188 23.8281 9.67188H1.17188C0.861074 9.67188 0.563003 9.54841 0.343234 9.32864C0.123465 9.10887 0 8.8108 0 8.5ZM1.17188 13.9688C0.861074 13.9688 0.563003 14.0922 0.343234 14.312C0.123465 14.5318 0 14.8298 0 15.1406C0 15.4514 0.123465 15.7495 0.343234 15.9693C0.563003 16.189 0.861074 16.3125 1.17188 16.3125H23.8281C24.1389 16.3125 24.437 16.189 24.6568 15.9693C24.8765 15.7495 25 15.4514 25 15.1406C25 14.8298 24.8765 14.5318 24.6568 14.312C24.437 14.0922 24.1389 13.9688 23.8281 13.9688H1.17188Z" fill="#FFD12C"/>
            </svg>

            <svg v-if="!mobileHamburger" @click="mobileHamburger = !mobileHamburger" class="mobile-close" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 1L1 13M1 1L13 13" stroke="#FFD12C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        
    </div>
</template>

<script setup>
import { ref, watch, provide, onMounted, onUnmounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import { scrollTo } from '@/js/vue/composables/NavFunctions.js'
import { user, isMobile, includes, buyOrder, sellOrder, tax } from '@/js/vue/composables/Global.js';
import { convertTaxToPercent, pageRefresh } from '@/js/vue/composables/BasicFunctions.js'
import { getAuthUser } from '@/js/vue/composables/Authentication';

import NavPage from '@/js/vue/components/navigation/NavPage.vue';
import IncludesCheckbox from '@/js/vue/components/navigation/IncludesCheckbox.vue';
import Shortcuts from '@/js/vue/components/navigation/Shortcuts.vue';
import DayAndNightTimers from '@/js/vue/components/navigation/DayAndNightTimers.vue';

import BlueCommander from '@/imgs/icons/Commander_Icon.png'
import FishingHook from "@/imgs/icons/Fishing.png"
import AirshipParts from '@/imgs/icons/Airship_Part.png'
import BanditCrest from '@/imgs/icons/Bandit_Crest.png'
import Geode from '@/imgs/icons/Geode.png'
import ImperialFavor from '@/imgs/icons/Imperial_Favor.png'
import JadeSliver from '@/imgs/icons/Jade_Sliver.png'
import Laurel from '@/imgs/icons/Laurel.png'
import LeyLineCrystal from '@/imgs/icons/Ley_Line_Crystal.png'
import LumpOfAurillium from '@/imgs/icons/Lump_of_Aurillium.png'
import ResearchNote from '@/imgs/icons/Research_Note.png'
import SpiritShard from '@/imgs/icons/Spirit_Shard.png'
import TradeContract from '@/imgs/icons/Trade_Contract.png'
import TyrianDefenseSeal from '@/imgs/icons/Tyrian_Defense_Seal.png'
import UnboundMagic from '@/imgs/icons/Unbound_Magic.png'
import VolatileMagic from '@/imgs/icons/Volatile_Magic.png'

import CalcifiedGasp from '@/imgs/icons/Calcified_Gasp.png'
import DragoniteOre from '@/imgs/icons/Dragonite_Ore.png'
import EmpyrealFragment from '@/imgs/icons/Empyreal_Fragment.png'
import FineRiftEssence from '@/imgs/icons/Fine_Rift_Essence.png'
import MasterworkRiftEssence from '@/imgs/icons/Masterwork_Rift_Essence.png'
import PinchOfStardust from '@/imgs/icons/Pinch_of_Stardust.png'
import PileOfBloodstoneDust from '@/imgs/icons/Pile_of_Bloodstone_Dust.png'
import RareRiftEssence from '@/imgs/icons/Rare_Rift_Essence.png'
import StaticCharge from '@/imgs/icons/Static_Charge.png'
import WritOfNewKainengCity from '@/imgs/icons/Writ_of_New_Kaineng_City.png'

import Homestead from '@/imgs/icons/Homestead.png'
import Armorer from '@/imgs/icons/Guild_Armorer.png'
import UnidentifiedGear from '@/imgs/icons/Piece_of_Unidentified_Gear.png'
import EventSearch from '@/imgs/icons/Event_Search.png'

import PetrifiedWood from '@/imgs/icons/Petrified_Wood.png'
import JadeShard from '@/imgs/icons/Jade_Shard.png'
import KralkatiteOre from '@/imgs/icons/Kralkatite_Ore.png'
import DifluoriteCrystal from '@/imgs/icons/Difluorite_Crystal.png'
import InscribedShard from '@/imgs/icons/Inscribed_Shard.png'
import MistbornMote from '@/imgs/icons/Mistborn_Mote.png'

import PeuChoya from '@/imgs/choyas/Peu_Choya.png'
import RollingChoya from '@/imgs/choyas/Rolling_Choya.png'

import axios from 'axios';
import { update } from 'lodash';
import NavSection from '@/js/vue/components/navigation/NavSection.vue';

// Initialize form fields
const name = ref(''), 
    email = ref(''),
    password = ref(''),
    remember = ref(null);

const registerToggle = ref(false);
// Wizard's Vault
const wv = ref(null); 

const mainNavToggle = ref(isMobile ? false : true),
    mobileHamburger = ref(isMobile ? true : false);

const apiKey = ref(null);

const route = useRoute(),
    router = useRouter();

const handlePageRefresh = () => {
    pageRefresh(router, route);
}


const saveSettings = async () => {
    try {
        const response = await axios.post('../api/user/saveSettings', {
            includes: includes.value,
            settings_buy_order: buyOrder.value,
            settings_sell_order: sellOrder.value,
            settings_tax: tax.value,
        })

        if (response){
            console.log('Saved Includes', includes)
        }
    } catch (error) {
        console.log('Includes did not save: ', error);
    }
}

const getSavedIncludes = async () => {
    try {
        const response = await axios.get('../api/user/getIncludes');

        if (response){
            includes.value = response.data; 
        }
    } catch (error){
        console.log("Could not retrieve saved includes list: ", error);
    }
}

const getUserData = async () => {
    try {
        const response = await axios.get('../api/user/getUserData');

        if (response){
            console.log('USER DATA: ', response);
        }
    } catch (error){
        console.log('Could not retrieve user data: ', error);
    }
}
// Change statuses of toggles
// Emitted from child components i.e. Settings
const changeToggleStatus = (toggleName) => {
    switch (toggleName){
        case 'API':
            apiKeyToggle.value = !apiKeyToggle.value;
            break;

        case 'Bookmarks':
            bookmarksToggle.value = !bookmarksToggle.value;
            break;

        case 'Filters':
            filtersToggle.value = !filtersToggle.value;
            break;

        case 'Login':
            loginToggle.value = !loginToggle.value;
            break;

        case 'Settings':
            settingsToggle.value = !settingsToggle.value; 
            break;
    } 
}



const getWizardsVault = async (key) => {
    try {
        console.log(key); 
        const response = await fetch(`https://api.guildwars2.com/v2/account/wizardsvault/daily?access_token=${key}`);

        wv.value = await response.json(); 
        console.log(wv.value);
        
    } catch (error){
        console.log("Error retreiving Wizard's Vault info: ", error); 
    }
}

// *
// * LOGIN
// * Assuming a completed form with username, password => login into a new session 
// * Refresh page if successful
const login = async () => {
    try {
        // Get unique cookie? 
        await axios.get('../sanctum/csrf-cookie');
        // Send POST to /login via web.php route: 
        // LoginController.php, authenticate(); 
        // Use the v-model form values to verify registered user
        const response = await axios.post('../login', {
            name: name.value,
            email: email.value,
            password: password.value,
            remember: remember.value,
        }, {
            divs: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        // If sucessful, page refresh
        if (response){
            console.log("Login successful!");
            handlePageRefresh();
        } 
    } catch (error) {
        console.log('Login error: ', error);
    }
}

const logout = async () => {
    try {
        const response = await axios.post('../logout');

        if (response){
            user.value = null;
            console.log('Logout successful!');
            handlePageRefresh();
        }
    } catch (error){
        console.log('Logout failed: ', error);
    }
}

const register = async () => {
  try {
        const response = await fetch('../register', {
            method: 'POST',
            divs: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                name: name.value,
                email: email.value,
                password: password.value,
                remember: remember.value,
            }),
        });

        if (!response.ok) {
            throw new Error('Registration failed');
        }

    // Redirect or handle success as needed
    } catch (error) {
        console.error('Registration error:', error);
        // Handle error (e.g., show error message)
    }
};


const enterAPIKey = async () => {
    try{
        const response = await axios.post('../api/user/enterAPIKey', {
            apiKey: apiKey.value,
        })

        // If sucessful, page refresh
        if (response){
            console.log("API key successful!");
            //handlePageRefresh();
        } 
    } catch (error){
        console.log("API key failure: ", error); 
    }
    
}

// For first time visitors
// If there is no exisiting local stoarge property (like sellOrder), then make one by default
// Otherwise, don't do anything
const setDefaultLocalStorage = () => {
    // * SETTINGS
    // * 
    // *
    if (!localStorage.settings){
        localStorage.setItem('settings', false);
    }
    
    // * 
    // * FILTER RESEARCH NOTES
    // *
    if (!localStorage.filterResearchNotes){
        localStorage.setItem('filterResearchNotes', JSON.stringify([
            "TP", 
            "Crafting",
            "Armorsmith",
            "Artifier",
            "Chef",
            "Huntsman",
            "Jeweler",
            "Leatherworker",
            "Scribe",
            "Tailor",
            "Weaponsmith",
            "Consumable",
            "Weapon",
            "Armor",
            "Back",
            "Trinket",
            "UpgradeComponent",
        ])); 
    }
    // * 
    // * FILTERS TOGGLE
    // *
    if (!localStorage.filtersToggle){
        localStorage.setItem('filters', false);
    }
    // * BOOKMARKS
    // * 
    // * Set different bookmarks for different pages if applicable
    if (!localStorage.bookmarks){
        localStorage.setItem('bookmarks', true);
    }
    
    if (!localStorage.spiritShardsFineT2Table){
        localStorage.setItem('spiritShardsFineT2Table', true);
    }
    if (!localStorage.spiritShardsFineT3Table){
        localStorage.setItem('spiritShardsFineT3Table', true);
    }
    if (!localStorage.spiritShardsFineT4Table){
        localStorage.setItem('spiritShardsFineT4Table', true);
    }
    if (!localStorage.spiritShardsFineT5Table){
        localStorage.setItem('spiritShardsFineT5Table', true);
    }
    if (!localStorage.spiritShardsFineT6Table){
        localStorage.setItem('spiritShardsFineT6Table', true);
    }
    if (!localStorage.spiritShardsRareT2Table){
        localStorage.setItem('spiritShardsRareT2Table', true);
    }
    if (!localStorage.spiritShardsRareT3Table){
        localStorage.setItem('spiritShardsRareT3Table', true);
    }
    if (!localStorage.spiritShardsRareT4Table){
        localStorage.setItem('spiritShardsRareT4Table', true);
    }
    if (!localStorage.spiritShardsRareT5Table){
        localStorage.setItem('spiritShardsRareT5Table', true);
    }
}
setDefaultLocalStorage(); 

const benchmarksToggle = ref(true),
    currenciesToggle = ref(true),
    exchangeablesToggle = ref(true),
    toolsToggle = ref(true),
    timersToggle = ref(true);

const settingsToggle = ref(JSON.parse(localStorage.settings)),
    filtersToggle = ref(JSON.parse(localStorage.filters)),
    bookmarksToggle = ref(JSON.parse(localStorage.bookmarks)),
    loginToggle = ref(false),
    apiKeyToggle = ref(false);





// Change buy and sell order settings
const changeOrder = (order) => {
    switch (order){
        case 'sell order': 
            if (sellOrder.value == 'sell_price'){
                sellOrder.value = 'buy_price';
            } else {
                sellOrder.value = 'sell_price';
            }
            break;
        case 'buy order':
            if (buyOrder.value == 'buy_price'){
                buyOrder.value = 'sell_price';
            } else {
                buyOrder.value = 'buy_price';
            }
            break;
    }
}

watch(tax, (newtax) => {
    if (newtax == ''){
        newtax = 0.85;
    }
    tax.value = newtax;
})



// Function to update isMobile based on screen width
const checkMobile = () => {
    isMobile.value = window.innerWidth < 768;
    if (!isMobile.value){
        mainNavToggle.value = true;
        mobileHamburger.value = false;
    } else {
        mainNavToggle.value = false;
        mobileHamburger.value = true;
    }
};

// Add resize event listener when the component is mounted
onMounted(() => {
    window.addEventListener('resize', checkMobile);
    checkMobile();
});

onMounted(async () => {
    if (!user.value){
        getAuthUser();
    }
    
})

watch(isMobile, (newIsMobile) => {
    if (!isMobile.value){
        mainNavToggle.value = true; 
    }
})

// UPDATE settings when user has logged on or off
watch(user, (userData) => {
    if (userData){
        buyOrder.value = userData.settings_buy_order;
        sellOrder.value = userData.settings_sell_order;
        tax.value = userData.settings_tax; 
        includes.value = userData.includes;
    }
    
})

</script>

<style scoped>
nav{
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0;
    left: 0;
    height: 100dvh;
    overflow-x: hidden;
    overflow-y: scroll;
    width: var(--nav-width);
    background-color: var(--color-bkg);
    /* padding-left: var(--nav-padding); */
    z-index: 100000;
}
::-webkit-scrollbar{
    width: 1rem;
    border: var(--border-general);
}
::-webkit-scrollbar-thumb{
    background-color: var(--color-scrollbar-thumb);
}
nav .top img{
    width: var(--nav-img-w-and-h);
    height: var(--nav-img-w-and-h);
}
nav .logo-container{
    width: 100%;
}
nav .credits p{
    padding-left: var(--nav-padding-left);
}



a.page-link{
    display: flex;
    align-items: center;
    gap: 5px;
    padding: var(--nav-padding);
    border-bottom: var(--border-bottom);
    text-decoration: none;
}
nav .routes a img,
nav .routes a h6{
    transition: var(--transition-all-03s-ease);
}

nav .routes a:hover img,
nav .routes a:hover h6{
    transform: translateX(10px);
}
nav a:hover{
    border-bottom: var(--hover-border-bottom);
}


.nav-container{
    position: relative;
}

.shortcut-container{
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: var(--padding-settings);
    gap: 10px;
    border-bottom: var(--border-bottom);
}

.settings-button-container{
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.settings-button{
    display: flex;
}
.settings-button button{
    border: var(--border-general);
}
.settings-button-container input {
    width: 50%;
}
.settings-tax-input{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 5px;
}
.settings-tax-model{
    display: flex;
    align-items: center;
    gap: 5px;
}
.settings-tax-model svg{
    transition: var(--transition-all-03s-ease);
}

.form-container{
    padding: var(--padding-settings);
}
.form-container input{
    width: 100%;
    margin-bottom: 10px;
}

form .form-button-container{
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    padding-top: 10px;
}
form .remember-container{
    display: flex;
    align-items: center;
}
form .remember-container label{
    white-space: nowrap;
}
form .remember-container input{
    margin-bottom: unset;
}

@media (max-width: 768px){
    nav.main-nav{
        width: 100%;
        padding-top: calc(var(--padding-general) * 2 + 60px);
    }
    ::-webkit-scrollbar{
        display: none;
    }
    .mobile-nav-container{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: var(--color-bkg);
        padding: var(--padding-general);
        z-index: 10000000;
    }
    .mobile-nav{
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: var(--border-bottom);
    }
    img.mobile-home{
        width: 60px;
        height: 60px;
    }
    .hamburger{
        width: 35px;
        height: 35px;
    }
    .mobile-close{
        width: 30px;
        height: 30px;
    }
}





</style>
