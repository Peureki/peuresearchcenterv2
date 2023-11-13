<template>
    <table :class="tableName" :id="tableName">
        <thead>
            <tr>
                <th colspan="100%"><h4>{{ tableTitle }}</h4></th>
            </tr>
            <tr>
                <th><h5>Item 1</h5></th>
                <th><h5>Item 2</h5></th>
                <th><h5>Item 3</h5></th>
                <th><h5>Item 4</h5></th>
                <th><h5>Output</h5></th>
                <!-- 
                    * TABLE HEADERS 
                    * 
                    * @click 
                    * -> toggle active columns that are being sorted
                    * -> toggle the order of sort (descending by default)
                    * -> sort this table
                    *
                    * @mouseover, @mouseout 
                    * -> set the headerIndex to be true when hovering -> highlights header column's borders to show if its sortable
                -->
                <th 
                    @click="
                        toggleActive(5, sortActive);
                        toggleSortOrder(5);
                        sortTable(tableName, 5, 'gold', sortOrder[5]); 
                    "
                    @mouseover="headerIndex = setHoverBorder(5, true)" 
                    @mouseout="headerIndex = setHoverBorder(5, false)"
                    :class="{'border-is-hoverable': 5 == headerIndex}"
                >
                    <span class="sortable-column">
                        <h5>Profit/Conversion</h5>
                        <svg
                            class="sort-arrow" 
                            :ref="el => sortActive[5] = el" 
                            :style="{transform: sortOrder[5] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </span>
                    
                </th>
                <th 
                    @click="
                        toggleActive(6, sortActive);
                        toggleSortOrder(6);
                        sortTable(tableName, 6, 'gold', sortOrder[6]);
                    "
                    @mouseover="headerIndex = setHoverBorder(6, true)" 
                    @mouseout="headerIndex = setHoverBorder(6, false)"
                    :class="{'border-is-hoverable': 6 == headerIndex}"
                >
                    <span class="sortable-column">
                        <h5>Profit/Spirit Shard</h5>
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[6] = el" 
                            :style="{transform: sortOrder[6] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </span>    
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- RECIPE ROW -->
            <tr v-for="recipe in recipes.value">
                <!-- INGREDIENTS -->
                <td v-for="ingredient in recipe.ingredients">
                    <div class="material-container">
                        <span class="ingredient">
                            {{ ingredient.count }}
                            <img class="item" :src="ingredient.icon" :alt="ingredient.name" :title="ingredient.name">
                        </span>
                        <!-- V-IF ELSE Check for SS -->
                        <div 
                            class="gold-container"
                            v-if="ingredient.name == `Philosopher's Stone` || ingredient.name == `Mystic Crystal`"
                        >
                            <span 
                                class="sub-gold-label"
                                v-if="ingredient.name == `Philosopher's Stone`"    
                            >
                                {{ ingredient.count / 10 }}<img src="@/imgs/icons/Spirit_Shard.png">
                            </span>  
                            <span 
                                class="sub-gold-label"
                                v-else   
                            >
                                {{ (ingredient.count * 0.6).toFixed(2) }}<img src="@/imgs/icons/Spirit_Shard.png">
                            </span>    
                        </div>
                        <div 
                            class="gold-container"
                            v-else
                        >
                            <span class="sub-gold-label" v-for="gold in formatValue(ingredient.value)">
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </div>
                    </div>
                </td>
                <!-- OUTPUT -->
                <td style="border-left: var(--border-general)">
                    <div class="material-container">
                        <span class="output">
                            ~{{ recipe.count }}
                            <img class="item" :src="recipe.icon" :alt="recipe.name" :title="recipe.name">
                        </span>
                    
                        <div class="gold-container">
                            <span class="sub-gold-label" v-for="gold in formatValue(recipe.value)">
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </div>
                    </div>
                </td>
                <!-- PROFIT/CONVERSION -->
                <td 
                    class="text-right"    
                    style="border-left: var(--border-general)"
                    :style="{borderRight: recipe.profitPerConversion > 0 ? `var(--border-positive)` : `var(--border-negative)`}"
                >
                    <span class="gold-label" v-for="gold in formatValue(recipe.profitPerConversion)">
                        {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                    </span>
                </td>
                <!-- PROFIT/SPIRIT SHARD -->
                <td 
                    class="text-right"
                    :style="{borderRight: recipe.profitPerConversion > 0 ? `var(--border-positive)` : `var(--border-negative)`}"    
                >
                    <span class="gold-label" v-for="gold in formatValue(recipe.profitPerSpiritShard)">
                        {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { ref, onMounted } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import { sortTable, setHoverBorder } from '@/js/vue/composables/SortFunctions.js'
import { toggleActive } from '@/js/vue/composables/AnimateFunctions.js'

const props = defineProps({
    tableName: String,
    tableTitle: String,
    recipes: Object,
})

// Initialize the index of the header to make hover effects to show user this column can be sorted
const headerIndex = ref(null);

const sortActive = ref([]), 
    sortOrder = ref([]), 
    sortArrows = ref([]);

// When user sorts a column, by default, descend the order from greaters -> smallest
// Otherwise, if user clicks again, switch order
const toggleSortOrder = (colIndex) => {
    if (sortOrder.value[colIndex] == undefined){
        sortOrder.value[colIndex] = 'descending';
    } else {
        sortOrder.value[colIndex] = sortOrder.value[colIndex] == 'descending' ? 'ascending' : 'descending'; 
    }
}

// const toggleActive = (colIndex, refEl) => {
//     sortActive.value.forEach((el => {
//         el.classList.remove('active');
//     }))
//     sortActive.value[colIndex].classList.add('active'); 
// }

// Sort table when loaded
onMounted(() => {
    if (props.recipes){
        sortActive[6]
        sortOrder.value[6] = 'descending';
        sortTable(props.tableName, 6, 'gold', 'descending');
    }
})

</script>

<style scoped>
table td{
    border: none;
} 
table td{
    border-bottom: var(--border-bottom);
}
.material-container{
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 2px;
}
.ingredient, .output{
    display: flex;
    align-items: center;
    gap: 5px;
}
span.gold-label img{
    width: 13px;
}
span.sub-gold-label{
    font-size: var(--font-size-subtext);
    opacity: 0.7;
    font-style: italic;
}
img.item{
    width: 30px;
}

</style>