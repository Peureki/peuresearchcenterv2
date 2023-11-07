<template>
    <section>
        <article>
            <table :class="tableName">
                <thead>
                    <tr>
                        <th colspan="100%"><h4>Fine {{ tableName }}</h4></th>
                    </tr>
                    <tr>
                        <th><h5>Item 1</h5></th>
                        <th><h5>Item 2</h5></th>
                        <th><h5>Item 3</h5></th>
                        <th><h5>Item 4</h5></th>
                        <th><h5>Output</h5></th>
                        <th @click="sortTable(tableName, 5, 'gold')"><h5>Profit/Conversion</h5></th>
                        <th @click="sortTable(tableName, 6, 'gold')"><h5>Profit/Spirit Shard</h5></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="recipe in recipes">
                        <!-- INGREDIENTS -->
                        <td v-for="ingredient in recipe.ingredients">
                            <div class="material-container">
                                <span class="ingredient">
                                    {{ ingredient.count }}
                                    <img class="item" :src="ingredient.icon" :alt="ingredient.name" :title="ingredient.name">
                                </span>
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
        </article>
    </section>
</template>

<script setup>
import { onMounted } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'

import { sortTable } from '@/js/vue/composables/SortFunctions.js'

const props = defineProps({
    tableName: String,
    recipes: Object,
})

// Sort table when loaded
onMounted(() => {
    if (props.recipes)
        sortTable(props.tableName, 6, 'gold');
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
    gap: 5px;
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
    opacity: 0.8;
    font-style: italic;
}
img.item{
    width: 30px;
}

</style>