<template>
    <!--
        *
        * RECIPE TREE
        *
        * Add padding for each new recursion of the tree
    -->
    <div 
        class="recipe-tree"
        :style="{
            paddingLeft: recursionLevel > 0 ? `30px` : 0,
            paddingRight: recursionLevel > 0 ? 'unset' : `${50}px`,
            width: recursionLevel > 0 ? `unset` : `fit-content`,
            borderLeft: recursionLevel > 0 ? `var(--border-general)` : `none`
        }"
    >
        <!--
            *
            * INGREDIENTS
            *
        -->
        <div 
            class="ingredients"
            v-for="(ingredient, index) in recipe"
        >
            <span class="ingredient-details">
                <!-- 
                    *
                    * INGREDIENT INFO
                    *
                -->
                <span class="ingredient-info-container">
                    <img class="ingredient-icon" :src="ingredient.icon" :alt="ingredient.name" :title="ingredient.name">
                    <p>{{ ingredient.count }}</p>
                    <p>{{ ingredient.name }}</p>
                </span>
                <!-- 
                    *
                    * PRICE CONTAINER
                    *
                -->
                <div class="price-container">

                    <!-- TP LABEL -->
                    <span 
                        class="gold-label-container"
                        v-if="ingredient.buy_price != 0 || ingredient.sell_price != 0"
                        :style="{backgroundColor: ingredient.preference === `tp` ? `var(--color-positive-faded)` : `var(--border-general)`}"
                    >
                        <input 
                            type="radio" 
                            :id="`${ingredient.name}-tp-radio`" 
                            value="tp" 
                            @change="emitChildIngredient(ingredient, 'tp')"
                            v-model="ingredient.preference"
                        >
                        <label :for="`${ingredient.name}-tp-radio`">TP</label>
                        <span 
                            class="gold-label" 
                            v-for="gold in formatValue(
                                buyOrderSetting == 'buy_price' ? ingredient.buy_price : ingredient.sell_price
                            )"
                        >
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                        
                    </span>

                    <!-- CRAFTING LABEL -->
                    <span 
                        class="gold-label-container"
                        v-if="(ingredient.type != 'Currency')
                            && (ingredient.hasOwnProperty('ingredients'))"
                        :style="{backgroundColor: ingredient.preference === `crafting` ? `var(--color-positive-faded)` : `var(--border-general)`}"
                    >
                        <input 
                            type="radio" 
                            :id="`${ingredient.name}-crafting-radio`" 
                            value="crafting" 
                            @change="emitChildIngredient(ingredient, 'crafting')"
                            v-model="ingredient.preference"
                        >
                        <label :for="`${ingredient.name}-crafting-radio`">Crafting</label>
                        <span 
                            class="gold-label" 
                            v-for="gold in formatValue(
                                ingredient.craftingValue != 0 ? ingredient.craftingValue : 0
                            )"
                        >
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                        
                    </span>

                    <!-- "HAVE ITEM" LABEL -->
                    <span 
                        class="gold-label-container"
                        v-if="(ingredient.craftingValue != 0 || ingredient.buy_price != 0) 
                            && (ingredient.type != 'Currency')
                            && recursionLevel != 0"
                        :style="{backgroundColor: ingredient.preference === `owned` ? `var(--color-positive-faded)` : `var(--border-general)`}"
                    >
                        <input 
                            type="radio" 
                            :id="`${ingredient.name}-owned-radio`" 
                            value="owned" 
                            @change="emitChildIngredient(ingredient, 'owned')"
                            v-model="ingredient.preference"
                        >
                        <label :for="`${ingredient.name}-owned-radio`">Owned</label>
                    </span>
                    
                    <!-- LABEL WHEN THE ITEM CANNOT BE SOLD ON THE TP-->
                    <span 
                        class="gold-label-container"
                        v-if="(ingredient.craftingValue == 0 && ingredient.buy_price == 0 && ingredient.sell_price == 0)
                            && !ingredient.hasOwnProperty('ingredients')"
                    >
                        <p v-if="ingredient.type != 'Item'">{{ ingredient.type }}</p>
                        <p v-else>Cannot be bought or crafted</p>
                    </span>
                </div>
            </span>

            <Transition name="fade">
                <RecipeTree 
                    v-if="ingredient.ingredients && ingredient.preference === 'crafting'"
                    :recipe="ingredient.ingredients"
                    :recursion-level="recursionLevel + 1"
                    @update-recipe="emitChildIngredient"
                />
            </Transition>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { formatValue } from '@/js/vue/composables/FormatFunctions.js'

const props = defineProps({
    recipe: Object, 
    recursionLevel: {
        type: Number,
        default: 0,
    },
})

const emit = defineEmits(['updateRecipe']);

const taxSetting = ref(localStorage.taxSetting),
    buyOrderSetting = ref(localStorage.buyOrderSetting),
    sellOrderSetting = ref(localStorage.sellOrderSetting);


const emitChildIngredient = (selectedIngredient, userPreference) => {
    emit('updateRecipe', selectedIngredient, userPreference);
}

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