<template>
    <Nav/>
    <Header page-name="Support"/>

    <section class="main">
        <div class="content-section">
            <div class="two-col">
                <div class="description-container">
                    <div class="img-and-label">
                        <img class="choya-icon" :src="HappyChoya">
                        <h3>THANK YOU FOR USING THIS WEBSITE!</h3>
                    </div>

                    <div class="comment">
                        <p>Thank you using this website, donating, helping with research, joining my trains, and even engaging on Discord! I hope you find it useful and it helps your quality of life while playing Guild Wars 2. It has been a joy making this and the previous version of the website. I love this game and I hope the best for it.</p>

                        <p>Below are extra ways to support me! This includes helping maintain server costs and my time for producing this website/new content.</p>

                        <p class="small-subtitle">Note: Use the same email if you signed up on this website and if you're donating on Patreon. If you are donating via Venmo, please comment your email. This is so I can label your account as "Donator" and you'll get extra benefits on here!</p>
                    </div>
                </div>
                

                <div class="support-card-container">
                    <div class="general-card"> 
                        <h3>Benefits</h3>
                        <p>Any donations are greatly appreciated!</p>
                        <ul class="benefits">
                            <li><img class="rolling-choya" :src="RollingChoya" alt="Rolling Choya" title="Rolling Choya"> No Ads</li>
                            <li><img class="rolling-choya" :src="RollingChoya" alt="Rolling Choya" title="Rolling Choya"> Auto-entry to website lottery (coming soon)</li>
                            <li><img class="rolling-choya" :src="RollingChoya" alt="Rolling Choya" title="Rolling Choya"> Unique title on Discord (ie "Research Choya")</li>
                            <li><img class="rolling-choya" :src="RollingChoya" alt="Rolling Choya" title="Rolling Choya"> Unique color on Discord</li>
                            
                        </ul>
                    </div>
                </div>
            </div>
            

            <div class="support-card-container">
                

            <div class="support-card" @click="openLink('https://www.patreon.com/peureki')"> 
                    <h3>Patreon</h3>
                    <p class="small-subtitle">Monthly subcriptions starting at $1</p>
                    <div class="support-img-and-svg">
                        <img class="support-icon" :src="ResearchChoya" alt="Research Choya" title="Research Choya">
                        <svg class="icon inactive-arrow" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </div>
                </div>

                <div class="support-card" @click="openLink('https://buy.stripe.com/cN2aGi7B31gY86c4gq')">
                    <h3>Stripe</h3>
                    <p class="small-subtitle">Custom donation</p>
                    <div class="support-img-and-svg">
                        <img class="support-icon" :src="GolemChoya" alt="Golem Choya" title="Golem Choya">
                        <svg class="icon inactive-arrow" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </div>
                </div>

                <div class="support-card" @click="openLink('https://account.venmo.com/')">
                    <h3>Venmo</h3>
                    <p class="small-subtitle">Custom donation, @peureki</p>
                    <div class="support-img-and-svg">
                        <img class="support-icon" :src="BalthazarChoya" alt="Balthazar Choya" title="Balthazar Choya">

                        <svg class="icon inactive-arrow" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </div> 
                </div>
            </div>
        </div>
    </section>

    <section class="main">
        <div class="content-section">
            <h3>Credits</h3>
            <div class=supporter-list-container>
                <div class="supporter-list">
                    <h4 class="underline">Donators</h4>
                    <p class="supporter" v-for="donator in sortedDonators">{{ donator }}</p>
                </div>

                <div class="supporter-list">
                    <h4 class="underline">Researchers</h4>
                    <p class="supporter" v-for="researcher in sortedResearchers">{{ researcher }}</p>
                </div>
            </div>
        </div>    
    </section>

</template>

<script setup>
import { ref, computed } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import RollingChoya from '@/imgs/choyas/Rolling_Choya.png'
import HappyChoya from '@/imgs/choyas/Happy_Choya.png'
import ResearchChoya from '@/imgs/choyas/Research_Choya.png'
import BalthazarChoya from '@/imgs/choyas/Balthazar_Choya.png'
import GolemChoya from '@/imgs/choyas/Golem_Choya.png'

const openLink = (link) => {
    window.open(link, '_blank');
}

const donators = [
    'Ars',
    'Brant C.',
    'Kay Miya',
    'SleepyZeez',
    'Sthep Knyght',
    'Paxton',
    'RichDragon',
    'Alex M.',
    'Lae',
    'Xanterra',
    'Adrian_K',
    'Tiger',
    'KittyBlu',
    'SABI',
    'Snikkens',
    'Michael N. H.',
    'BuD'
];

const researchers = [
    'Malcheor.1407',
    'Manstervile.1785',
    'ars.8416',
    'AllDatAngst.4208',
    'escaiedail.3607',
    'Eddard Stark.3460',
    'talianiara.4317',
    'Nexius.5639',
    'Frenchie.7208',
    'IntensePrehistoricButterfly.6489',
    'Barraind.7324',
    'Tiffy.2305',
    'StarEyes.8712',
    'Odeh.9310',
    'Danimal.2190',
    'Riku Shinobu.4518',
    'Attackins.7031',
    'Jezereal.4321',
    'tiger.2031',
    'Baddodo.1468',
    'Skritt.8720',
    'Valetheia.2407',
    'imdannyboy.6071',
    'Frank.5183',
    'cjosh.4598',
    'Asamel.2178',
    'Andres.8513',
    'itssahana.5194',
    'kanghsi.8391',
    'MCx26',
    'Lite Ning Girl.7958',
    'enjoyincubus.4207',
    'Bianca Nightshade.2340',
    'koalabear.4157',
    'Pandark.1754',
    'Redh',
    'CoffeeDart',
    'Atommakesz',
    'bobdole.6281',
    'GingerSnap.7685',
    'sevenFootPIGMAN.9417',
    'reignman.3059',
    'CrossoverX.1406',
    'GW2Efficiency',
    'BigZThyDoom.8750',
];

const sortedDonators = computed(() => {
    return donators.sort();
})

const sortedResearchers = computed(() => {
    return researchers.sort();
})

</script>

<style scoped>
.content-section{
    display: flex;
    flex-direction: column;
    gap: var(--gap-content);
}

.two-col{
    display: flex;
    gap: var(--gap-content);
}
.description-container{
    display: flex;
    flex-direction: column;
    gap: var(--gap-content);
}

.comment{
    display: flex;
    flex-direction: column;
    gap: var(--gap-content);
    max-width: clamp(15rem, 100vw, 40rem);
}
.benefits > li {
    display: flex;
    align-items: center;
    gap: var(--gap-general);
    padding-block: var(--gap-general);
}

.choya-icon{
    width: 100px;
    height: 100px;
}
.support-card-container{
    display: flex;
    flex-wrap: wrap;
    gap: var(--gap-content);
}
.general-card,
.support-card{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: fit-content;
    padding: var(--gap-content);
    gap: var(--gap-general);
    border: var(--border-general);
    border-radius: var(--border-radius-card);
    background-color: var(--color-bkg-fade);
    transition: var(--transition-all-03s-ease);
    cursor: pointer;
}
.general-card{
    cursor: unset;
}
.support-card:hover{
    border: var(--border-general-link);
}

.support-icon{
    width: 200px;
    height: 200px;
}
.icon{
    width: 50px;
    height: 50px;
}

.support-img-and-svg{
    display: flex;
    align-items: flex-end;
}
.supporter-list-container{
    display: flex;
    flex-wrap: wrap;
    gap: var(--gap-content);
}
.supporter-list{
    display: flex;
    flex-direction: column;
    
    gap: var(--gap-general);
}
.supporter{
    font-size: var(--font-size-h4);
}

@media (max-width: 768px){
    .two-col{
        flex-direction: column;
    }
}

</style>