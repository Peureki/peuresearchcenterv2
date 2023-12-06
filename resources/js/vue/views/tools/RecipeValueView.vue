<template>
    <Nav/>
    <main>
        <Header page-name="Recipe Value"/>
        <section>
            <article>
                <form @submit.prevent="handleRecipeRequest">
                    <label for="recipe-name">Enter Recipe Name: </label>
                    <input type="text" id="recipe-name" v-model="route.params.requestedRecipe">
                    <br>
                    <button type="submit">Fetch Recipe</button>
                </form>

                <div 
                    class="recipe-tree"
                    v-if="calculatedRecipe"
                >
                    <div 
                        class="ingredient"
                        v-for="ingredient in calculatedRecipe.ingredients"
                    >
                        <span>
                            <p>{{ ingredient.name }}</p>
                            <p>{{ ingredient.tpValue }}</p>
                            <p>{{ ingredient.craftingValue }}</p>
                        </span>


                    </div>
                </div>
            </article>
        </section>


    </main>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import TwoColSection from '@/js/vue/components/general/TwoColSection.vue'
import Loading from '@/js/vue/components/general/Loading.vue'

const route = useRoute(),
    router = useRouter(); 

const calculatedRecipe = ref(null);

const handleRecipeRequest = () => {
    const requestedURL = route.params.requestedRecipe; 
    
    if (requestedURL){
        fetchRequestedRecipe(requestedURL);
    }
}

const fetchRequestedRecipe = async (requestedRecipe) => {
    try{
        const encodedRecipe = encodeURIComponent(requestedRecipe);
        router.replace({
            query: {
                requestedRecipe: encodedRecipe
            }});

        const response = await fetch(`../api/recipes/${requestedRecipe}/${localStorage.buyOrderSetting}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`);
        console.log('response: ', response);
        const responseData = await response.json(); 
        calculatedRecipe.value = responseData;

    } catch (error){
        console.log('Error fetching data', error);
    }
}
</script>

<style scoped>
</style>