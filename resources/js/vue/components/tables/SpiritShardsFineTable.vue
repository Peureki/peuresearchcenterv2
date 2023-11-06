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
                    {{ ingredient.count }}
                    <img class="item" :src="ingredient.icon" :alt="ingredient.name" :title="ingredient.name">
                    <span class="gold-label" v-for="gold in formatValue(ingredient.value)">
                        {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                    </span>
                </td>
                <td>
                    ~{{ recipe.count }}
                    <img :src="recipe.icon" :alt="recipe.name" :title="recipe.name">
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
img.item{
    width: 30px;
}

</style>