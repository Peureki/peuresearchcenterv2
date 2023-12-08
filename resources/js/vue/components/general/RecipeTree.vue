<template>
    <div 
        class="recipe-tree"
        :style="{
            paddingLeft: recursionLevel > 0 ? `30px` : 0,
            paddingRight: recursionLevel > 0 ? 'unset' : `${50}px`,
            width: recursionLevel > 0 ? `unset` : `fit-content`,
            borderLeft: recursionLevel > 0 ? `var(--border-general)` : `none`

        }"
    >
        <div 
            class="ingredients"
            v-for="(ingredient, index) in recipe"
        >
            <span class="ingredient-details">
                <span class="ingredient-info-container">
                    <img class="ingredient-icon" :src="ingredient.icon" :alt="ingredient.name" :title="ingredient.name">
                    <p>{{ ingredient.count }}</p>
                    <p>{{ ingredient.name }}</p>
                </span>

                <div class="price-container">
                    <span 
                        class="gold-label-container"
                        :style="{backgroundColor: recipeTreeToggle[index] === `tp` ? `var(--color-positive-faded)` : `var(--border-general)`}"
                    >
                        <input 
                            type="radio" 
                            :id="`${ingredient.name}-tp-radio`" 
                            value="tp" 
                            v-model="recipeTreeToggle[index]"
                        >
                        <span 
                            class="gold-label" 
                            v-for="gold in formatValue(
                                ingredient.buy_price != 0 ? ingredient.buy_price : ingredient.sell_price
                            )"
                        >
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                        <label :for="`${ingredient.name}-tp-radio`">TP</label>
                    </span>

                    <span 
                        class="gold-label-container"
                        v-if="ingredient.craftingValue != 0"
                        :style="{backgroundColor: recipeTreeToggle[index] === `crafting` ? `var(--color-positive-faded)` : `var(--border-general)`}"
                    >
                        <input 
                            type="radio" 
                            :id="`${ingredient.name}-crafting-radio`" 
                            value="crafting" 
                            v-model="recipeTreeToggle[index]"
                        >
                        <span 
                            class="gold-label" 
                            v-for="gold in formatValue(
                                ingredient.craftingValue != 0 ? ingredient.craftingValue : 0
                            )"
                        >
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                        <label :for="`${ingredient.name}-crafting-radio`">Crafting</label>
                    </span>
                </div>
            </span>

            <RecipeTree 
                v-if="ingredient.ingredients && recipeTreeToggle[index] === 'crafting'"
                :recipe="ingredient.ingredients"
                :parent-ingredient="ingredient"
                :recursion-level="recursionLevel + 1"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { formatValue } from '@/js/vue/composables/FormatFunctions.js'

const props = defineProps({
    recipe: Object, 
    parentIngredient: Object,
    recursionLevel: {
        type: Number,
        default: 0,
    },
})

const recipeTreeToggle = ref([]);

const updateRecipeTree = () => {

}

onMounted(() => {
    console.log(props.recipe, props.recipe.length);
    if (props.recipe){
        for (let i = 0; i < props.recipe.length; i++){
            if (props.recipe[i].buy_price > props.recipe[i].craftingValue){
                recipeTreeToggle.value.push('crafting');
            } else {
                recipeTreeToggle.value.push('tp');
            }
        }
        // props.recipe.forEach((ingredient, index) => {
        //     if (ingredient.buy_price > ingredient.craftingValue){
        //         recipeTreeToggle.value.push('crafting');
        //         console.log(ingredient.craftingValue, index);
        //     } else {
        //         recipeTreeToggle.value.push('tp');
        //     }
        // })
    }

    
})


</script>

<style scoped> 
.price-container{
    display: flex;
    justify-content: space-between;
    gap: 20px;
}
.gold-label-container{
    border: var(--border-general);
    padding: 5px;
}
.gold-label-container input[type="radio"]{
    margin-inline: 5px;
    cursor: pointer;
}
.gold-label-container label{
    padding-inline: 5px;
}
span.ingredient-details{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    padding-block: 5px;
}
span.ingredient-info-container{
    display: flex;
    align-items: center;
    gap: 5px;
}
img.ingredient-icon{
    width: 25px;
    aspect-ratio: 1 / 1;
}

</style>