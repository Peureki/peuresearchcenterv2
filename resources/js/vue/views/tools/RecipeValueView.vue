<template>
    <Nav/>
    <main>
        <Header page-name="Recipe Value"/>
        <TwoColSection>
            <template v-slot:content1>
                <!-- * RECIPE FORM
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
                            <a 
                                v-for="recipe in searchResults"
                                @click="searchQuery = recipe.name; handleRecipeRequest();"
                            >
                                <li>
                                    <img :src="recipe.icon" :alt="recipe.name" :title="recipe.name">
                                    {{ recipe.name }}
                                </li> 
                            </a>
                        </ul>
                    </Transition>
                    <div class="flex-row-space-btw">
                        <input
                            type="number"
                            min="1"
                            v-model="quantityRequest"
                        >
                        <span class="input-radio">
                            <input 
                                type="radio" 
                                id="own-ingredients" 
                                value="true" 
                                @change="updateRecipeToOwned()"
                                v-model="ownIngredientsToggle"
                            >
                            <label for="own-ingredients">Own Ingredients</label>
                        </span>
                        <button class="submit" type="submit">Fetch Recipe</button>
                        
                    </div>
                </form>

                <Loading v-if="loadingToggle"/>
            </template>

            <template v-slot:content2 v-if="recipe">
                <div class="display-output-container">
                    <span class="output">
                        <h6><img :src="TradingPost" alt="Trading Post" title="Trading Post"> Trading Post</h6>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label" 
                                v-for="gold in formatValue(
                                    buyOrderSetting == 'buy_price' ? recipe[0].buy_price : recipe[0].sell_price
                                )"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </span>
                    </span> 

                    <span class="output">
                        <h6><img :src="Armor" alt="Crafting" title="Crafting"> Crafting Costs: </h6>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label" 
                                v-for="gold in formatValue(
                                    recipe[0].preference ? recipe[0].craftingValue : recipe[0].buy_price
                                )"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </span>
                    </span>   
                    
                    <span class="output">
                        <h6>
                            <svg 
                                :style="{transform: `rotate(${profit(recipe[0], 'buy_price') < 0 ? 90 : -90}deg)`}"
                                width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path 
                                    :fill="profit(recipe[0], 'buy_price') < 0 ? `var(--color-down)` : `var(--color-up)`"
                                    d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z"
                                />
                            </svg>
                            Profit (Buy Price, Tax @ {{ taxSetting }}): 
                        </h6>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label" 
                                v-for="gold in formatValue(
                                    profit(recipe[0], 'buy_price')
                                )"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </span>
                    </span>  

                    <span class="output">
                        <h6>
                            <svg 
                                :style="{transform: `rotate(${profit(recipe[0], 'sell_price') < 0 ? 90 : -90}deg)`}"
                                width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path 
                                    :fill="profit(recipe[0], 'sell_price') < 0 ? `var(--color-down)` : `var(--color-up)`"
                                    d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z"
                                />
                            </svg>
                            Profit (Sell Price, Tax @ {{ taxSetting }}): 
                        </h6>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label" 
                                v-for="gold in formatValue(
                                    profit(recipe[0], 'sell_price')
                                )"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </span>
                    </span> 

                    <span 
                        class="output"
                        v-if="currency != 0"
                    >
                        <h6><img :src="currencyIcon" :alt="currencyName" :title="currencyName">Currency Value (per {{ currencyName }}s): </h6>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label" 
                                v-for="gold in formatValue(
                                    buyOrderSetting == 'buy_price' ? profit(recipe[0], 'buy_price') / currency : profit(recipe[0], 'sell price') / currency
                                )"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </span>
                    </span> 
                </div>
            </template>
        </TwoColSection>
        <section>
            <article>
                <Transition name="fade">
                    <RecipeTree 
                        v-if="recipe"
                        :recipe="recipe"  
                        @update-recipe="updateRecipeTree"
                    />
                </Transition>
            </article>
        </section>
    </main>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import { debounce } from 'lodash'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'

// IMAGES
import TradingPost from '@/imgs/icons/Trading_Post.png'
import Armor from '@/imgs/icons/Armor.png'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import TwoColSection from '@/js/vue/components/general/TwoColSection.vue'
import Loading from '@/js/vue/components/general/Loading.vue'

import RecipeTree from '@/js/vue/components/general/RecipeTree.vue'

const route = useRoute(),
    router = useRouter(); 

const searchQuery = ref(null),
    searchResults = ref(null);

const quantityRequest = ref(1);

const recipe = ref(null);
const currency = ref(0),
    currencyName = ref(null),
    currencyIcon = ref(null);

const recipesDB = ref(null);

const loadingToggle = ref(false),
    ownIngredientsToggle = ref(false);

const taxSetting = ref(localStorage.taxSetting),
    buyOrderSetting = ref(localStorage.buyOrderSetting),
    sellOrderSetting = ref(localStorage.sellOrderSetting);


const updateRecipeToOwned = () => {
    
}

// * UPDATE ENTIRE RECIPE TREE
// *
// * This func is called by:
// * => By default once recipe is fetched
// * => Anytime a user choses either TP or crafting price
const updateRecipeTree = (selectedIngredient, userPreference) => {
    console.log(recipe.value);
    currency.value = 0;
    // For the main output item, choose the preferences of either tp or crafting to determine how the tree will be displayed
    choosePreference(recipe.value[0], selectedIngredient, userPreference);
    // Update prices on all ingredients 
    updatePrices(recipe.value[0], selectedIngredient, userPreference);
}
// * CHOOSE ITEM PREFERENCES 'tp' or 'crafting'
// *
// * By having a preferences, the recipe tree will choose the best and cheapest path
const choosePreference = (currentIngredient, selectedIngredient, userPreference) => {
    if (selectedIngredient){
        if (currentIngredient == selectedIngredient){ 
            console.log('this happened')
            switch (userPreference){
                case 'crafting':
                    return currentIngredient['preference'] = 'crafting';
                case 'tp':
                    return currentIngredient['preference'] = 'tp';
                case 'owned':
                    return currentIngredient['preference'] = 'owned';
            }
        } 
    } else if (currentIngredient.craftingValue < currentIngredient.buy_price || currentIngredient.buy_price == 0){
        return currentIngredient['preference'] = 'crafting';
    } else {
        return currentIngredient['preference'] = 'tp';
    }
}

const updatePrices = (recipe, selectedIngredient, userPreference) => {
    let tempValue = 0
    recipe.ingredients.forEach((ingredient) => {
        if (ingredient.hasOwnProperty('ingredients')){
            choosePreference(ingredient, selectedIngredient, userPreference);
            
            switch (ingredient.preference){
                case "tp":
                    tempValue += buyOrderSetting.value == 'buy_price' ? ingredient.buy_price : ingredient.sell_price;
                    updatePrices(ingredient, selectedIngredient, userPreference);
                    break;
                case "crafting":
                    tempValue += updatePrices(ingredient, selectedIngredient, userPreference);
                    break;
                case "owned":
                    tempValue += 0;
                    updatePrices(ingredient, selectedIngredient, userPreference);
                    break;
            }
        } else {
            tempValue += buyOrderSetting.value == 'buy_price' ? ingredient.buy_price : ingredient.sell_price;

            if (ingredient.type == "Currency"){
                currency.value += ingredient.count; 
                currencyIcon.value = ingredient.icon;
                currencyName.value = ingredient.name;
            }
        }
    })
    return recipe.craftingValue = tempValue; 
}

const profit = (recipe, priceType) => {
    switch (priceType){
        case "buy_price":
            return (recipe.buy_price - recipe.craftingValue) * localStorage.taxSetting; 
        case "sell_price":
            return (recipe.sell_price - recipe.craftingValue) * localStorage.taxSetting; 
    }
    
}

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
        requestedQuantity = quantityRequest.value; 
    
    if (requestedURL){
        fetchRequestedRecipe(requestedURL, requestedQuantity);
    }
}

const fetchRequestedRecipe = async (requestedRecipe, requestedQuantity) => {
    try{
        loadingToggle.value = true; 
        const encodedRecipe = encodeURIComponent(requestedRecipe);
        router.replace({
            query: {
                requestedRecipe: encodedRecipe
            }});

        const response = await fetch(`../api/recipes/${requestedRecipe}/${requestedQuantity}`);
        const responseData = await response.json(); 
        recipe.value = responseData;

        // Loading choya disappears once data is received
        if (recipe.value){
            loadingToggle.value = false; 
        }
        // Review prices and adjust according to the best tree path
        updateRecipeTree();

    } catch (error){
        console.log('Error fetching data', error);
    }
}

</script>

<style scoped>
.search-query-container{
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
.recipe-form{
    display: flex;
    justify-content: center;
    flex-direction: column;
    width: fit-content;
}
.display-output-container{
    display: flex;
    flex-direction: column;
    width: fit-content;
    gap: 5px;

}
span.output{
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 50px;
}
span.output h6 > img {
    width: 20px;
    height: 20px;
    vertical-align: middle;
}


</style>