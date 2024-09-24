<template>
    <Nav/>
    <Header page-name="Recipe Value"/>
    <section class="main">
        <div class="content-section">
            <div class="search-container">
                <!-- 
                    * RECIPE FORM
                    * 
                    * SEARCH BAR => SENDS REQUEST TO RECEIVE RECIPE INFO AND CALCULATIONS
                -->
                <form 
                    class="recipe-form"
                    @submit.prevent="handleRecipeRequest"
                >
                    <!-- SEARCH BAR -->
                    <input 
                        type="text" 
                        placeholder="Item Name"
                        v-model="searchQuery"
                    >
                    <Transition name="fade">
                        <!-- LIST IF SEARCH BAR HAS CONTENT -->
                        <ul class="search-query-container" v-if="searchQuery && searchQuery.length > 3">
                            <button 
                                v-for="recipe in searchResults"
                                @click="searchQuery = recipe.name; idRequest = recipe.id"
                            >
                                <li>
                                    <img :src="recipe.icon" :alt="recipe.name" :title="recipe.name">
                                    <span class="flex-row-space-btw">
                                        <p :style="{color: showRarityColor(recipe.rarity)}">{{ recipe.name }}</p> 
                                    </span>
                                </li> 
                            </button>
                        </ul>
                    </Transition>
                    <!-- 
                        * INPUT - QUANTITY
                        * SUBMIT RECIPE
                    -->
                    <div class="flex-row-space-btw">
                        <input
                            type="number"
                            min="1"
                            v-model="quantityRequest"
                        >
                        <!-- <span class="input-radio">
                            <input 
                                type="radio" 
                                id="own-ingredients" 
                                value="true" 
                                @change="updateRecipeToOwned()"
                                v-model="ownIngredientsToggle"
                            >
                            <label for="own-ingredients">Own Ingredients</label>
                        </span> -->
                        <button class="submit" type="submit">Fetch Recipe</button>
                        
                    </div>
                </form>

                <Loading 
                    v-if="loadingToggle"
                    :width="200" :height="200"    
                />

                <!-- 
                    *
                    * OUTPUT CONTAINER
                    *
                    * Display the TP prices, crafting costs, and profit in one section
                -->
                <div class="display-output-container" v-if="recipe">

                    <!-- TP BUY PRICE -->
                    <span class="output">
                        <span class="flex-row-flex-start">
                            <img :src="TradingPost" alt="Trading Post" title="Trading Post"> 
                            <p>Trading Post (Buy Price): </p>
                        </span>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label" 
                                v-for="gold in formatValue(recipe.buy_price)"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </span>
                    </span> 

                    <!-- TP SELL PRICE -->
                    <span class="output">
                        <span class="flex-row-flex-start">
                            <img :src="TradingPost" alt="Trading Post" title="Trading Post"> 
                            <p>Trading Post (Sell Price): </p>
                        </span>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label" 
                                v-for="gold in formatValue(recipe.sell_price)"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </span>
                    </span> 

                    <!-- CRAFTING COSTS -->
                    <span class="output">
                        <span class="flex-row-flex-start">
                            <img :src="Armor" alt="Crafting" title="Crafting"> 
                            <p>Crafting Costs: </p>
                        </span>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label" 
                                v-for="gold in formatValue(
                                    recipe.preference ? recipe.craftingValue : recipe.buy_price
                                )"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </span>
                    </span>   
                    
                    <!-- PROFIT (BUY PRICE) -->
                    <span class="output">
                        <span class="flex-row-flex-start">
                            <svg 
                                :style="{transform: `rotate(${profit(recipe, 'buy_price') < 0 ? 90 : -90}deg)`}"
                                width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path 
                                    :fill="profit(recipe, 'buy_price') < 0 ? `var(--color-down)` : `var(--color-up)`"
                                    d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z"
                                />
                            </svg>
                            <p>Profit (Buy Price): </p>
                        </span>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label" 
                                v-for="gold in formatValue(
                                    profit(recipe, 'buy_price')
                                )"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </span>
                    </span>  

                    <!-- PROFIT (SELL PRICE) -->
                    <span class="output">
                        <span class="flex-row-flex-start">
                            <svg 
                                :style="{transform: `rotate(${profit(recipe, 'sell_price') < 0 ? 90 : -90}deg)`}"
                                width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path 
                                    :fill="profit(recipe, 'sell_price') < 0 ? `var(--color-down)` : `var(--color-up)`"
                                    d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z"
                                />
                            </svg>
                            <p>Profit (Sell Price): </p>
                        </span>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label" 
                                v-for="gold in formatValue(
                                    profit(recipe, 'sell_price')
                                )"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </span>
                    </span> 

                    <!-- CURRENCY (if applicable) -->
                    <span 
                        class="output"
                        v-if="currency != 0"
                    >
                        <span class="flex-row-flex-start">
                            <img :src="currencyIcon" :alt="currencyName" :title="currencyName">
                            <p>Currency Value: </p>
                        </span>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label" 
                                v-for="gold in formatValue(
                                    buyOrder == 'buy_price' ? profit(recipe, 'buy_price') / currency : profit(recipe, 'sell_price') / currency
                                )"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </span>
                    </span> 
                </div>
            </div>
            <!-- 
                * 
                * RECIPE TREE
                *
                * Semeantics here because the <RecipeTree/> uses recursion 
            -->
            <Transition name="fade">
                <RecipeTree 
                    v-if="recipe"
                    :recipe="recipe"  
                    @update-recipe="updateRecipeTree"
                />
            </Transition>
        </div> <!-- End of content section -->
    </section>

    <Footer/>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import { debounce } from 'lodash'

import { formatValue, showRarityColor } from '@/js/vue/composables/FormatFunctions.js'
import { user, buyOrder, sellOrder, tax } from '@/js/vue/composables/Global'

// IMAGES
import TradingPost from '@/imgs/icons/Trading_Post.png'
import Armor from '@/imgs/icons/Armor.png'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import TwoColSection from '@/js/vue/components/general/TwoColSection.vue'
import Loading from '@/js/vue/components/general/Loading.vue'

import RecipeTree from '@/js/vue/components/general/RecipeTree.vue'

const route = useRoute(),
    router = useRouter(); 

const searchQuery = ref(null),
    idRequest = ref(null),
    searchResults = ref(null),
    url = ref(null);

const quantityRequest = ref(1);

const recipe = ref(null);
const currency = ref(0),
    currencyName = ref(null),
    currencyIcon = ref(null);

const loadingToggle = ref(false);



// * UPDATE ENTIRE RECIPE TREE
// *
// * This func is called by:
// * => By default once recipe is fetched
// * => Anytime a user choses either TP or crafting price
const updateRecipeTree = (selectedIngredient, userPreference) => {
    currency.value = 0;
    
    // Update prices on all ingredients 
    updatePrices(recipe.value, selectedIngredient, userPreference);
    // For the section output item, choose the preferences of either tp or crafting to determine how the tree will be displayed
    choosePreference(recipe.value, selectedIngredient, userPreference);
}
// * CHOOSE ITEM PREFERENCES 'TP' or 'Crafting' etc
// *
// * By having a preferences, the recipe tree will choose the best and cheapest path
const choosePreference = (currentIngredient, selectedIngredient, userPreference) => {
    console.log('selected ingredient: ', selectedIngredient);
    // If the user selected a specific ingredient
    if (selectedIngredient){
        if (currentIngredient == selectedIngredient){ 
            switch (userPreference){
                case 'Crafting':
                    return currentIngredient['preference'] = 'Crafting';
                case 'TP':
                    return currentIngredient['preference'] = 'TP';
                case 'owned':
                    return currentIngredient['preference'] = 'owned';
            }
        } 
    // If func is called without specifing an ingredient
    // Check if it's better to craft or to buy from TP
    } 
    else if (currentIngredient.craftingValue < currentIngredient.buy_price || currentIngredient.buy_price == 0){
        return currentIngredient['preference'] = 'Crafting';
    } 
    else {
        return currentIngredient['preference'] = 'TP';
    }
}
// *
// * UPDATE PRICES 
// *
// * Updates the prices of the buy order of each ingredient depending on their preferences
const updatePrices = (recipe, selectedIngredient, userPreference) => {
    let tempValue = 0;

    //console.log('chosen recipe: ', recipe);
    recipe.ingredients.forEach(ingredient => {
        let prevCraftingValue = 0;

        if (ingredient.hasOwnProperty('ingredients')){
            choosePreference(ingredient, selectedIngredient, userPreference);
            prevCraftingValue = updatePrices(ingredient, selectedIngredient, userPreference); 
        }
        if (ingredient.hasOwnProperty('craftingValue')){
            prevCraftingValue = ingredient.craftingValue; 
        } else {
            prevCraftingValue = Math.min(ingredient.buy_price, ingredient.sell_price);
        }
        if (ingredient.preference == 'TP'){
            if (buyOrder.value == 'buy_price'){
                prevCraftingValue = ingredient.buy_price; 
            } else {
                prevCraftingValue = ingredient.sell_price;
            }
        }
        if (ingredient.preference == 'owned'){
            prevCraftingValue = 0;
        }

        tempValue += prevCraftingValue; 
    })
    return recipe.craftingValue = tempValue; 
    // Go through each recipe in the recipe tree
    // recipe.ingredients.forEach((ingredient) => {
    //     // If another recipe exists => 
    //     if (ingredient.hasOwnProperty('ingredients')){
    //         // Check preferences first, then decide if it's better to buy or craft
    //         choosePreference(ingredient, selectedIngredient, userPreference);
    //         // Then with the preferences, update the prices
    //         switch (ingredient.preference){
    //             case "TP":
    //                 tempValue += buyOrder.value == 'buy_price' ? ingredient.buy_price : ingredient.sell_price;
    //                 updatePrices(ingredient, selectedIngredient, userPreference);
    //                 break;
    //             case "crafting":
    //                 tempValue += updatePrices(ingredient, selectedIngredient, userPreference);
    //                 break;
    //             case "owned":
    //                 tempValue += 0;
    //                 updatePrices(ingredient, selectedIngredient, userPreference);
    //                 break;
    //         }
    //         // Unless the user has specified this ingredient is owned
    //     } else if (ingredient.preference == 'owned'){
    //         tempValue += 0; 
    //         //updatePrices(ingredient, selectedIngredient, userPreference);
    //     } else {
    //         tempValue += buyOrder.value == 'buy_price' ? ingredient.buy_price : ingredient.sell_price;
    //         // Check if the ingredietn is a Currency
    //         if (ingredient.type == "Currency"){
    //             currency.value += ingredient.count; 
    //             currencyIcon.value = ingredient.icon;
    //             currencyName.value = ingredient.name;
    //         }
    //     }
    // })
    // return recipe.craftingValue = tempValue; 
}
// To display the profits of a recipe
const profit = (recipe, priceType) => {
    switch (priceType){
        case "buy_price":
            return (recipe.buy_price * tax.value ) - recipe.craftingValue ; 
        case "sell_price":
            return (recipe.sell_price * tax.value ) - recipe.craftingValue; 
    }
    
}
// Watch ths search bar 
// If character lenghth > 3 => apply search results
// Use debounce so the func does not get called every character change
// Without debounce, breaks website due to too many requests at once
watch(searchQuery, debounce(async (query) => {
    if (query.length > 3){
        try {
            const response = await fetch(`../api/recipes/search-recipes?request=${query}`);
            const responseData = await response.json(); 
            searchResults.value = responseData; 

        } catch (error) {
            console.log("Trouble with search query: ", error); 
        }
    }
}, 500));


const handleRecipeRequest = () => {
    const requestedURL = searchQuery.value,
        requestedID = idRequest.value,
        requestedQuantity = quantityRequest.value; 
    
    if (requestedURL){
        fetchRequestedRecipe(requestedURL, requestedID, requestedQuantity);
    }
}

const fetchRequestedRecipe = async (requestedRecipe, requestedID, requestedQuantity) => {
    try{
        loadingToggle.value = true; 
        const encodedRecipe = encodeURIComponent(requestedRecipe);

        router.replace({
            query: {
                requestedRecipe: encodedRecipe,
                id: requestedID,
                qty: requestedQuantity,
            }});

        const url = `../api/recipes/${encodedRecipe}/${requestedID}/${requestedQuantity}`;

        const response = await fetch(url);
        const responseData = await response.json(); 
        recipe.value = responseData;

        console.log('url: ', url);
        // console.log('recipe merp: ', recipe.value);

        // Loading choya disappears once data is received
        if (recipe.value){
            loadingToggle.value = false; 
        }
        // Review prices and adjust according to the best treSe path
        updateRecipeTree();

    } catch (error){
        console.log('Error fetching data', error);
    }
}
/*
 * WHEN LOADING
 * 1. Check if there's a requestedRecipe in the URL. Ex: tools/recipe-value?requestedRecipe=Jeweled%2520Damask%2520Patch
 * 2. If yes => decode and request that recipe
 * This is for when a user copied the URL from when they searched or from another page (ie research notes) 
 */
onMounted(() => {
    if (route.query.requestedRecipe){
        url.value = decodeURIComponent(route.query.requestedRecipe);
        idRequest.value = route.query.id;
        quantityRequest.value = route.query.qty; 
    }
    
    if (url.value){
        //console.log(url.value);
        fetchRequestedRecipe(url.value, idRequest.value, quantityRequest.value);
    }
})

</script>

<style scoped>
.search-container{
    display: flex;
    align-items: flex-start;
    gap: var(--gap-content);
    padding-block: var(--gap-general);
    border-bottom: var(--border-bottom);
}

.search-query-container{
    display: flex;
    flex-direction: column;
    margin: var(--margin-block-general);
    padding: 0;
    height: fit-content;
    max-height: 200px;
    overflow-y: auto;
}
.search-query-container li:hover{
    background-color: var(--hover-bkg-fade);
}
.search-query-container li{
    display: flex;
    align-items: center;
    gap: 5px;
    padding: var(--padding-search-li);
}
.search-query-container li img{
    width: 20px;
    height: 20px;
}
.search-query-container button{
    border: none;
    background-color: unset;
    padding: 0;
}
.search-query-container button:focus{
    outline: none;
    background-color: var(--hover-bkg-fade);
}
span.output{
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 50px;
}
span.output p > img {
    width: 20px;
    height: 20px;
    vertical-align: middle;
}

@media (max-width: 768px){
    .search-container{
        flex-direction: column;
    }
}


</style>