<template>
    <Nav/>
    <Header page-name="Gathering Tracker"/>

    <section class="main">
        <div class="content-section">
            <GatheringInput/>
            <GatheringInput/>
            <GatheringInput/>
            <GatheringInput/>
            <GatheringInput/>
            <GatheringInput/>
            <GatheringInput/>
            <GatheringInput/>
            <GatheringInput/>
            <GatheringInput/>
            <GatheringInput/>
            <GatheringInput/>
        </div>
    </section>


    <Footer/>
</template>

<script setup>
import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import GatheringInput from '@/js/vue/components/general/GatheringInput.vue'

</script>

<style scoped>


</style>