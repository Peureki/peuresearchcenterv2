<template>
    <!--
        *
        * RECIPE TREE
        *
        * Add padding for each new recursion of the tree
    -->
    <div 
        :class="recursionLevel > 0 ? 'sub-recipe-tree' : 'recipe-tree'"
        :style="{
            paddingLeft: recursionLevel > 0 ? `30px` : 0,
            paddingRight: recursionLevel > 0 ? 'unset' : `var(--gap-general)`,
            borderLeft: recursionLevel > 0 ? `var(--border-general)` : `none`
        }"
    >
        <!--
            *
            * INGREDIENTS
            *
        -->
        <div 
            v-if="recursionLevel == 0"
            :class="recursionLevel > 0 ? 'sub-ingredients' : 'ingredients'"
        >
            <span class="ingredient-details">
                <!-- 
                    *
                    * INGREDIENT INFO
                    *
                -->
                <span class="ingredient-info-container">
                    <img class="ingredient-icon" :src="recipe.icon" :alt="recipe.name" :title="recipe.name">
                    <p>{{ recipe.count }}</p>
                    <p v-if="recursionLevel == 0" class="ingredient-name" :style="{color: showRarityColor(recipe.rarity)}">{{ recipe.name }}</p>
                    <p class="ingredient-name" v-else>{{ recipe.name }}</p>
                    <svg class="icon clickable" @click="wiki(recipe.name)" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 0C11.2311 0 8.52431 0.821086 6.22202 2.35943C3.91973 3.89777 2.12532 6.08427 1.06569 8.64243C0.00606596 11.2006 -0.271181 14.0155 0.269012 16.7313C0.809205 19.447 2.14258 21.9416 4.10051 23.8995C6.05845 25.8574 8.55301 27.1908 11.2687 27.731C13.9845 28.2712 16.7994 27.9939 19.3576 26.9343C21.9157 25.8747 24.1022 24.0803 25.6406 21.778C27.1789 19.4757 28 16.7689 28 14C28 10.287 26.525 6.72601 23.8995 4.1005C21.274 1.475 17.713 0 14 0ZM26 13H20C19.8833 9.31709 18.9291 5.70915 17.21 2.45C19.5786 3.0979 21.6914 4.45684 23.2632 6.34342C24.8351 8.23 25.7903 10.5534 26 13ZM14 26C13.7769 26.015 13.5531 26.015 13.33 26C11.2583 22.6962 10.1085 18.8981 10 15H18C17.9005 18.8953 16.7612 22.6932 14.7 26C14.467 26.0164 14.2331 26.0164 14 26ZM10 13C10.0995 9.10468 11.2388 5.30682 13.3 2C13.7453 1.94997 14.1947 1.94997 14.64 2C16.7223 5.3008 17.8825 9.09906 18 13H10ZM10.76 2.45C9.0513 5.71164 8.10746 9.31945 8.00001 13H2.00001C2.20971 10.5534 3.16495 8.23 4.7368 6.34342C6.30865 4.45684 8.42144 3.0979 10.79 2.45H10.76ZM2.05001 15H8.05001C8.15437 18.6798 9.09478 22.2875 10.8 25.55C8.43887 24.8951 6.33478 23.5332 4.77056 21.6472C3.20634 19.7612 2.25695 17.4415 2.05001 15ZM17.21 25.55C18.9291 22.2908 19.8833 18.6829 20 15H26C25.7903 17.4466 24.8351 19.77 23.2632 21.6566C21.6914 23.5432 19.5786 24.9021 17.21 25.55Z" fill="#FFD12C"/>
                        <title>Wiki {{ recipe.name }}</title>
                    </svg>

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
                        v-if="recipe.buy_price != 0 || recipe.sell_price != 0"
                        :style="{backgroundColor: recipe.preference === `TP` ? `var(--color-positive-faded)` : `var(--border-general)`}"
                    >
                        <input 
                            type="radio" 
                            :id="`${recipe.name}-tp-radio`" 
                            value="TP" 
                            @change="emitChildIngredient(recipe.ingredients, 'TP')"
                            v-model="recipe.preference"
                        >
                        <label :for="`${recipe.name}-tp-radio`">TP</label>
                        <span 
                            class="gold-label" 
                            v-for="gold in formatValue(
                                buyOrder == 'buy_price' ? recipe.buy_price : recipe.sell_price
                            )"
                        >
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                        
                    </span>

                    <!-- CRAFTING LABEL -->
                    <span 
                        class="gold-label-container"
                        v-if="(recipe.type != 'Currency')
                            && (recipe.hasOwnProperty('ingredients'))"
                        :style="{backgroundColor: recipe.preference === `Crafting` ? `var(--color-positive-faded)` : `var(--border-general)`}"
                    >
                        <input 
                            type="radio" 
                            :id="`${recipe.name}-crafting-radio`" 
                            value="Crafting" 
                            @change="emitChildIngredient(recipe.ingredients, 'Crafting')"
                            v-model="recipe.preference"
                        >
                        <label :for="`${recipe.name}-crafting-radio`">Crafting</label>
                        <span 
                            class="gold-label" 
                            v-for="gold in formatValue(
                                recipe.craftingValue != 0 ? recipe.craftingValue : 0
                            )"
                        >
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                        
                    </span>

                    <!-- "HAVE ITEM" LABEL -->
                    <span 
                        class="gold-label-container"
                        v-if="(recipe.craftingValue != 0 || recipe.buy_price != 0) 
                            && (recipe.type != 'Currency')
                            && recursionLevel != 0"
                        :style="{backgroundColor: recipe.preference === `owned` ? `var(--color-positive-faded)` : `var(--border-general)`}"
                    >
                        <input 
                            type="radio" 
                            :id="`${recipe.name}-owned-radio`" 
                            value="owned" 
                            @change="emitChildIngredient(recipe.ingredients, 'owned')"
                            v-model="recipe.preference"
                        >
                        <label :for="`${recipe.name}-owned-radio`">Owned</label>
                    </span>
                    
                    <!-- LABEL WHEN THE ITEM CANNOT BE SOLD ON THE TP-->
                    <span 
                        class="gold-label-container"
                        v-if="(recipe.craftingValue == 0 && recipe.buy_price == 0 && recipe.sell_price == 0)
                            && !recipe.hasOwnProperty('ingredients')"
                    >
                        <p v-if="recipe.type != 'Item'">{{ recipe.type }}</p>
                        <p v-else>Cannot be bought or crafted</p>
                    </span>
                </div>
            </span>

            <Transition name="fade">
                <RecipeTree 
                    v-if="recipe.ingredients && recipe.preference === 'Crafting'"
                    :recipe="recipe.ingredients"
                    :recursion-level="recursionLevel + 1"
                    @update-recipe="emitChildIngredient"
                />
            </Transition>
        </div>

        <div 
            v-if="recursionLevel > 0"
            v-for="(ingredient, index) in recipe"
            :class="recursionLevel > 0 ? 'sub-ingredients' : 'ingredients'"
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
                    <p v-if="recursionLevel == 0" class="ingredient-name" :style="{color: showRarityColor(ingredient.rarity)}">{{ ingredient.name }}</p>
                    <p class="ingredient-name" v-else>{{ ingredient.name }}</p>
                    <svg class="icon clickable" @click="wiki(ingredient.name)" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 0C11.2311 0 8.52431 0.821086 6.22202 2.35943C3.91973 3.89777 2.12532 6.08427 1.06569 8.64243C0.00606596 11.2006 -0.271181 14.0155 0.269012 16.7313C0.809205 19.447 2.14258 21.9416 4.10051 23.8995C6.05845 25.8574 8.55301 27.1908 11.2687 27.731C13.9845 28.2712 16.7994 27.9939 19.3576 26.9343C21.9157 25.8747 24.1022 24.0803 25.6406 21.778C27.1789 19.4757 28 16.7689 28 14C28 10.287 26.525 6.72601 23.8995 4.1005C21.274 1.475 17.713 0 14 0ZM26 13H20C19.8833 9.31709 18.9291 5.70915 17.21 2.45C19.5786 3.0979 21.6914 4.45684 23.2632 6.34342C24.8351 8.23 25.7903 10.5534 26 13ZM14 26C13.7769 26.015 13.5531 26.015 13.33 26C11.2583 22.6962 10.1085 18.8981 10 15H18C17.9005 18.8953 16.7612 22.6932 14.7 26C14.467 26.0164 14.2331 26.0164 14 26ZM10 13C10.0995 9.10468 11.2388 5.30682 13.3 2C13.7453 1.94997 14.1947 1.94997 14.64 2C16.7223 5.3008 17.8825 9.09906 18 13H10ZM10.76 2.45C9.0513 5.71164 8.10746 9.31945 8.00001 13H2.00001C2.20971 10.5534 3.16495 8.23 4.7368 6.34342C6.30865 4.45684 8.42144 3.0979 10.79 2.45H10.76ZM2.05001 15H8.05001C8.15437 18.6798 9.09478 22.2875 10.8 25.55C8.43887 24.8951 6.33478 23.5332 4.77056 21.6472C3.20634 19.7612 2.25695 17.4415 2.05001 15ZM17.21 25.55C18.9291 22.2908 19.8833 18.6829 20 15H26C25.7903 17.4466 24.8351 19.77 23.2632 21.6566C21.6914 23.5432 19.5786 24.9021 17.21 25.55Z" fill="#FFD12C"/>
                        <title>Wiki {{ ingredient.name }}</title>
                    </svg>

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
                        :style="{backgroundColor: ingredient.preference === `TP` ? `var(--color-positive-faded)` : `var(--border-general)`}"
                    >
                        <input 
                            type="radio" 
                            :id="`${ingredient.name}-tp-radio`" 
                            value="TP" 
                            @change="emitChildIngredient(ingredient, 'TP')"
                            v-model="ingredient.preference"
                        >
                        <label :for="`${ingredient.name}-tp-radio`">TP</label>
                        <span 
                            class="gold-label" 
                            v-for="gold in formatValue(
                                buyOrder == 'buy_price' ? ingredient.buy_price : ingredient.sell_price
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
                        :style="{backgroundColor: ingredient.preference === `Crafting` ? `var(--color-positive-faded)` : `var(--border-general)`}"
                    >
                        <input 
                            type="radio" 
                            :id="`${ingredient.name}-crafting-radio`" 
                            value="Crafting" 
                            @change="emitChildIngredient(ingredient, 'Crafting')"
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
                    v-if="ingredient.ingredients && ingredient.preference === 'Crafting'"
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
import { formatValue, showRarityColor } from '@/js/vue/composables/FormatFunctions.js'
import { wiki } from '@/js/vue/composables/BasicFunctions.js'
import { buyOrder } from '@/js/vue/composables/Global'

const props = defineProps({
    recipe: Object, 
    recursionLevel: {
        type: Number,
        default: 0,
    },
})

//console.log('prop recipe: ', props.recipe, props.recipe.ingredients);

const emit = defineEmits(['updateRecipe']);


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
    padding: 3px;
}
.gold-label-container input[type="radio"]{
    margin-inline: 5px;
    cursor: pointer;
}
.gold-label-container label{
    padding-inline: 5px;
}
.recipe-tree{
    position: relative;
    width: fit-content;
}
.ingredients{
    overflow-x: auto;
}
span.ingredient-details{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: var(--gap-ingredients);
    padding-block: var(--gap-ingredients);
}
span.ingredient-info-container{
    display: flex;
    align-items: center;
    gap: 5px;
    padding-right: var(--gap-content);
}
img.ingredient-icon{
    width: 25px;
    aspect-ratio: 1 / 1;
}
p.ingredient-name{
    white-space: nowrap;
}

@media (max-width: 768px){
    .recipe-tree{
        width: 100%;
        padding-block: var(--gap-content);
    }
    .sub-ingredients{
        position: relative;
        width: 100%;
    }
    .sub-recipe-tree{
        width: fit-content;
    }
}

</style>