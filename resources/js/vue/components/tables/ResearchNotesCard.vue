<template>
    <PageButtons
        v-if="researchNotes && !isFavorite"
        :data-array="researchNotes"
        @new-url="handleNewUrl"
    />

    <div class="mobile-currency-container">
        <div v-for="(item, index) in displayResearchNotes" :key="index" class="mobile-currency-card">
            <div class="label-and-cta">
                <!--
                    * 
                    * QUANTITY, NAME, DISCIPLINES
                    *
                -->
                <div class="img-and-label">
                    <!-- Icon -->
                    <img class="icon" :src="item.icon" :alt="item.name" :title="item.name">
                    <!-- Item Count, Name -->
                    <p class="item-name" :style="{color: showRarityColor(item.rarity)}">{{ item.output_item_count }} {{ item.name }}</p>
                    <!-- Discipline icon -->
                    <div class="img-and-label">
                        <img v-for="discipline in item.disciplines" class="icon" :src="matchDiscipline(discipline)" :alt="discipline" :title="discipline"> 
                    </div>

                    <p class="small-subtitle">{{ item.preference }}</p>
                </div>

                <!--
                    * 
                    * SVG CTAs
                    *
                -->
                <div class="svg-ctas">
                    <svg class="icon clickable" :class="{favorite: item.favorite}" @click="handleFavorite(item)" width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.88659 16.6603L8.88587 16.6596C6.30104 14.3157 4.19578 12.4033 2.73088 10.6111C1.27148 8.82559 0.5 7.22062 0.5 5.5C0.5 2.68674 2.69555 0.5 5.5 0.5C7.08885 0.5 8.62206 1.24223 9.62058 2.40564L10 2.84771L10.3794 2.40564C11.3779 1.24223 12.9112 0.5 14.5 0.5C17.3045 0.5 19.5 2.68674 19.5 5.5C19.5 7.22062 18.7285 8.82559 17.2691 10.6111C15.8042 12.4033 13.699 14.3157 11.1141 16.6596L11.1134 16.6603L10 17.6738L8.88659 16.6603Z" stroke="var(--color-link)"/>
                        <title>Favorite {{ item.name }}</title>
                    </svg>

                    <svg class="icon clickable" @click="wiki(item.name)" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 0C11.2311 0 8.52431 0.821086 6.22202 2.35943C3.91973 3.89777 2.12532 6.08427 1.06569 8.64243C0.00606596 11.2006 -0.271181 14.0155 0.269012 16.7313C0.809205 19.447 2.14258 21.9416 4.10051 23.8995C6.05845 25.8574 8.55301 27.1908 11.2687 27.731C13.9845 28.2712 16.7994 27.9939 19.3576 26.9343C21.9157 25.8747 24.1022 24.0803 25.6406 21.778C27.1789 19.4757 28 16.7689 28 14C28 10.287 26.525 6.72601 23.8995 4.1005C21.274 1.475 17.713 0 14 0ZM26 13H20C19.8833 9.31709 18.9291 5.70915 17.21 2.45C19.5786 3.0979 21.6914 4.45684 23.2632 6.34342C24.8351 8.23 25.7903 10.5534 26 13ZM14 26C13.7769 26.015 13.5531 26.015 13.33 26C11.2583 22.6962 10.1085 18.8981 10 15H18C17.9005 18.8953 16.7612 22.6932 14.7 26C14.467 26.0164 14.2331 26.0164 14 26ZM10 13C10.0995 9.10468 11.2388 5.30682 13.3 2C13.7453 1.94997 14.1947 1.94997 14.64 2C16.7223 5.3008 17.8825 9.09906 18 13H10ZM10.76 2.45C9.0513 5.71164 8.10746 9.31945 8.00001 13H2.00001C2.20971 10.5534 3.16495 8.23 4.7368 6.34342C6.30865 4.45684 8.42144 3.0979 10.79 2.45H10.76ZM2.05001 15H8.05001C8.15437 18.6798 9.09478 22.2875 10.8 25.55C8.43887 24.8951 6.33478 23.5332 4.77056 21.6472C3.20634 19.7612 2.25695 17.4415 2.05001 15ZM17.21 25.55C18.9291 22.2908 19.8833 18.6829 20 15H26C25.7903 17.4466 24.8351 19.77 23.2632 21.6566C21.6914 23.5432 19.5786 24.9021 17.21 25.55Z" fill="var(--color-link)"/>
                        <title>Wiki</title>
                    </svg>

                    <svg @click="getRecipeValue(item.name, item.id, 1)" class="icon clickable" width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 5.9V4.2C13.55 3.96667 14.1127 3.79167 14.688 3.675C15.2633 3.55833 15.8673 3.5 16.5 3.5C16.9333 3.5 17.3583 3.53333 17.775 3.6C18.1917 3.66667 18.6 3.75 19 3.85V5.45C18.6 5.3 18.1957 5.18767 17.787 5.113C17.3783 5.03833 16.9493 5.00067 16.5 5C15.8667 5 15.2583 5.07933 14.675 5.238C14.0917 5.39667 13.5333 5.61733 13 5.9ZM13 11.4V9.7C13.55 9.46667 14.1127 9.29167 14.688 9.175C15.2633 9.05833 15.8673 9 16.5 9C16.9333 9 17.3583 9.03333 17.775 9.1C18.1917 9.16667 18.6 9.25 19 9.35V10.95C18.6 10.8 18.1957 10.6873 17.787 10.612C17.3783 10.5367 16.9493 10.4993 16.5 10.5C15.8667 10.5 15.2583 10.575 14.675 10.725C14.0917 10.875 13.5333 11.1 13 11.4ZM13 8.65V6.95C13.55 6.71667 14.1127 6.54167 14.688 6.425C15.2633 6.30833 15.8673 6.25 16.5 6.25C16.9333 6.25 17.3583 6.28333 17.775 6.35C18.1917 6.41667 18.6 6.5 19 6.6V8.2C18.6 8.05 18.1957 7.93733 17.787 7.862C17.3783 7.78667 16.9493 7.74933 16.5 7.75C15.8667 7.75 15.2583 7.82933 14.675 7.988C14.0917 8.14667 13.5333 8.36733 13 8.65ZM5.5 12C6.28333 12 7.046 12.0877 7.788 12.263C8.53 12.4383 9.26733 12.7007 10 13.05V3.2C9.31667 2.8 8.59167 2.5 7.825 2.3C7.05833 2.1 6.28333 2 5.5 2C4.9 2 4.304 2.05833 3.712 2.175C3.12 2.29167 2.54933 2.46667 2 2.7V12.6C2.58333 12.4 3.16267 12.25 3.738 12.15C4.31333 12.05 4.90067 12 5.5 12ZM12 13.05C12.7333 12.7 13.471 12.4377 14.213 12.263C14.955 12.0883 15.7173 12.0007 16.5 12C17.1 12 17.6877 12.05 18.263 12.15C18.8383 12.25 19.4173 12.4 20 12.6V2.7C19.45 2.46667 18.879 2.29167 18.287 2.175C17.695 2.05833 17.0993 2 16.5 2C15.7167 2 14.9417 2.1 14.175 2.3C13.4083 2.5 12.6833 2.8 12 3.2V13.05ZM11 16C10.2 15.3667 9.33333 14.875 8.4 14.525C7.46667 14.175 6.5 14 5.5 14C4.8 14 4.11267 14.0917 3.438 14.275C2.76333 14.4583 2.11733 14.7167 1.5 15.05C1.15 15.2333 0.812667 15.225 0.488 15.025C0.163333 14.825 0.000666667 14.5333 0 14.15V2.1C0 1.91667 0.046 1.74167 0.138 1.575C0.23 1.40833 0.367333 1.28333 0.55 1.2C1.31667 0.8 2.11667 0.5 2.95 0.3C3.78333 0.1 4.63333 0 5.5 0C6.46667 0 7.41267 0.125 8.338 0.375C9.26333 0.625 10.1507 1 11 1.5C11.85 1 12.7377 0.625 13.663 0.375C14.5883 0.125 15.534 0 16.5 0C17.3667 0 18.2167 0.1 19.05 0.3C19.8833 0.5 20.6833 0.8 21.45 1.2C21.6333 1.28333 21.771 1.40833 21.863 1.575C21.955 1.74167 22.0007 1.91667 22 2.1V14.15C22 14.5333 21.8377 14.825 21.513 15.025C21.1883 15.225 20.8507 15.2333 20.5 15.05C19.8833 14.7167 19.2377 14.4583 18.563 14.275C17.8883 14.0917 17.2007 14 16.5 14C15.5 14 14.5333 14.175 13.6 14.525C12.6667 14.875 11.8 15.3667 11 16Z" fill="var(--color-link)"/>
                        <title>View Recipe of {{ item.name }}</title>
                    </svg>

                    <!-- <svg 
                        class="arrow" 
                        :class="activeArrow(expand[index])"
                        @click="expand[index] = !expand[index];" 
                        width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        <title>Details</title>
                    </svg> -->
                </div>
            </div>
            <!--
                * 
                * VALUE ROWS
                *
            -->
            <div class="value-container">
                <div class="value-conversion">
                    <!--
                        * 
                        * COMPARE VALUES WHETHER ITS BETTER TO BUY OR CRAFT
                        *
                    -->
                    <span class="gold-label-container">
                        <span 
                            class="gold-label"
                            v-for="gold in formatValue(showValue(item) * item.output_item_count)"
                        >
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                        </span>
                    </span>
                    <p>/</p>
                    <!--
                        * 
                        * RESEARCH NOTE QUANTITY
                        *
                    -->
                    <div class="img-and-label">
                        <img class="icon" :src="currencyIcon" :alt="targetCurrency" :title="targetCurrency">

                        <p>{{ item.avg_output * item.output_item_count }}</p>
                    </div>
                </div>

                <div class="value">
                    <span class="gold-label-container">
                        <span 
                            class="gold-label"
                            v-for="gold in formatValue(showValue(item)/item.avg_output)"
                        >
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <PageButtons
        v-if="researchNotes && !isFavorite"
        :data-array="researchNotes"
        @new-url="handleNewUrl"
    />

</template>

<script setup>
import { computed, ref, watch } from 'vue'
import { showRarityColor, formatValue } from '@/js/vue/composables/FormatFunctions'
import { wiki, activeArrow } from '@/js/vue/composables/BasicFunctions'
import { buyOrder, favorites, refreshFavorites, user } from '@/js/vue/composables/Global';

import PageButtons from '@/js/vue/components/general/PageButtons.vue'

import Armorsmith from '@/imgs/icons/Armorsmith.png'
import Artificer from '@/imgs/icons/Artificer.png'
import Chef from '@/imgs/icons/Chef.png'
import Huntsman from '@/imgs/icons/Huntsman.png'
import Jeweler from '@/imgs/icons/Jeweler.png'
import Leatherworker from '@/imgs/icons/Leatherworker.png'
import Scribe from '@/imgs/icons/Scribe.png'
import Tailor from '@/imgs/icons/Tailor.png'
import Weaponsmith from '@/imgs/icons/Weaponsmith.png'
import axios from 'axios';

const props = defineProps({
    isFavorite: Boolean,
    currencyIcon: String,
    targetCurrency: String,
    researchNotes: Object,
})

const emit = defineEmits(['newUrl']);

// Emit new url from PageButtons via pagnation
const handleNewUrl = (url) => {
    emit('newUrl', url); 
}

// If Favorites is true => show without .data since Favorites's list is a straight array
// If not the Favorites, then do .data for pagnation
const displayResearchNotes = computed(() => {
    return props.isFavorite ? props.researchNotes : props.researchNotes.data; 
})

// Individually allow each card to be expanded or not
// By default, have each card not expanded
//const expand = ref(props.researchNotes.data.map(() => false));

console.log('fetched research notes: ', props.researchNotes);

const handleFavorite = async (item) => {
    item.favorite = !item.favorite; 
    console.log('favorites before anything: ', favorites.value);

    if (!favorites.value.researchNotes){
        favorites.value.researchNotes = [];
    }
    if (favorites.value.researchNotes){
        const index = favorites.value.researchNotes.indexOf(item.id); 
        // If item id NOT in array
        if (index == -1){  
            favorites.value.researchNotes = [...favorites.value.researchNotes, item.id]; 
        } 
        // If item id IS in array
        else {
            favorites.value.researchNotes = [
                ...favorites.value.researchNotes.slice(0, index),
                ...favorites.value.researchNotes.slice(index + 1)
            ]
        }
    } else {
        favorites.value.researchNotes = [item.id]; 
    }

    try {
        const response = await axios.post('../api/user/saveFavorites', {
            favorites: favorites.value,
        })

        if (response){
            console.log('Saved favorites!', favorites.value, user.value);
            refreshFavorites.value = true; 
        }
    } catch (error){
        console.log('Favorites did not save: ', error); 
    }

}

const showValue = (item) => {
    if (item.crafting_value < item.buy_price 
    && item.crafting_value < item.sell_price 
    || item.buy_price == null && item.sell_price == null){
        return item.crafting_value; 
    } else {
        if (buyOrder.value == 'buy_price'){
            return item.buy_price; 
        } 
        else if (buyOrder.value == 'sell_price'){
            return item.sell_price; 
        }
    }
}

// Use for determining which values to use, TP or crafting
// Ex: Research notes, which is better choice
const compareValues = (item) => {
    // If no TP prices or could be sold to the TP
    if ((item.buy_price == 0 && item.sell_price == 0) || (item.buy_price == null || item.sell_price == null)){
        return {
            value: item.crafting_value,
            preference: "Crafting",
        };
    // If item can be sold on the TP via buy order
    // Check user's buy order settings
    } else if (buyOrder.value){
        // BUY PRICE
        // Buy price is less than crafting and !zero
        if (item.buy_price < item.crafting_value && item.buy_price != 0){
            return {
                value: item.buy_price,
                preference: "TP",
            };
        } 
        // Crafting is better than buy price
        else {
            return {
                value: item.crafting_value,
                preference: "Crafting",
            };
        }
    
    } else {
        // SELL PRICE
        // Sell price is less than crafting and !zero
        if (item.sell_price < item.crafting_value && item.sell_price != 0){
            return {
                value: item.sell_price,
                preference: "TP",
            };
        // Crafting is better than sell price
        } else {
            return {
                value: item.crafting_value,
                preference: "Crafting",
            };
        }
    }
}

const getRecipeValue = (recipeName, recipeId, recipeQty) => {
    const url = `../tools/recipe-value?requestedRecipe=${recipeName}&id=${recipeId}&qty=${recipeQty}`;
    window.open(url, '_blank');
}

// Depending on the result of item.disicipline
const matchDiscipline = (discipline) => {
    switch (discipline){
        case "Armorsmith": return Armorsmith; 
        case "Artificer": return Artificer;
        case "Chef": return Chef;
        case "Huntsman": return Huntsman;
        case "Jeweler": return Jeweler;
        case "Leatherworker": return Leatherworker;
        case "Scribe": return Scribe;
        case "Tailor": return Tailor;
        case "Weaponsmith": return Weaponsmith; 
    }
}


</script>