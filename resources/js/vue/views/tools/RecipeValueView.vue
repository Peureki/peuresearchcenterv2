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
                <div class="flex-column">
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

                    <!-- 
                        * 
                        * FAVORITES ICON
                        * Allow users to add or remove item to favorites list
                        *
                    -->
                    <div class="img-and-label" v-if="recipe">
                        <svg @click="handleFavorite(recipe)" class="icon clickable" width="20" height="19" viewBox="0 0 20 19" :fill="alreadyFavorite(recipe.id)" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.88659 16.6603L8.88587 16.6596C6.30104 14.3157 4.19578 12.4033 2.73088 10.6111C1.27148 8.82559 0.5 7.22062 0.5 5.5C0.5 2.68674 2.69555 0.5 5.5 0.5C7.08885 0.5 8.62206 1.24223 9.62058 2.40564L10 2.84771L10.3794 2.40564C11.3779 1.24223 12.9112 0.5 14.5 0.5C17.3045 0.5 19.5 2.68674 19.5 5.5C19.5 7.22062 18.7285 8.82559 17.2691 10.6111C15.8042 12.4033 13.699 14.3157 11.1141 16.6596L11.1134 16.6603L10 17.6738L8.88659 16.6603Z" stroke="var(--color-link)"/>
                        </svg>
                        <p>Save this recipe</p>
                    </div>
                </div>
            

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

            <!--
                *
                * FAVORITES LIST
                *
            -->
            <div class="mobile-currency-container" v-if="sortedFavorites && sortedFavorites.length != 0">
                <h3>Favorites</h3>
                <p class="small-subtitle">Values assume all crafting steps</p>
                <div v-for="(recipe, index) in sortedFavorites" class="mobile-currency-card">
                    <div class="label-and-cta">
                        <!-- 
                            * ICON & NAME
                        -->
                        <div class="img-and-label">
                            <img class="icon" :src="recipe.icon" :alt="recipe.name" :title="recipe.name">
                            <p>{{ recipe.count }} {{ recipe.name }}</p>
                        </div>
                        <!-- 
                            * SVG CTAS
                        -->
                        <div class="svg-ctas">
                            <svg @click="handleFavorite(recipe)" class="icon clickable" width="20" height="19" viewBox="0 0 20 19" fill="var(--color-link)" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.88659 16.6603L8.88587 16.6596C6.30104 14.3157 4.19578 12.4033 2.73088 10.6111C1.27148 8.82559 0.5 7.22062 0.5 5.5C0.5 2.68674 2.69555 0.5 5.5 0.5C7.08885 0.5 8.62206 1.24223 9.62058 2.40564L10 2.84771L10.3794 2.40564C11.3779 1.24223 12.9112 0.5 14.5 0.5C17.3045 0.5 19.5 2.68674 19.5 5.5C19.5 7.22062 18.7285 8.82559 17.2691 10.6111C15.8042 12.4033 13.699 14.3157 11.1141 16.6596L11.1134 16.6603L10 17.6738L8.88659 16.6603Z" stroke="var(--color-link)"/>
                            </svg>

                            <svg @click="fetchRequestedRecipe(recipe.name, recipe.id, 1)" class="icon clickable" width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 5.9V4.2C13.55 3.96667 14.1127 3.79167 14.688 3.675C15.2633 3.55833 15.8673 3.5 16.5 3.5C16.9333 3.5 17.3583 3.53333 17.775 3.6C18.1917 3.66667 18.6 3.75 19 3.85V5.45C18.6 5.3 18.1957 5.18767 17.787 5.113C17.3783 5.03833 16.9493 5.00067 16.5 5C15.8667 5 15.2583 5.07933 14.675 5.238C14.0917 5.39667 13.5333 5.61733 13 5.9ZM13 11.4V9.7C13.55 9.46667 14.1127 9.29167 14.688 9.175C15.2633 9.05833 15.8673 9 16.5 9C16.9333 9 17.3583 9.03333 17.775 9.1C18.1917 9.16667 18.6 9.25 19 9.35V10.95C18.6 10.8 18.1957 10.6873 17.787 10.612C17.3783 10.5367 16.9493 10.4993 16.5 10.5C15.8667 10.5 15.2583 10.575 14.675 10.725C14.0917 10.875 13.5333 11.1 13 11.4ZM13 8.65V6.95C13.55 6.71667 14.1127 6.54167 14.688 6.425C15.2633 6.30833 15.8673 6.25 16.5 6.25C16.9333 6.25 17.3583 6.28333 17.775 6.35C18.1917 6.41667 18.6 6.5 19 6.6V8.2C18.6 8.05 18.1957 7.93733 17.787 7.862C17.3783 7.78667 16.9493 7.74933 16.5 7.75C15.8667 7.75 15.2583 7.82933 14.675 7.988C14.0917 8.14667 13.5333 8.36733 13 8.65ZM5.5 12C6.28333 12 7.046 12.0877 7.788 12.263C8.53 12.4383 9.26733 12.7007 10 13.05V3.2C9.31667 2.8 8.59167 2.5 7.825 2.3C7.05833 2.1 6.28333 2 5.5 2C4.9 2 4.304 2.05833 3.712 2.175C3.12 2.29167 2.54933 2.46667 2 2.7V12.6C2.58333 12.4 3.16267 12.25 3.738 12.15C4.31333 12.05 4.90067 12 5.5 12ZM12 13.05C12.7333 12.7 13.471 12.4377 14.213 12.263C14.955 12.0883 15.7173 12.0007 16.5 12C17.1 12 17.6877 12.05 18.263 12.15C18.8383 12.25 19.4173 12.4 20 12.6V2.7C19.45 2.46667 18.879 2.29167 18.287 2.175C17.695 2.05833 17.0993 2 16.5 2C15.7167 2 14.9417 2.1 14.175 2.3C13.4083 2.5 12.6833 2.8 12 3.2V13.05ZM11 16C10.2 15.3667 9.33333 14.875 8.4 14.525C7.46667 14.175 6.5 14 5.5 14C4.8 14 4.11267 14.0917 3.438 14.275C2.76333 14.4583 2.11733 14.7167 1.5 15.05C1.15 15.2333 0.812667 15.225 0.488 15.025C0.163333 14.825 0.000666667 14.5333 0 14.15V2.1C0 1.91667 0.046 1.74167 0.138 1.575C0.23 1.40833 0.367333 1.28333 0.55 1.2C1.31667 0.8 2.11667 0.5 2.95 0.3C3.78333 0.1 4.63333 0 5.5 0C6.46667 0 7.41267 0.125 8.338 0.375C9.26333 0.625 10.1507 1 11 1.5C11.85 1 12.7377 0.625 13.663 0.375C14.5883 0.125 15.534 0 16.5 0C17.3667 0 18.2167 0.1 19.05 0.3C19.8833 0.5 20.6833 0.8 21.45 1.2C21.6333 1.28333 21.771 1.40833 21.863 1.575C21.955 1.74167 22.0007 1.91667 22 2.1V14.15C22 14.5333 21.8377 14.825 21.513 15.025C21.1883 15.225 20.8507 15.2333 20.5 15.05C19.8833 14.7167 19.2377 14.4583 18.563 14.275C17.8883 14.0917 17.2007 14 16.5 14C15.5 14 14.5333 14.175 13.6 14.525C12.6667 14.875 11.8 15.3667 11 16Z" fill="var(--color-link)"/>
                                <title>View Recipe of {{ recipe.name }}</title>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="value-container">
                        <!-- 
                            * BUY PRICE VALUES
                        -->
                        <div class="img-and-label">
                            <p class="small-subtitle">Buy Price</p>
                            <svg 
                                :style="{transform: profitDegrees(craftingDifference(recipe, 'buy_price'))}"
                                width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path 
                                    :fill="profitColors(craftingDifference(recipe, 'buy_price'))"
                                    d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z"
                                />
                            </svg>
                        
                            <span class="gold-label-container">
                                <span 
                                    class="gold-label" 
                                    v-for="gold in formatValue(
                                        craftingDifference(recipe, 'buy_price')
                                    )"
                                >
                                    {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                                </span>
                            </span>
                        </div>
                        <!-- 
                            * SELL PRICE VALUES
                        -->
                        <div class="img-and-label">
                            <p class="small-subtitle">Sell Price</p>
                            <svg 
                                :style="{transform: profitDegrees(craftingDifference(recipe, 'sell_price'))}"
                                width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path 
                                    :fill="profitColors(craftingDifference(recipe, 'sell_price'))"
                                    d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z"
                                />
                            </svg>
                        
                            <span class="gold-label-container">
                                <span 
                                    class="gold-label" 
                                    v-for="gold in formatValue(
                                        craftingDifference(recipe, 'sell_price')
                                    )"
                                >
                                    {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End of content section -->

        
    </section>
    <Loading v-if="loadingToggle" :width="200" :height="200"/>
    <Footer/>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import { debounce } from 'lodash'

import { formatValue, showRarityColor } from '@/js/vue/composables/FormatFunctions.js'
import { user, buyOrder, sellOrder, tax, favorites } from '@/js/vue/composables/Global'
import { getAuthUser } from '@/js/vue/composables/Authentication'
import { getRecipeValue } from '@/js/vue/composables/BasicFunctions'

// IMAGES
import TradingPost from '@/imgs/icons/Trading_Post.png'
import Armor from '@/imgs/icons/Armor.png'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import TwoColSection from '@/js/vue/components/general/TwoColSection.vue'
import Loading from '@/js/vue/components/general/Loading.vue'

import RecipeTree from '@/js/vue/components/general/RecipeTree.vue'
import axios from 'axios'

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

// * FAVORITES
const favoriteRecipes = ref(null);

const favoritesUrl = computed(() => {
    return `../api/tools/favorite-recipes/${buyOrder.value}/${JSON.stringify(favorites.value.recipes)}`
})

// *
// * GET FAVORITE RECIPES FROM DATABASE
// *
const getFavoriteRecipes = async (url) => {
    loadingToggle.value = true; 
    try {
        const response = await fetch(url);
        const responseData = await response.json(); 

        if (response){
            // Update favorite recipes
            favoriteRecipes.value = responseData;
            console.log('fav recipes: ', favoriteRecipes.value);
            loadingToggle.value = false;
        }

    } catch (error){
        console.log('Could not get favorite recipes: ', error);
        loadingToggle.value = false;
    }
}

// Change color based on value 
const profitColors = (value) => {
    return value > 0 ? 'var(--color-up)' : 'var(--color-down)';
}
// Change tranform degrees based on value
const profitDegrees = (value) => {
    return value > 0 ? `rotate(-90deg)` : `rotate(90deg)`;
}
// If recipe ID is already a favorite, fill svg heart
const alreadyFavorite = (recipeID) => {
    return favorites.value.recipes.includes(recipeID) ? 'var(--color-link)' : 'none'   
}
// *
// * CRAFTING DIFFERENCE
// * Return the crafting difference between the buy and sell price of the recipe
const craftingDifference = (recipe, priceType) => {
    switch (priceType){
        case 'buy_price': return (recipe.buy_price * tax.value) - recipe.craftingValue; 
        case 'sell_price': return (recipe.sell_price * tax.value) - recipe.craftingValue;
    }
}
// Sort favorite recipes based on crafting differences and user buy order settings
const sortedFavorites = computed(() => {
    if (favoriteRecipes.value){
        return favoriteRecipes.value.sort((a, b) => craftingDifference(b, buyOrder.value) - craftingDifference(a, buyOrder.value));
    }
    
})

const handleFavorite = async (recipe) => {
    console.log('recipe merp: ', recipe);

    if (!favorites.value.recipes){
        favorites.value.recipes = [];
    }
    if (favorites.value.recipes){
        const index = favorites.value.recipes.indexOf(recipe.id); 
        // If item id NOT in array
        if (index == -1){  
            favorites.value.recipes = [...favorites.value.recipes, recipe.id]; 
        } 
        // If item id IS in array
        else {
            favorites.value.recipes = [
                ...favorites.value.recipes.slice(0, index),
                ...favorites.value.recipes.slice(index + 1)
            ]
        }
    } else {
        favorites.value.recipes = [recipe.id]; 
    }

    try {
        const response = await axios.post('../api/user/saveFavorites', {
            favorites: favorites.value,
        })

        if (response){
            console.log('Saved favorites!', favorites.value, response);
            await getFavoriteRecipes(favoritesUrl.value);
        }
    } catch (error) {
        console.log('Could not save Favorites: ', error); 
    }
}



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
onMounted( async () => {
    await getAuthUser();

    if (route.query.requestedRecipe){
        url.value = decodeURIComponent(route.query.requestedRecipe);
        idRequest.value = route.query.id;
        quantityRequest.value = route.query.qty; 
    }
    
    if (url.value){
        //console.log(url.value);
        fetchRequestedRecipe(url.value, idRequest.value, quantityRequest.value);
    }
    if (favoritesUrl.value){
        getFavoriteRecipes(favoritesUrl.value);
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