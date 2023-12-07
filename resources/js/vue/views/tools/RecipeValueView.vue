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

                <RecipeTree 
                    v-if="recipe"
                    :recipe="recipe"  
                />
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

import RecipeTree from '@/js/vue/components/general/RecipeTree.vue'

const route = useRoute(),
    router = useRouter(); 

const recipe = ref(null);



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
        const responseData = await response.json(); 
        recipe.value = responseData;

    } catch (error){
        console.log('Error fetching data', error);
    }
}
</script>

<style scoped>



</style>