<template>
    <div class="guide-container">
        <h3>Guide</h3>

        <!-- 
            *
            * REQUIREMENTS & RECOMMENDATIONS;
            *
        -->
        <h4>Requirements & Recommendations</h4>
        <div class="requirements-and-recommendations">
            <!--
                *
                * REQUIREMENTS
                *
            -->
            <div class="requirements-container">
                <h5>Requirements</h5>
                
                <div class="requirement">
                    <p>Masteries</p>
                    <ul>
                        <li class="img-and-label">
                            <img :src="Springer" alt="Springer" title="Springer">
                            <p>Springer for heights</p>
                        </li>
                        <li class="img-and-label">
                            <img :src="Jackal" alt="Jackal" title="Jackal">
                            <p>Jackal for distance and portals</p>
                        </li>
                        <li class="img-and-label">
                            <img :src="UpdraftUseMastery" alt="Updraft Use" title="Updraft Use">
                            <p>Updraft Use</p>
                        </li>
                    </ul>
                </div>

                <div class="requirement">
                    <p>Buffs</p>
                    <ul>
                        <li class="img-and-label">
                            <img :src="KarmicRetribution" alt="Karmic Retribution" title="Karmic Retribution">
                            <p><a href="https://wiki.guildwars2.com/wiki/Karmic_Retribution_(Dragonfall)" target="_blank">Karmic Retribution</a> (at least tier 1) will forces each mob to drop a Retribution, which will force drop volatile magic</p>
                        </li>
                    </ul>
                </div>

                <div class="requirement">
                    <p>Story</p>
                    <ul>
                        <li class="img-and-label">
                            <img :src="LS4Achievements" alt="Living Story 4, Episode 6" title="Living Story 4, Episode 6">
                            <p>Living Story 4, Episode 6</p>
                        </li>
                    </ul>
                </div>
            </div>
            <!--
                *
                * RECOMMENDATIONS
                *
            -->
            <div class="recommendations-container">
                <h5>Recommendations</h5>

                <div class="requirement">
                    <p>Masteries</p>
                    <ul>
                        <li class="img-and-label">
                            <img :src="RollerBeetle" alt="Roller Beetle" title="Roller Beetle">
                            <p>Roller Beetle for bridges + get around quickly</p>
                        </li>
                        <li class="img-and-label">
                            <img :src="Griffon" alt="Griffon" title="Griffon">
                            <p>Griffon to get around quickly</p>
                        </li>
                        <li class="img-and-label">
                            <img :src="Skyscale" alt="Skyscale" title="Skyscale">
                            <p>Skyscale for general purposes</p>
                        </li>
                        <li class="img-and-label">
                            <img :src="ThermalPropulsion" alt="Thermal Propulsion" title="Thermal Propulsion">
                            <p>Thermal Propulsion for thermal tubes (weeeee)</p>
                        </li>
                    </ul>
                </div>
                <div class="requirement">
                    <p>Gathering Tools</p>
                    <div class="gathering-tools">
                        <div class="glyphs">
                            <img :src="GlyphOfVolatility" alt="Glyph of Volatility" title="Glyph of Volatility">
                            <img :src="GlyphOfVolatility" alt="Glyph of Volatility" title="Glyph of Volatility">
                            <img :src="GlyphOfBounty" alt="Glyph of Bounty" title="Glyph of Bounty">
                        </div>
                        <p class="small-subtitle">Volatility, Volatility, Bounty</p>
                    </div>

                    <p>Or</p>

                    <div class="img-and-label">
                        <img :src="SickleOfBounty" alt="Harvesting Sickle of Bounty" title="Harvesting Sickle of Bounty">
                        <p><a href="https://wiki.guildwars2.com/wiki/Harvesting_Sickle_of_Bounty" target="_blank">Harvesting Sickle of Bounty</a></p>
                    </div>

                    <p>Volatility for general Volatile Magic, Bounty for extra Mistborn Motes</p>
                </div>
            </div>
        </div>
        

        <!-- 
            *
            * TLDR;
            *
        -->
        <h4>TLDR;</h4>
        <p class="small-subtitle">Assuming you start on a fresh map</p>
        <ul>
            <li>1. Escort from main waypoint to end of each camp</li>
            <li>2. Each camp: 3 Culls, Brandstorm, Champ, then their meta-event. Menders spawns at level 2 at Olmakhan, level 3 for Crystal Bloom, Mist Warden</li>
            <li>3. When camps are complete, split everyone ~2+ per escort/defense throughout the map. 6 escorts, 6 defenses.</li>
            <li>4. High DPS for Weak Points, so much that the elites can't regenerate HP fast enough/won't retaliate as much</li>
            <li>6. At 6/12 Weak Points, split squad to each Shrine and kill champs simulatanously</li>
            <li>7. Destroy final 6 Weak Points, follow champ train route</li>
            <li>8. Extra Mistborn Mote farm</li>
        </ul>

        <p>To keep track of the event timers, I recommend my <router-link to="/timers/dragonfall" target="_blank">Dragonfall Timer Page</router-link>, especially for Menders or Bridge events.</p>

        <!-- 
            *
            * SUMMARY;
            *
        -->
        <h4>Summary</h4>
        <p>Dragonfall is split into three sections: Crystal Bloom (northwest), Olmakhan (southwest), and Mist Warden (southeast). Each camp will need to start with an escort from the main waypoint to the end of the section to spawn their respective waypoint. Each camp have a unique main-chain event that needs to progress in order to achieve the next camp level, up to 4. Besides the main-chain, each camp has the same repeatable events with a very low respawn rate that are needed for chest keys and to fill each camp's progress bar: 3 Culls, Brandstorm, and a Champion. At later levels, there are Menders that spawn in each camp and will provide an additional 3 chests. After all camps have reached level 4, a pre-meta event will spawn with 2 escorts and 2 defences at each camp. Once the meta begins, players will need to DPS 6 'Weak Points', kill 3 champions simulatanously, and finally another 6 Weak Points. The post-meta event chain will consist of 9 champions, 3 in each camp, that will provide 3 chests per champ and extra Mistborn Motes near the areas of the meta champs. </p>

        <!-- 
            *
            * DEEP DIVE
            *
        -->
        <h3>Deep Dive</h3>
        <!-- 
            *
            * BRIDGE EVENTS AND ESCORTS
            *
        -->
        <h4>1. Bridge events & first escorts</h4>
        <p>There are 4 Bridge events that spawn immediately after each map reset or fresh map. If you need Bridge events, it's possible to do all 4 and <router-link to="/timers/dragonfall" target="_blank">track</router-link> them all. For trains, it's possibly to hit 2 before the main escorts begin: one directly west and one directly south of the main waypoint. The escorts take about 2 minutes to start up. When they are ready, you'll see a tangerine symbol above their heads on the map. It's preferred to do these escorts in this order:</p>

        <ul>
            <li>1. Mist Warden</li>
            <li>2. Crystal Bloom</li>
            <li>3. Olmakhan</li>
        </ul>

        <p>You can start all of these events at the same time. But, make sure that you follow the order (or at least keep track of them) because each of these escorts will spawn 3 Mistborn Chests at the end. Both Mist Warden and Crystal Bloom have a relatively short escort compared to Olmakhan and that's why it's last. By starting them all at the same time, there may be a lone player or group trying to push forward each escort and this will save a lot of time to get to the final meta.</p>

        <img class="map-guide" :src="BridgesAndEscorts" alt="Bridges and Escorts" title="Bridges and Escorts">

        <!-- 
            *
            * CAMPS
            *
        -->
        <h4>2. Camps</h4>
        <p>Once each escort has been completed, a series of events will start throughout each camp. This guide focuses on the 3 Culls, a Brandstorm, a Champ. Each camp will also have a main event that will need to be progressed regardless if the progress bar is complete. It's recommended to do the other events and then the main event as the main might progress by pugs or on the way.Doing one rotation of Culls, Brandstorm, Champ, and the main *should* be enough to progress to the next level, but if not, the culls have a very low respawn rate of ~4 minutes.</p>

        <Disclaimer 
            type="caution"
            message="For cull events, it's recommended to do a 'small poke'. Either boon or hit mobs with very small damage so others can get credit as it's incredibly easy to complete." 
        />

        <p>Mender events start spawning after level 2 in Olmakhan and level 3 for both Crystal Bloom and Mist Warden. When these spawn, they should take priority as they offer 3 Mistborn Chests. After each respective camp reaches their level and made an announcement on screen, then the Menders will spawn ~2 minutes and 25 seconds after. They will respawn ~8 minutes and 55 seconds.</p>

        <p>Based on this, the order of camps that should get completed are listed below, BUT since Olmakhan is recommended to finish last on their escort and it takes a bit to spawn their events, I recommend Mist Warden to level 2, then Olmakhan to level 2 to spawn the Mender. Othewise:</p>

        <ul>
            <li>1. Olmakhan</li>
            <li>2. Mist Warden</li>
            <li>3. Crystal Bloom </li>
        </ul>

        <Disclaimer 
            type="caution"
            message="For the Mender at Crystal Bloom, it's highly recommended to give superspeed to the NPC because for some reason it's walking in 0.25 speed." 
        />

        <img class="map-guide" :src="CampEvents" alt="Camp Events" title="Camp Events">

        <!-- 
            *
            * PRE-META
            *
        -->
        <h4>3. Pre-meta</h4>

        <p>After the camps have reached level 4, there will be 2 escorsts and 2 defenses at each camp. It is best to split everyone with at least 2 people per event. The faster this progresses, the faster the meta can start.</p>

        <Disclaimer 
            type="caution"
            message="If you desperate for keys, you can tag more than 1 event" 
        />

        <img class="map-guide" :src="EscortsAndReflectors" alt="Escorts and Reflectors" title="Escorts and Reflectors">

        <!-- 
            *
            * META
            *
        -->
        <h4>4. Meta</h4>

        <p>Before the meta beings, there will be a ~2 minute wait period. It's best to prep your food, buffs and gather everyone at the southwest shrine. Once the timer is up, you'll see on your mini map where the Weak Spots are. Alternatively, you could do a strat where you split the group into 3 groups, one at each Shrine and do the same process, but 1 large group works just fine. You need to hit 6/12 to spawn the 3 legendaries that will be near each shrine.</p>

        <Disclaimer 
            type="caution"
            message="You can waypoint to each Shrine even in combat!"
        />

        <p>Make sure you kill each legendary simulatanously! I suggest getting to around ~20% and waiting for the last legendary to reach that point to burn. There's only a 30 second window to kill them all. Because of the 1 group stat, most people will be inclined to go to Matriarch as it's the closest. So, as the commander or if you know this meta, I recommend the other two. When all 3 legendaries are complete, whatever Weak Spot is near you, head to it. There should be enough of a split for everyone to complete the rest of the meta.</p>

        <Disclaimer 
            type="caution"
            message="The higher the DPS, the less chance for the Mender to invoke retaliation and healing to the Weak Point."
        />

        <img class="map-guide" :src="Meta" alt="Meta" title="Meta">

        <!-- 
            *
            * POST-META CHAMPS
            *
        -->
        <h4>5. Post-Meta Champs</h4>

        <p>After the meta, everyone will be redirected to the northwest Shrine to gather the chests. In about a minute, 9 champions will spawn, 3 at each camp. Follow the route below for a smooth track. If you don't have a flying mount, there are alternative routes and I highly recommend a Jackal.</p>

        <img class="map-guide" :src="Champions" alt="Champions" title="Champions">

        <!-- 
            *
            * MISTBORN MOTE FARM
            *
        -->
        <h4>6. Mistborn Mote Farm</h4>

        <p>After the meta, there are 6 Mistborn Motes that will spawn where the legendary Wraithbringer and Hydra were. These will respawn after each meta and can only be obtained that way. There are also other Mistborn Motes scattered throughout Kralk's body that used to be inaccessible.</p>

        <img class="map-guide" :src="MistbornMotes" alt="Mistborn Motes" title="Mistborn Motes">
    </div>
</template>

<script setup>
// COMPONENTS
import Disclaimer from '@/js/vue/components/general/Disclaimer.vue'

// MOUNTS
import Springer from '@/imgs/icons/Springer.png'
import Jackal from '@/imgs/icons/Jackal.png'
import RollerBeetle from '@/imgs/icons/Roller_Beetle.png'
import Griffon from '@/imgs/icons/Griffon.png'
import Skyscale from '@/imgs/icons/Skyscale.png'

// MASTERIES
import ThermalPropulsion from '@/imgs/icons/masteries/Thermal_Propulsion.png'
import UpdraftUseMastery from '@/imgs/icons/masteries/Updraft_Use.png'

// BUFFS
import KarmicRetribution from '@/imgs/icons/Karmic_Retribution.png'

// ACHIEVEMENTS
import LS4Achievements from '@/imgs/icons/War_Eternal.png'

// GLYPHS AND TOOLS
import GlyphOfBounty from '@/imgs/icons/glyphs/Glyph_of_Bounty.png'
import GlyphOfVolatility from '@/imgs/icons/glyphs/Glyph_of_Volatility.png'
import SickleOfBounty from '@/imgs/icons/glyphs/Harvesting_Sickle_of_Bounty.png'

// MAP GUIDES
import BridgesAndEscorts from '@/imgs/guides/maps/dragonfall/Bridges_And_Escorts.webp'
import CampEvents from '@/imgs/guides/maps/dragonfall/Camp_Events.webp'
import Champions from '@/imgs/guides/maps/dragonfall/Champions.webp'
import EscortsAndReflectors from '@/imgs/guides/maps/dragonfall/Escorts_And_Reflectors.webp'
import Meta from '@/imgs/guides/maps/dragonfall/Meta.webp'
import MistbornMotes from '@/imgs/guides/maps/dragonfall/Mistborn_Motes.webp'
</script>