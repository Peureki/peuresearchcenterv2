<template>
    <table class="fine">
        <thead>
            <tr>
                <th colspan="100%"><h4>{{ tableName }}</h4></th>
            </tr>
            <tr>
                <th><h5>Item 1</h5></th>
                <th><h5>Item 2</h5></th>
                <th><h5>Item 3</h5></th>
                <th><h5>Item 4</h5></th>
                <th><h5>Results</h5></th>
                <th><h5>Profit/Conversion</h5></th>
                <th><h5>Profit/Spirit Shard</h5></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="recipe in recipe">
                <td v-for="ingredient in recipe.ingredients">
                    <div class="ingredient-container">
                        <span class="ingredient">
                            {{ ingredient.count }}
                            <img class="item" :src="ingredient.icon" :alt="ingredient.name" :title="ingredient.name">
                        </span>
                        <div class="gold-container">
                            <span class="gold-label" v-for="gold in formatValue(ingredient.value)">
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </div>
                    </div>
                </td>
                <td>
                    ~{{ recipe.count }}
                    <img class="item" :src="recipe.icon" :alt="recipe.name" :title="recipe.name">
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { formatValue } from '@/js/vue/composables/FormatFunctions.js'

const props = defineProps({
    tableName: String,
    recipe: Object,
})

console.log('recipes: ', props.recipe);

</script>

<style scoped>
/* table td{
    border: none;
} */
.ingredient-container{
    display: flex;
    flex-direction: column;
    gap: 5px;
}
span.gold-label img{
    width: 13px;
}
span.gold-label{
    font-size: var(--font-size-subtext);
    opacity: 0.8;
    font-style: italic;
}
img.item{
    width: 30px;
}

</style>