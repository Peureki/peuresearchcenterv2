<template>
    <Header page-name="Gathering Tools"/>
    <Nav>
    </Nav>

    <section class="main">
        <div class="content-section">
        
            <div class="flex-wrap">
                <div class="flex-column">
                    <h3>Sickles</h3>
                    <GatheringTools
                        v-if="sickles"
                        :tools="sickles"
                    />
                </div>
                
                <div class="flex-column">
                    <h3>Axes</h3>
                    <GatheringTools
                        v-if="axes"
                        :tools="axes"
                    />
                </div>
                
                <div class="flex-column">
                    <h3>Picks</h3>
                    <GatheringTools
                        v-if="picks"
                        :tools="picks"
                    />
                </div>
            </div>

            <div class="paragraph">
                <p>These numbers were tracked using OBS. I hotkeyed when I started gathering and when I stopped. These times may not be *exactly* down to the milisecond, but I've tried my best to get the quickest times. I measured the minimum cast time by the earliest I can cancel the animation while receiving all possible drops of the node. Maximum cast time is measured by ending the timer when the character returns to it's 'combat' stance.</p>

                <p>Unlimited mining picks guarantee 4 strikes.</p>

                <div class="img-and-label">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 10V0H10V10H0Z" fill="var(--color-down)"/>
                        <title>Animation Locked</title>
                    </svg>
                    <p>Animation locked after the last strike</p>
                </div>

                <div class="img-and-label">
                    <p>*</p>
                    <p>Unique gathering strikes</p>
                </div>
            </div>

            <Disclaimer type="caution" message="These are just the skins that I have on my account. There are many more out there, but it's waaay to expensive to buy them all to test :P" />
        </div>
    </section>

    <Footer/>
</template>

<script setup>
import { onMounted, ref, computed, watch, onUnmounted } from 'vue'
import { user, sellOrder, tax, includes, refreshSettings, filters, filtersToggle } from '@/js/vue/composables/Global';
import { getAuthUser } from '@/js/vue/composables/Authentication';


import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import GatheringTools from '@/js/vue/components/benchmarks/GatheringTools.vue';
import Disclaimer from '@/js/vue/components/general/Disclaimer.vue';

const gatheringTools = ref(null),
    sickles = ref(null),
    axes = ref(null),
    picks = ref(null);

const currentlyRefreshing = ref(false),
    currentProgress = ref(0);


const url = `../api/benchmarks/gathering-tools`;
// BY DEFAULT
// If there is no user logged in, use default settings
onMounted( async () => {
    // Check if user is being auth
    await getAuthUser();
    // IF NO USER
    if (!user.value){
        console.log('no user')
        getGatheringTools(url);
    } 
    // USER FOUND
    else {
        console.log('user found')
        getGatheringTools(url);

    }
    filtersToggle.value = true; 
    console.log('url: ', url.value);
})
onUnmounted(() => {
    filtersToggle.value = false;
})


const getGatheringTools = async (url) => {
    try {
        const response = await fetch(url);
        const responseData = await response.json(); 

        if (response){
            console.log(responseData);
            // Sort gathering tool types by min cast
            sickles.value = responseData.sickle.sort((a, b) => a.min_cast - b.min_cast); 

            axes.value = responseData.axe.sort((a, b) => a.min_cast - b.min_cast); 

            picks.value = responseData.pick.sort((a, b) => a.min_cast - b.min_cast); 


        }

    } catch (error) {
        console.log('Could not get gathering tools: ', error);
    }

}

// watch(refreshSettings, async (newSettings) => {
//     if (newSettings){
//         currentlyRefreshing.value = true; 

//         await getGatheringTools(url);

//         currentlyRefreshing.value = false;
//         refreshSettings.value = false;
//     }
// })

</script>

<style scoped>
.table-headers{
    display: flex;
    justify-content: flex-start;
    gap: var(--gap-content);
}
.table-row{
    display: flex;
    justify-content: flex-start;
    gap: var(--gap-content);
}
.flex-wrap{
    align-items: flex-start;
}

</style>