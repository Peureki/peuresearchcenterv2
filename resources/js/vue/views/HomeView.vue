<template>
    <Nav/>

    <section class="first-section">
        <div class="content-section">
            <div class="header">
                <img class="peu-choya" :src="PeuChoya" alt="Peu Choya" title="Peu Choya">
                <h1>
                    <span class="red">Peu</span>
                    <span class="green">Research Center</span>
                </h1>
                <div class="subheader-container">
                    <h2>Why have humans do the research when you can have choyas?</h2>
                    <button @click="loginButton"><h4 class="sign-up">Sign up</h4></button>
                </div>
            </div>
        </div>
    </section>

    <section class="main">
        <div class="content-section">
            <div class="card-collection">
                <router-link class="card-container" to="/benchmarks/maps">
                    <div class="card-title">
                        <h3>Map Benchmarks</h3>
                        <p class="small-subtitle">Wide variety of open world farms!</p>
                    </div>
                    

                    <div class="img-and-cta">
                        <img class="card-icon" :src="JungleChoya" alt="Map Benchmarks" title="Map Benchmarks">
                        <svg class="card-cta" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </div>
                </router-link>

                <router-link class="card-container" to="/benchmarks/fishing">
                    <div class="card-title">
                        <h3>Fishing Benchmarks</h3>
                        <p class="small-subtitle">Embracing all fishes around Tyria</p>
                    </div>
                    

                    <div class="img-and-cta">
                        <img class="card-icon" :src="BlueChoya" alt="Map Benchmarks" title="Map Benchmarks">
                        <svg class="card-cta" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </div>
                </router-link>

                <router-link class="card-container" to="/benchmarks/node-farms">
                    <div class="card-title">
                        <h3>Gathering Benchmarks</h3>
                        <p class="small-subtitle">Gathering routes with numbers of almost every glyph combination</p>
                    </div>
                    

                    <div class="img-and-cta">
                        <img class="card-icon" :src="GatheringChoya" alt="Gathering Benchmarks" title="Gathering Benchmarks">
                        <svg class="card-cta" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </div>
                </router-link>

                <router-link class="card-container" to="/currencies/research-note">
                    <div class="card-title">
                        <h3>Research Notes</h3>
                        <p class="small-subtitle">Tool to find the best way to get Research Notes</p>
                    </div>
                    

                    <div class="img-and-cta">
                        <img class="card-icon" :src="ResearchChoya" alt="Map Benchmarks" title="Map Benchmarks">
                        <svg class="card-cta" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </div>
                </router-link>

                <router-link class="card-container" to="/tools/checklist">
                    <div class="card-title">
                        <h3>Checklist</h3>
                        <p class="small-subtitle">A to-do list, but for GW2</p>
                    </div>
                    

                    <div class="img-and-cta">
                        <img class="card-icon" :src="GolemChoya" alt="Map Benchmarks" title="Map Benchmarks">
                        <svg class="card-cta" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </div>
                </router-link>
            </div>
            
        </div>
    </section>
</template>

<script setup>
import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import { getAuthUser } from '@/js/vue/composables/Authentication';
import { loginToggle, isMobile, mainNavToggle, mobileHamburger } from '@/js/vue/composables/Global';

import PeuChoya from '@/imgs/choyas/Peu_Choya.png'
import JungleChoya from '@/imgs/choyas/Jungle_Choya.png'
import BlueChoya from '@/imgs/choyas/Blue_Choya.png'
import ResearchChoya from '@/imgs/choyas/Research_Choya.png'
import GolemChoya from '@/imgs/choyas/Golem_Choya.png'
import GatheringChoya from '@/imgs/choyas/Gathering_Choya.png'
import { onMounted } from 'vue';

const loginButton = () => {
    if (isMobile){
        mainNavToggle.value = true;
        mobileHamburger.value = false; 
    }
    loginToggle.value = !loginToggle.value; 
}

onMounted( async () => {
    await getAuthUser();
})

</script>

<style scoped>
section {
    border-bottom: unset;
}
a{
    text-decoration: unset;
}
.header{
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--gap-content);
}
.subheader-container{
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: calc(var(--gap-content) * 2);
}
h1{
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    font-size: var(--font-size-homepage-h1);
}
h2{
    text-align: center;
    color: var(--color-text);
    font-size: clamp(1rem, 2vw, 3rem);
}
.peu-choya{
    width: var(--w-homepage-icon);
}
.red{
    color: var(--color-h1);
}
.green{
    color: var(--color-subheader);
}
.sign-up{
    color: var(--color-bkg);
}
.card-collection{
    display: flex;
    flex-wrap: wrap;
    gap: var(--gap-content);
}
.card-container{
    display: flex;
    flex-direction: column;
    gap: var(--gap-content);
    padding: var(--gap-content);
    border-radius: 5px;
    border: var(--border-general);
    flex: 1;
    transition: var(--transition-all-03s-ease);
}
.card-container:hover{
    border: var(--border-hover-link);
}
.card-container:hover .card-cta{
    transform: rotate(45deg);
}
.card-title{
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--gap-general);
}
.img-and-cta{
    display: flex;
    justify-content: center;
    align-items: flex-end;
    height: 100%;
    gap: var(--gap-general);
}
.card-icon{
    width: clamp(10rem, 20vw, 20rem);
}
.card-cta{
    width: clamp(3rem, 5vw, 10rem);
    height: clamp(3rem, 5vw, 10rem);
    transform: rotate(-45deg);
    transition: var(--transition-all-03s-ease);
}
@media (max-width: 768px){
    section.first-section{
        padding-top: calc(var(--padding-general) * 2 + 60px);
    }
}
</style>