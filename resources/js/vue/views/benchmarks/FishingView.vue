<template>
    <Nav/>
    <Header page-name="Fishing Benchmarks"/>

    <section class="main">
        <div class="content-section">
            <Loading v-if="!fishingHoleToggle" :width="200" :height="200" :progress="currentProgress" />

            <div class="daily-catch-container">
                <div class="daily-catch-search-and-catch">
                    <SearchItem 
                        v-if="searchArborstone"
                        :show-quantity="false"
                        placeholder="[Daily Arborstone Catch]"
                        submit-text="Submit Arborstone"
                        @handle-item-search="handleArborstoneSearch"
                    />
                    <!--
                        *
                        * ARBORSTONE DAILY CATCH
                        *
                    -->
                    <div v-if="dailyCatch && dailyCatch.arborstone.length != 0" class="daily-catch">
                        <div class="img-and-label">
                            <!-- ICON -->
                            <img :src="dailyCatch.arborstone.fish.icon" :alt="dailyCatch.arborstone.fish.name" :title="dailyCatch.arborstone.fish.name">
                            <!-- NAME -->
                            <p :style="{color: showRarityColor(dailyCatch.arborstone.fish.rarity)}">{{ dailyCatch.arborstone.fish.name }}</p>

                            <!-- SEARCH ARBORSTONE -->
                            <svg 
                                @click="searchArborstone = !searchArborstone" 
                                class="icon clickable"
                                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M18.4444 20L11.4444 13C10.8889 13.4444 10.25 13.7963 9.52778 14.0556C8.80556 14.3148 8.03704 14.4444 7.22222 14.4444C5.2037 14.4444 3.49556 13.7452 2.09778 12.3467C0.7 10.9481 0.000741329 9.24 5.8789e-07 7.22222C-0.000740153 5.20444 0.698519 3.4963 2.09778 2.09778C3.49704 0.699259 5.20519 0 7.22222 0C9.23926 0 10.9478 0.699259 12.3478 2.09778C13.7478 3.4963 14.4467 5.20444 14.4444 7.22222C14.4444 8.03704 14.3148 8.80556 14.0556 9.52778C13.7963 10.25 13.4444 10.8889 13 11.4444L20 18.4444L18.4444 20ZM7.22222 12.2222C8.61111 12.2222 9.79185 11.7363 10.7644 10.7644C11.737 9.79259 12.223 8.61185 12.2222 7.22222C12.2215 5.83259 11.7356 4.65222 10.7644 3.68111C9.79333 2.71 8.61259 2.2237 7.22222 2.22222C5.83185 2.22074 4.65148 2.70704 3.68111 3.68111C2.71074 4.65519 2.22444 5.83556 2.22222 7.22222C2.22 8.60889 2.7063 9.78963 3.68111 10.7644C4.65593 11.7393 5.8363 12.2252 7.22222 12.2222Z" fill="var(--color-link)"/>
                                <title>Not the right fish? Submit what you see in-game. The new fish will overtake the current if the # of confirmations is greater</title>
                            </svg>
                            <!-- EASY CONFIRMATION -->
                            <svg 
                                @click="submitDailyCatch(dailyCatch.arborstone.fish, 'Arborstone')"
                                class="icon clickable"
                                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M2.92984 17.0701C1.97473 16.1476 1.21291 15.0442 0.688821 13.8241C0.164731 12.6041 -0.111131 11.2919 -0.122669 9.96409C-0.134207 8.6363 0.11881 7.3195 0.621618 6.09054C1.12443 4.86158 1.86696 3.74506 2.80589 2.80613C3.74481 1.8672 4.86133 1.12467 6.09029 0.621863C7.31926 0.119054 8.63605 -0.133963 9.96385 -0.122425C11.2916 -0.110887 12.6038 0.164975 13.8239 0.689065C15.0439 1.21316 16.1474 1.97498 17.0698 2.93008C18.8914 4.8161 19.8994 7.34212 19.8766 9.96409C19.8538 12.5861 18.8021 15.0942 16.948 16.9483C15.0939 18.8023 12.5858 19.854 9.96385 19.8768C7.34188 19.8996 4.81586 18.8917 2.92984 17.0701ZM15.6598 15.6601C17.161 14.159 18.0043 12.123 18.0043 10.0001C18.0043 7.87717 17.161 5.8412 15.6598 4.34008C14.1587 2.83895 12.1227 1.99563 9.99984 1.99563C7.87692 1.99563 5.84096 2.83895 4.33984 4.34008C2.83871 5.8412 1.99539 7.87717 1.99539 10.0001C1.99539 12.123 2.83871 14.159 4.33984 15.6601C5.84096 17.1612 7.87692 18.0045 9.99984 18.0045C12.1227 18.0045 14.1587 17.1612 15.6598 15.6601ZM6.69983 9.29008L8.99984 11.6001L13.2998 7.30008L14.6998 8.72008L8.99984 14.4001L5.29984 10.7001L6.69983 9.28008V9.29008Z" fill="var(--color-link)"/>
                                <title>Is this the right fish? If yes, click to confirm</title>
                            </svg>

                            <PopUpMessage v-if="arborstoneSubmit" message="Thanks for confirming!"/>
                        </div>

                        <p>{{ dailyCatch.arborstone.fish.map }}, {{ dailyCatch.arborstone.fish.fishing_hole }}</p>

                        <p class="small-subtitle">Daily Arborstone confirmed by {{ dailyCatch.arborstone.count }} choyas</p>
                    </div>
                    <!-- 
                        * ARBORSTONE WAYPOINT 
                    -->
                    <p class="link" @click="(e) => {copyWaypoint('[&BGMNAAA=]'); showTooltip(e)}">Arborstone Waypoint</p>
                </div>
                
                <div class="daily-catch-search-and-catch">
                    <SearchItem 
                        v-if="searchJanthir"
                        :show-quantity="false"
                        placeholder="[Daily Janthir Catch]"
                        submit-text="Submit Janthir"
                        @handle-item-search="handleJanthirSearch"
                    />
                    <!--
                        *
                        * JANTHIR DAILY CATCH
                        *
                    -->
                    <div v-if="dailyCatch && dailyCatch.janthir.length != 0" class="daily-catch">
                        <div class="img-and-label">
                            <!-- ICON -->
                            <img :src="dailyCatch.janthir.fish.icon" :alt="dailyCatch.janthir.fish.name" :title="dailyCatch.janthir.name">
                            <!-- NAME -->
                            <p :style="{color: showRarityColor(dailyCatch.janthir.fish.rarity)}">{{ dailyCatch.janthir.fish.name }}</p>

                            <!-- SEARCH JANTHIR -->
                            <svg 
                                @click="searchJanthir = !searchJanthir" 
                                class="icon clickable"
                                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M18.4444 20L11.4444 13C10.8889 13.4444 10.25 13.7963 9.52778 14.0556C8.80556 14.3148 8.03704 14.4444 7.22222 14.4444C5.2037 14.4444 3.49556 13.7452 2.09778 12.3467C0.7 10.9481 0.000741329 9.24 5.8789e-07 7.22222C-0.000740153 5.20444 0.698519 3.4963 2.09778 2.09778C3.49704 0.699259 5.20519 0 7.22222 0C9.23926 0 10.9478 0.699259 12.3478 2.09778C13.7478 3.4963 14.4467 5.20444 14.4444 7.22222C14.4444 8.03704 14.3148 8.80556 14.0556 9.52778C13.7963 10.25 13.4444 10.8889 13 11.4444L20 18.4444L18.4444 20ZM7.22222 12.2222C8.61111 12.2222 9.79185 11.7363 10.7644 10.7644C11.737 9.79259 12.223 8.61185 12.2222 7.22222C12.2215 5.83259 11.7356 4.65222 10.7644 3.68111C9.79333 2.71 8.61259 2.2237 7.22222 2.22222C5.83185 2.22074 4.65148 2.70704 3.68111 3.68111C2.71074 4.65519 2.22444 5.83556 2.22222 7.22222C2.22 8.60889 2.7063 9.78963 3.68111 10.7644C4.65593 11.7393 5.8363 12.2252 7.22222 12.2222Z" fill="var(--color-link)"/>
                                <title>Not the right fish? Submit what you see in-game. The new fish will overtake the current if the # of confirmations is greater</title>
                            </svg>
                            <!-- EASY CONFIRMATION -->
                            <svg 
                                @click="submitDailyCatch(dailyCatch.janthir.fish, 'Janthir')"
                                class="icon clickable"
                                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M2.92984 17.0701C1.97473 16.1476 1.21291 15.0442 0.688821 13.8241C0.164731 12.6041 -0.111131 11.2919 -0.122669 9.96409C-0.134207 8.6363 0.11881 7.3195 0.621618 6.09054C1.12443 4.86158 1.86696 3.74506 2.80589 2.80613C3.74481 1.8672 4.86133 1.12467 6.09029 0.621863C7.31926 0.119054 8.63605 -0.133963 9.96385 -0.122425C11.2916 -0.110887 12.6038 0.164975 13.8239 0.689065C15.0439 1.21316 16.1474 1.97498 17.0698 2.93008C18.8914 4.8161 19.8994 7.34212 19.8766 9.96409C19.8538 12.5861 18.8021 15.0942 16.948 16.9483C15.0939 18.8023 12.5858 19.854 9.96385 19.8768C7.34188 19.8996 4.81586 18.8917 2.92984 17.0701ZM15.6598 15.6601C17.161 14.159 18.0043 12.123 18.0043 10.0001C18.0043 7.87717 17.161 5.8412 15.6598 4.34008C14.1587 2.83895 12.1227 1.99563 9.99984 1.99563C7.87692 1.99563 5.84096 2.83895 4.33984 4.34008C2.83871 5.8412 1.99539 7.87717 1.99539 10.0001C1.99539 12.123 2.83871 14.159 4.33984 15.6601C5.84096 17.1612 7.87692 18.0045 9.99984 18.0045C12.1227 18.0045 14.1587 17.1612 15.6598 15.6601ZM6.69983 9.29008L8.99984 11.6001L13.2998 7.30008L14.6998 8.72008L8.99984 14.4001L5.29984 10.7001L6.69983 9.28008V9.29008Z" fill="var(--color-link)"/>
                                <title>Is this the right fish? If yes, click to confirm</title>
                            </svg>

                            <PopUpMessage v-if="janthirSubmit" message="Thanks for confirming!"/>
                        </div>

                        <p>{{ dailyCatch.janthir.fish.map }}, {{ dailyCatch.janthir.fish.fishing_hole }}</p>

                        <p class="small-subtitle">Daily Janthir confirmed by {{ dailyCatch.janthir.count }} choyas</p>

                    </div>
                    <!-- 
                        * JANTHIR WAYPOINT
                    -->
                    <p class="link" @click="(e) => {copyWaypoint('[&BC4PAAA=]'); showTooltip(e)}">Autumn's Vale Waypoint</p>
                </div>
                
            </div>
            

            <div class="content-and-legend">
                <FishBenchmark
                    v-if="fishingHoleToggle"
                    :daily-catch="dailyCatch"
                    :fishing-holes="fishingHoles"
                    :drop-rates="dropRates"
                />

                <div class="flex-column">
                    <ExchangeTable v-if="fishmonger" 
                        :exchanges="fishmonger"
                        title="Fishmonger"
                    />

                    <ItemValueTable
                        title="Item Values"
                        :items="individualItemsResponse"
                    />

                    <Legend/>
                </div>
             
            </div>
            
        </div> <!-- End of content-section -->
        
        
    </section>

    

    <!-- * CURSOR TOOLTIP -->
    <Transition name="fade">
        <CursorTooltip v-if="tooltipToggle" message="Copied!" :mouseX="mouseX" :mouseY="mouseY" />
    </Transition>

    <Footer/>
</template>

<script setup>
import { ref, computed, onMounted, watch, onUnmounted } from 'vue'
import { user, buyOrder, sellOrder, tax, includes, dayAndNightTimerToggle } from '@/js/vue/composables/Global'
import { showRarityColor } from '@/js/vue/composables/FormatFunctions'
import { getAuthUser } from '@/js/vue/composables/Authentication'
import { handleCursorTooltip } from '@/js/vue/composables/MouseFunctions'
import { copyWaypoint } from '@/js/vue/composables/BasicFunctions'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import FishBenchmark from '@/js/vue/components/general/FishBenchmark.vue'
import Loading from '@/js/vue/components/general/Loading.vue'
import SearchItem from '@/js/vue/components/general/SearchItem.vue'
import PopUpMessage from '@/js/vue/components/general/PopUpMessage.vue'
import CursorTooltip from '@/js/vue/components/general/CursorTooltip.vue';

import ExchangeTable from '@/js/vue/components/tables/ExchangeTable.vue'
import ItemValueTable from '@/js/vue/components/tables/ItemValueTable.vue'

import Legend from '@/js/vue/components/guides/legends/Fishing.vue'

const fishingHoles = ref([]),
    dropRates = ref([]),
    fishmonger = ref(null),
    individualItemsResponse = ref(null),
    fishingHoleToggle = ref(false);

const dailyCatch = ref(null);

// Toggles to display the search bars
const searchArborstone = ref(false),
    searchJanthir = ref(false);

// Toggles to display 'submitted' message
const arborstoneSubmit = ref(false),
    janthirSubmit = ref(false);

// Initalize Ambergris, Flawless Fillet to place value in here to be used to calc daily fish
const ambergris = ref(null),
    flawlessFillet = ref(null);

const currentProgress = ref(0);

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

const exchangeableFillets = [
    // 1 Fine Fish Fillet <- 1 Piece of Crustacean Meat
    { resultID: 96762, resultQty: 1, exchangeableID: 97075, exchangeableQty: 1 },
    // 1 Fabulous Fish Fillet <- 5 Fine Fish Fillet
    { resultID: 97690, resultQty: 1, exchangeableID: 96762, exchangeableQty: 5 },
    // 1 Flavorful Fish Fillet <- 5 Fabulous Fish Fillet
    { resultID: 96943, resultQty: 1, exchangeableID: 97690, exchangeableQty: 5 },
    // 1 Fantastic Fish Fillet <- 5 Flavorful Fish Fillet
    { resultID: 95663, resultQty: 1, exchangeableID: 96943, exchangeableQty: 5 },
    // 1 Flawless Fish Fillet <- 5 Fantastic Fish Fillet
    { resultID: 95673, resultQty: 1, exchangeableID: 95663, exchangeableQty: 5 },
    // 1 Mackerel <- 5 Fine Fish Fillet
    { resultID: 95943, resultQty: 1, exchangeableID: 96762, exchangeableQty: 5 },
    // 1 Chunk of Ambergris <- 10 Flawless Fillet
    { resultID: 96347, resultQty: 1, exchangeableID: 95673, exchangeableQty: 10 }
];

const individualItems = [
    // Chunk of Ancient Ambergris
    96347,
    // Zephyrite Fish Jerky
    99955,
]



const handleArborstoneSearch = async (query) => {
    submitDailyCatch(query, 'Arborstone');
}

const handleJanthirSearch = async (query) => {
    submitDailyCatch(query, 'Janthir');
}
// *
// * CONFIRM CATCH DAILY
// * Users can input (registered or not) the fish daily and commits to Confirmation db
const submitDailyCatch = async (query, type) => {
    try {
        const response = await fetch('/item/confirm', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                itemID: query.id, 
                userID: user.value ? user.value.id : null, 
                type: type,
            })
        });

        if (response.ok){
            console.log('Confirmed item!');
            // Show and hide the 'submitted!' message to allow users to know they submitted their confirmation
            if (type == 'Arborstone'){
                arborstoneSubmit.value = true;
                setTimeout(() => { arborstoneSubmit.value = false }, 2000);
            }
            if (type == 'Janthir'){
                janthirSubmit.value = true;
                setTimeout(() => { janthirSubmit.value = false }, 2000);
            }

            getDailyCatch();
        }

    } catch (error) {
        console.log('Could not post item confirmation', error);
    }
}

const sortBenchmarks = (benchmarks) => {
    if (benchmarks){
        console.log('to sort benchmarks: ', benchmarks, dailyCatch.value);

        const addEstimate = (fishRarity, sellOrder, bench) => {
            if (fishRarity == 'Masterwork'){
                if (sellOrder == 'sell_price'){
                    bench.estimateValue += flawlessFillet.value.sell_price * tax.value; 
                } 
                if (sellOrder == 'buy_order'){
                    bench.estimateValue += flawlessFillet.value.buy_price * tax.value;
                }
            }
            if (fishRarity == 'Rare' || fishRarity == 'Exotic'){
                if (sellOrder == 'sell_price'){
                bench.estimateValue += ambergris.value.sell_price * tax.value;                        
                } 
                if (sellOrder == 'buy_price'){
                    bench.estimateValue += ambergris.value.buy_price * tax.value; 
                }
            }
        }
        const janthirFishCheck = (fishName, bench) => {
            switch (fishName){
                // case 'Northern Pike':
                // case 'Rainbow Trout':
                // case 'White Bass':
                //     if (bench.name == 'Lowland Freshwater Fish'){
                //         addEstimate(sellOrder.value, bench);
                //     }
                //     break;

                case 'King Salmon':
                case 'Viperfish':
                case 'Violet Screamer':
                case 'Spectacled Lumper':
                case 'Shaderock Salamander':
                case 'Mohawk Bream':
                    if (//bench.name == 'Lowland Freshwater Fish'
                        bench.name == 'Lowland Brackish Fish'
                        //|| bench.name == 'Lowland Shore Fish'
                        || bench.name == 'Lowland Offshore Fish'
                    ){
                        addEstimate(sellOrder.value, bench);
                    }
                    break;

                case 'Cherry Salmon':
                case 'Sockeye':
                    if (//bench.name == 'Lowland Freshwater Fish'
                        bench.name == 'Lowland Brackish Fish'
                    ){
                        addEstimate(sellOrder.value, bench);
                    }
                    break;
            }
        }

        // CHECK IF DAILY CATCH
        // If yes, add ambergris or Flawless to estimatedValue before sorting
        // Do this here instead of the backend because this does not get cached

        // If ARBORSTONE dailyCatch != empty
        if (dailyCatch.value.arborstone.hasOwnProperty('count')){
            benchmarks.forEach(bench => {
                if ((dailyCatch.value.arborstone.fish.map == bench.region
                    && dailyCatch.value.arborstone.fish.fishing_hole == bench.name)
                    // For special cases such as Maguuma Jungle, Freshwater with Homesteads and SOTO freshwaters
                    || (dailyCatch.value.arborstone.fish.map == 'Maguuma Jungle' && dailyCatch.value.arborstone.fish.fishing_hole == 'Freshwater Fish' && bench.name.includes('Freshwater Fish'))
                )
                {
                    addEstimate(dailyCatch.value.arborstone.fish.rarity, sellOrder.value, bench); 
                }
                janthirFishCheck(dailyCatch.value.arborstone.fish.name, bench);
            })
        }
        // If JANTHIR dailyCatch != empty
        if (dailyCatch.value.janthir.hasOwnProperty('count')){
            benchmarks.forEach(bench => {
                if (dailyCatch.value.janthir.fish.map == bench.region
                    && dailyCatch.value.janthir.fish.fishing_hole == bench.name)
                {
                    addEstimate(dailyCatch.value.janthir.fish.rarity, sellOrder.value, bench);
                }
                janthirFishCheck(dailyCatch.value.janthir.fish.name, bench);
            })
        }

        // Create an array of indexes
        const indexes = benchmarks.map((_, index) => index);

        // Sort the indexes based on the estimatedValue
        indexes.sort((a, b) => benchmarks[b].estimateValue - benchmarks[a].estimateValue);

        // Use the sorted indexes to sort benchmarks and dropRates
        const sortedBenchmarks = indexes.map(index => benchmarks[index]);
        const sortedDropRates = indexes.map(index => dropRates.value[index]);

        // Update the ref values with sorted data
        fishingHoles.value = sortedBenchmarks;
        dropRates.value = sortedDropRates;

        //console.log('sorted: ', fishingHoles.value, dropRates.value);
        fishingHoleToggle.value = true; 
    }
}



const url = computed(() => {
    return `../api/benchmarks/fishing/${JSON.stringify(includes.value)}/${buyOrder.value}/${sellOrder.value}/${tax.value}`;
})

const fishmongerURL = computed(() => {
    return `../api/exchange/${JSON.stringify(exchangeableFillets)}/${sellOrder.value}/${tax.value}`;
})

// BY DEFAULT
// If there is no user logged in, use default settings
onMounted( async () => {

    await getDailyCatch();
    // Fetch Ambergris and Flawless Fillet values
    await fetchDailyItems();
    // Fetch individual items
    await fetchIndividualItems(individualItems); 

    //console.log('url value: ', url.value);
    // Check if user is being auth
    await getAuthUser();
    // IF NO USER
    if (!user.value){
        console.log('no user')
        getFishes();
    } 
    // USER FOUND
    else {
        console.log('user found')
        getFishes();
    }

    dayAndNightTimerToggle.value = true; 

    console.log(url.value);
})

onUnmounted(() => {
    dayAndNightTimerToggle.value = false; 
})

// Update the progress of loading the data 
window.Echo.channel('progress')
    .listen('LoadingProgress', (e) => {
        currentProgress.value = e.progress; 
        //console.log('Loading Progress: ', e.progress);
    })

// *
// * FETCH INDIVIDUAL ITEMS
// * 
// * Create const requestArray as an array of items for the request
// * RETURNS from data from items db 
// *
const fetchIndividualItems = async (requestArray) => {
    try {
        const response = await fetch(`../api/items/${JSON.stringify(requestArray)}`);
        const responseData = await response.json(); 

        individualItemsResponse.value = responseData; 

    } catch (error){
        console.log('Could not fetch individual items: ', error); 
    }
}

const fetchDailyItems = async () => {
    try {
        const ambergrisResponse = await fetch(`/api/item/96347`);
        const ambergrisResponseData = await ambergrisResponse.json(); 

        const filletResponse = await fetch(`/api/item/95673`);
        const filletResponseData = await filletResponse.json(); 

        if (ambergrisResponse.ok){
            // Populate Ambergris and Fillet value
            ambergris.value = ambergrisResponseData;
            //console.log('AMBERGIRS: ', ambergris.value);
        }

        if (filletResponse.ok){
            flawlessFillet.value = filletResponseData;
            //console.log('FLAWLESS: ', flawlessFillet.value);
        }

    } catch (error){
        console.log('Unable to fetch item: ', error); 
    }
}

// *
// * FETCH FISHES FROM DATABASE
// * 
const getFishes = async () => {
    //console.log('getfishes url: ', url.value);

    const response = await fetch(url.value);
    const responseData = await response.json(); 
    
    fishingHoles.value = responseData.fishingHoles; 
    dropRates.value = responseData.dropRates;
    sortBenchmarks(fishingHoles.value);

    const fishmongerResponse = await fetch(fishmongerURL.value);
    const fishmongerResponseData = await fishmongerResponse.json(); 

    fishmonger.value = fishmongerResponseData; 

}

const getDailyCatch = async () => {
    try {
        const response = await fetch('/api/fetch-daily-catch');
        const responseData = await response.json(); 

        if (response.ok){
            //console.log('daily catch: ', responseData);
            dailyCatch.value = responseData;

            // Show / hide search bar for respective dailies
            // Hide b/c it's kinda chonky 
            if (responseData.arborstone && responseData.arborstone.count > 0){
                searchArborstone.value = false;
            } else {
                searchArborstone.value = true; 
            }
            if (responseData.janthir && responseData.janthir.count > 0){
                searchJanthir.value = false; 
            } else {
                searchJanthir.value = true; 
            }
            // 
            if (dailyCatch.value.arborstone?.count || dailyCatch.value.janthir?.count){
                if (fishingHoles.value
                    && (responseData.arborstone.count == 1 || responseData.janthir.count == 1)
                ){
                    console.log(dailyCatch.value);
                    sortBenchmarks(fishingHoles.value);
                }
            }
           
            
        }
    } catch (error){
        console.log('Could not fetch daily catch: ', error);
    }
}

// watch(dailyCatch, (newDailyCatch) => {
//     if (newDailyCatch){
//         sortBenchmarks(fishingHoleToggle.value);
//     }
// })

</script>

<style scoped>
.content-section{
    display: flex;
    flex-direction: column;
    gap: var(--gap-general);
}
.daily-catch-container{
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    align-items: flex-start;
    gap: var(--gap-content);
}

.daily-catch-search-and-catch{
    display: flex;
    flex-direction: column;
    gap: var(--gap-general);
}

</style>