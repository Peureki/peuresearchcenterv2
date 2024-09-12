<template>
    <PageButtons
        v-if="researchNotes"
        :data-array="researchNotes"
        @new-url="newUrl"
    />

    <div class="mobile-currency-container">
        <div v-for="(item, index) in researchNotes.data" :key="index" class="mobile-currency-card">
            <div class="label-and-cta">
                <!--
                    * 
                    * QUANTITY, NAME, DISCIPLINES
                    *
                -->
                <div class="img-and-label">
                    <img class="icon" :src="item.icon" :alt="item.name" :title="item.name">

                    <p class="item-name" :style="{color: showRarityColor(item.rarity)}">{{ item.output_item_count }} {{ item.name }}</p>

                    <div class="img-and-label">
                        <img v-for="discipline in item.disciplines" class="icon" :src="matchDiscipline(discipline)" :alt="discipline" :title="discipline"> 
                    </div>
                </div>

                <!--
                    * 
                    * SVG CTAs
                    *
                -->
                <div class="svg-ctas">
                    <svg class="icon" @click="wiki(item.name)" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 0C11.2311 0 8.52431 0.821086 6.22202 2.35943C3.91973 3.89777 2.12532 6.08427 1.06569 8.64243C0.00606596 11.2006 -0.271181 14.0155 0.269012 16.7313C0.809205 19.447 2.14258 21.9416 4.10051 23.8995C6.05845 25.8574 8.55301 27.1908 11.2687 27.731C13.9845 28.2712 16.7994 27.9939 19.3576 26.9343C21.9157 25.8747 24.1022 24.0803 25.6406 21.778C27.1789 19.4757 28 16.7689 28 14C28 10.287 26.525 6.72601 23.8995 4.1005C21.274 1.475 17.713 0 14 0ZM26 13H20C19.8833 9.31709 18.9291 5.70915 17.21 2.45C19.5786 3.0979 21.6914 4.45684 23.2632 6.34342C24.8351 8.23 25.7903 10.5534 26 13ZM14 26C13.7769 26.015 13.5531 26.015 13.33 26C11.2583 22.6962 10.1085 18.8981 10 15H18C17.9005 18.8953 16.7612 22.6932 14.7 26C14.467 26.0164 14.2331 26.0164 14 26ZM10 13C10.0995 9.10468 11.2388 5.30682 13.3 2C13.7453 1.94997 14.1947 1.94997 14.64 2C16.7223 5.3008 17.8825 9.09906 18 13H10ZM10.76 2.45C9.0513 5.71164 8.10746 9.31945 8.00001 13H2.00001C2.20971 10.5534 3.16495 8.23 4.7368 6.34342C6.30865 4.45684 8.42144 3.0979 10.79 2.45H10.76ZM2.05001 15H8.05001C8.15437 18.6798 9.09478 22.2875 10.8 25.55C8.43887 24.8951 6.33478 23.5332 4.77056 21.6472C3.20634 19.7612 2.25695 17.4415 2.05001 15ZM17.21 25.55C18.9291 22.2908 19.8833 18.6829 20 15H26C25.7903 17.4466 24.8351 19.77 23.2632 21.6566C21.6914 23.5432 19.5786 24.9021 17.21 25.55Z" fill="#FFD12C"/>
                        <title>Wiki</title>
                    </svg>

                    <svg @click="getRecipeValue(item.name, item.id, 1)"  class="icon" width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.4544 8.85976L16.5041 2.86726C14.7446 1.11138 12.3603 0.125244 9.87456 0.125244C7.38879 0.125244 5.00455 1.11138 3.24503 2.86726L3.23284 2.88038L1.94097 4.21351C1.73335 4.42784 1.61938 4.71586 1.62413 5.01422C1.62888 5.31258 1.75195 5.59683 1.96628 5.80445C2.18061 6.01206 2.46863 6.12603 2.76699 6.12128C3.06535 6.11654 3.3496 5.99346 3.55722 5.77913L4.84253 4.45257C5.26806 4.0272 5.74595 3.65768 6.26472 3.35288L10.1563 7.25007L1.42347 15.9838C1.24928 16.1579 1.1111 16.3647 1.01682 16.5922C0.922547 16.8197 0.874023 17.0636 0.874023 17.3099C0.874023 17.5562 0.922547 17.8001 1.01682 18.0276C1.1111 18.2552 1.24928 18.4619 1.42347 18.636L3.36315 20.5757C3.71477 20.9272 4.1916 21.1247 4.68878 21.1247C5.18596 21.1247 5.66279 20.9272 6.0144 20.5757L14.75 11.8438L14.8916 11.9854L17.1088 14.2035C17.2829 14.3777 17.4896 14.5159 17.7172 14.6102C17.9447 14.7044 18.1886 14.753 18.4349 14.753C18.6812 14.753 18.925 14.7044 19.1526 14.6102C19.3801 14.5159 19.5868 14.3777 19.761 14.2035L22.4507 11.5129C22.6252 11.339 22.7638 11.1324 22.8585 10.9049C22.9532 10.6774 23.0021 10.4335 23.0024 10.1871C23.0028 9.94069 22.9546 9.69664 22.8605 9.46888C22.7665 9.24113 22.6285 9.03414 22.4544 8.85976ZM4.68878 18.7194L3.28253 17.3132L9.12503 11.4688L10.5313 12.8751L4.68878 18.7194ZM12.125 11.2813L10.7188 9.87507L12.5478 8.04601C12.6527 7.94149 12.7359 7.8173 12.7927 7.68055C12.8495 7.54381 12.8787 7.3972 12.8787 7.24913C12.8787 7.10107 12.8495 6.95446 12.7927 6.81771C12.7359 6.68097 12.6527 6.55677 12.5478 6.45226L8.58503 2.49132C9.71959 2.28165 10.8881 2.35087 11.99 2.69301C13.0919 3.03515 14.0941 3.63997 14.9103 4.45538L17.8578 7.42445L15.6875 9.59382L15.546 9.45226C15.4414 9.34738 15.3173 9.26416 15.1805 9.20738C15.0438 9.1506 14.8972 9.12137 14.7491 9.12137C14.601 9.12137 14.4544 9.1506 14.3177 9.20738C14.1809 9.26416 14.0567 9.34738 13.9522 9.45226L12.125 11.2813ZM18.4363 12.3416L17.2813 11.1876L19.446 9.02288L20.5991 10.1844L18.4363 12.3416Z" fill="#FFD12C"/>
                        <title>View Recipe</title>
                    </svg>

                    <svg 
                        class="arrow" 
                        :class="activeArrow(expand[index])"
                        @click="expand[index] = !expand[index];" 
                        width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        <title>Details</title>
                    </svg>
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
                            v-for="gold in formatValue(compareValues(item).value * item.output_item_count)"
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

                        <p>~{{ item.avg_output * item.output_item_count }}</p>
                    </div>
                </div>

                <div class="value">
                    <span class="gold-label-container">
                        <span 
                            class="gold-label"
                            v-for="gold in formatValue(compareValues(item).value/item.avg_output)"
                        >
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref } from 'vue'
import { showRarityColor, formatValue } from '@/js/vue/composables/FormatFunctions'
import { wiki, activeArrow } from '@/js/vue/composables/BasicFunctions'
import { buyOrder } from '@/js/vue/composables/Global';

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

const props = defineProps({
    currencyIcon: String,
    targetCurrency: String,
    researchNotes: Object,
})

// Individually allow each card to be expanded or not
// By default, have each card not expanded
const expand = ref(props.researchNotes.data.map(() => false));

console.log('fetched research notes: ', props.researchNotes);

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