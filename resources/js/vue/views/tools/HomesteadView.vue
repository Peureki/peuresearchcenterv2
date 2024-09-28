<template>
    <Nav/>
    <Header page-name="Homesteads"/>

    <section class="main">
        <div class="content-section">
            <Disclaimer message="This page will get a redesign soon"/>
            <RefinementTable
                target-refinement="Refined Homestead Wood"
                target-id="103049"
            />
        </div>
    </section>

    <section class="main">
        <div class="content-section">
            <RefinementTable
                target-refinement="Refined Homestead Metal"
                target-id="102205"
            />
        </div>
    </section>

    <section class="main">
        <div class="content-section">
            <RefinementTable
                target-refinement="Refined Homestead Fiber"
                target-id="102306"
            />
        </div>
    </section>

    <Footer/>
</template>

<script setup>

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import Disclaimer from '@/js/vue/components/general/Disclaimer.vue'
import RefinementTable from '@/js/vue/components/tables/RefinementTable.vue';

const getOtherRecipes = async () => {
    try {
        const response = await fetch(`../api/other-recipes`);
        const responseData = await response.json(); 

        if (responseData){
            console.log('other recipes: ', responseData);
        }
    } catch (error){
        console.log('Could not fetch data: ', error);
    }
}

getOtherRecipes(); 

</script>

<style scoped>

</style>