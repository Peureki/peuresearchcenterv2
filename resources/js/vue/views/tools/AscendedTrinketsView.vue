<template>
    <Nav/>
    <Header page-name="Ascended Trinkets"/>

    <!--
        *
        * RECOMMENDED
        *
    -->
    <section class="main">
        <div class="content-section">
            <h2>Recommendation</h2>
            <p class="small-subtitle">If you frequently do fractals, raids, sPvP, or WvW, then I recommend those trinkets as they are not unique. 
                <span class="link" @click="wiki('Mist Talisman')"> Accessory, </span> 
                <span class="link" @click="wiki('Mist Band (Infused)')"> Ring, </span>
                <span class="link" @click="wiki('Mist Pendant')"> Amulet </span>
            </p>

            <div class="card-grid-container">
                <div class="card-grid">
                    <Card
                        :main-icon="BitterfrostAccessory"
                        main-label="Black Ice Earring"
                        rarity="Ascended"
                        :requirements="[
                            {src: Winterberries, label: 'Fresh Winterberries', quantity: 300},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 4000}
                            
                        ]"
                        location="Accessory | Bitterfrost Frontier, Living Story 3"
                    />
                    <Card
                        :main-icon="BitterfrostRing"
                        main-label="Black Ice Band"
                        rarity="Ascended"
                        :requirements="[
                            {src: Winterberries, label: 'Fresh Winterberries', quantity: 200},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 2000}
                            
                        ]"
                        location="Ring | Bitterfrost Frontier, Living Story 3"
                    >
                        <p>Merp</p>
                    </Card>
                    <Card
                        :main-icon="BjoraAmulet"
                        main-label="Asgeir's Amulet"
                        rarity="Ascended"
                        :requirements="[
                            {src: EternalIceShard, label: 'Eternal Ice Shard', quantity: 375},
                            {src: Karma, label: 'Karma', quantity: 56000}
                        ]"
                        location="Amulet | Bjora Marches, Icebrood Saga"
                    />
                </div>
                <div class="card-grid">
                    <Card
                        :main-icon="BjoraAccessory"
                        main-label="Asgeir's Talisman"
                        rarity="Ascended"
                        :requirements="[
                            {src: EternalIceShard, label: 'Eternal Ice Shard', quantity: 375},
                            {src: Karma, label: 'Karma', quantity: 56000}
                        ]"
                        location="Accessory | Bjora Marches, Icebrood Saga"
                    />
                    <Card
                        :main-icon="LowlandRing2"
                        main-label="Ring of the Crustacean"
                        rarity="Ascended"
                        :requirements="[
                            {src: UrsusOblige, label: 'Ursus Oblige', quantity: 550},
                            {src: Gold, label: 'Gold', quantity: 5}
                        ]"
                        location=" Ring | Lowland Shore, Janthir Wilds"
                    />
                    <Card
                        :main-icon="SirensBackBalthazar"
                        main-label="Relic of Balthazar"
                        rarity="Ascended"
                        :requirements="[
                            {src: OrrianPearl, label: 'Orrian Pearl', quantity: 200},
                            {src: Karma, label: 'Karma', quantity: 315000}
                            
                        ]"
                        location="Backpiece (any Siren's) | Siren's Landing, Living Story 3"
                    ></Card>
                    
                </div>
            </div>
            
        </div>
    </section>
    <!--
        *
        * ACCESSORY
        *
    -->
    <section class="main">
        <div class="content-section">
            <h2>Accessories</h2>
            <div class="card-grid-container">
                <div class="card-grid">
                    <Card
                        :main-icon="EmberBayAccessory"
                        main-label="Sparking Petrified Wood"
                        rarity="Ascended"
                        :requirements="[
                            {src: PetrifiedWood, label: 'Petrified Wood', quantity: 150},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 4000}
                        ]"
                        location="Ember Bay, Living Story 3"
                    />  
                    <Card
                        :main-icon="SandsweptAccessory"
                        main-label="Multifaceted Difluorite Earrings"
                        rarity="Ascended"
                        :requirements="[
                            {src: DifluoriteCrystal, label: 'Difluorite Crystal', quantity: 150},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 4000}
                            
                        ]"
                        location="Sandswept Isles, Living Story 4"
                    />  
                    <Card
                        :main-icon="BjoraAccessory"
                        main-label="Asgeir's Talisman"
                        rarity="Ascended"
                        :requirements="[
                            {src: EternalIceShard, label: 'Eternal Ice Shard', quantity: 375},
                            {src: Karma, label: 'Karma', quantity: 56000}
                        ]"
                        location="Bjora Marches, Icebrood Saga"
                    />
                </div>
                <div class="card-grid">
                    <Card
                        :main-icon="BitterfrostAccessory"
                        main-label="Black Ice Earring"
                        rarity="Ascended"
                        :requirements="[
                            {src: Winterberries, label: 'Fresh Winterberries', quantity: 300},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 4000}
                            
                        ]"
                        location="Bitterfrost Frontier, Living Story 3"
                    />  
                    <Card
                        :main-icon="DragonfallAccessory"
                        main-label="Mists-Charged Treasure"
                        rarity="Ascended"
                        :requirements="[
                            {src: MistbornMote, label: 'Mistborn Mote', quantity: 150},
                            {src: VolatileMagic, label: 'Volatile Magic', quantity: 4000}
                        ]"
                        location="Dragonfall, Living Story 4"
                    />
                    
                </div>
            </div>
            
        </div>
    </section>
    <!--
        *
        * RING
        *
    -->
    <section class="main">
        <div class="content-section">
            <h2>Rings</h2>
            <div class="card-grid-container">
                <div class="card-grid">
                    <Card
                        :main-icon="BloodstoneRing"
                        main-label="Blood Ruby Band"
                        rarity="Ascended"
                        :requirements="[
                            {src: BloodRuby, label: 'Blood Ruby', quantity: 100},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 2000}
                        ]"
                        location="Bloodstone Fen, Living Story 3"
                    />
                    <Card
                        :main-icon="DraconisRing"
                        main-label="Gilded Orchid Band"
                        rarity="Ascended"
                        :requirements="[
                            {src: FireOrchidBlossom, label: 'Fire Orchid Blossom', quantity: 100},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 2000}
                            
                        ]"
                        location="Draconis Mons, Living Story 3"
                    >
                        <p>Merp</p>
                    </Card>
                    <Card
                        :main-icon="DragonfallRing"
                        main-label="Mistborn Band"
                        rarity="Ascended"
                        :requirements="[
                            {src: MistbornMote, label: 'Mistborn Mote', quantity: 100},
                            {src: VolatileMagic, label: 'Volatile Magic', quantity: 2000}
                            
                        ]"
                        location="Dragonfall, Living Story 4"
                    >
                        <p>Merp</p>
                    </Card>
                    <Card
                        :main-icon="LowlandRing1"
                        main-label="Wood Rune Ring"
                        rarity="Ascended"
                        :requirements="[
                            {src: UnusualCoin, label: 'Unusual Coin', quantity: 800},
                            {src: Gold, label: 'Gold', quantity: 4}
                        ]"
                        location="Lowland Shore, Janthir Wilds"
                    />
                </div>
                <div class="card-grid">
                    <Card
                        :main-icon="BitterfrostRing"
                        main-label="Black Ice Band"
                        rarity="Ascended"
                        :requirements="[
                            {src: Winterberries, label: 'Fresh Winterberries', quantity: 200},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 2000}
                            
                        ]"
                        location="Bitterfrost Frontier, Living Story 3"
                    >
                        <p>Merp</p>
                    </Card>
                    <Card
                        :main-icon="SandsweptRing"
                        main-label="Difluorite Band"
                        rarity="Ascended"
                        :requirements="[
                            {src: DifluoriteCrystal, label: 'Difluorite Crystal', quantity: 100},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 2000}
                            
                        ]"
                        location="Sandswept Isles, Living Story 4"
                    >
                        <p>Merp</p>
                    </Card>
                    <Card
                        :main-icon="LowlandRing2"
                        main-label="Ring of the Crustacean"
                        rarity="Ascended"
                        :requirements="[
                            {src: UrsusOblige, label: 'Ursus Oblige', quantity: 550},
                            {src: Gold, label: 'Gold', quantity: 5}
                        ]"
                        location="Lowland Shore, Janthir Wilds"
                    />
                </div>
            </div>
        </div>
    </section>
    <!--
        *
        * AMULET
        *
    -->
    <section class="main">
        <div class="content-section">
            <h2>Amulets</h2>
            <div class="card-grid-container">
                <div class="card-grid">
                    <Card
                        :main-icon="BloodstoneAmulet"
                        main-label="Blood Ruby Pendant"
                        rarity="Ascended"
                        :requirements="[
                            {src: BloodRuby, label: 'Blood Ruby', quantity: 125},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 3000}
                        ]"
                        location="Bloodstone Fen, Living Story 3"
                    />
                    <Card
                        :main-icon="DraconisAmulet"
                        main-label="Fire Orchid Garland"
                        rarity="Ascended"
                        :requirements="[
                            {src: FireOrchidBlossom, label: 'Fire Orchid Blossom', quantity: 125},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 3000}
                            
                        ]"
                        location="Draconis Mons, Living Story 3"
                    >
                        <p>Merp</p>
                    </Card> 
                    <Card
                        :main-icon="DragonfallAmulet"
                        main-label="Scion-Spike Amulet"
                        rarity="Ascended"
                        :requirements="[
                            {src: MistbornMote, label: 'Mistborn Mote', quantity: 125},
                            {src: VolatileMagic, label: 'Volatile Magic', quantity: 3000}
                            
                        ]"
                        location="Dragonfall, Living Story 4"
                    >
                        <p>Merp</p>
                    </Card>   
                </div>
                <div class="card-grid">
                    <Card
                        :main-icon="LakeDoricAmulet"
                        main-label="Jade Pendant"
                        rarity="Ascended"
                        :requirements="[
                            {src: JadeShard, label: 'Jade Shard', quantity: 125},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 3000}
                            
                        ]"
                        location="Lake Doric, Living Story 3"
                    >
                        <p>Merp</p>
                    </Card> 
                    <Card
                        :main-icon="SirensAmulet"
                        main-label="Coral Choker"
                        rarity="Ascended"
                        :requirements="[
                            {src: OrrianPearl, label: 'Orrian Pearl', quantity: 125},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 3000}
                            
                        ]"
                        location="Siren's Landing, Living Story 3"
                    >
                        <p>Merp</p>
                    </Card> 
                </div>
            </div>
            
        </div>
    </section>
    <!--
        *
        * BACKPIECE
        *
    -->
    <section class="main">
        <div class="content-section">
            <h2>Backpieces</h2>
            <div class="card-grid-container">
                <div class="card-grid">
                    <Card
                        :main-icon="BloodstoneBack"
                        main-label="Blood Ruby Backpack"
                        rarity="Ascended"
                        :requirements="[
                            {src: BloodRuby, label: 'Blood Ruby', quantity: 200},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 5000}
                        ]"
                        location="Bloodstone Fen, Living Story 3"
                    />
                    <Card
                        :main-icon="BitterfrostBack"
                        main-label="Icebrood Horn Backpack"
                        rarity="Ascended"
                        :requirements="[
                            {src: Winterberries, label: 'Fresh Winterberries', quantity: 400},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 5000}
                        ]"
                        location="Bitterfrost Frontier, Living Story 3"
                    />
                    <Card
                        :main-icon="SirensBackBalthazar"
                        main-label="Relic of Balthazar"
                        rarity="Ascended"
                        :requirements="[
                            {src: OrrianPearl, label: 'Orrian Pearl', quantity: 200},
                            {src: Karma, label: 'Karma', quantity: 315000}
                            
                        ]"
                        location="Siren's Landing, Living Story 3"
                    >
                        <p>Merp</p>
                    </Card>
                    <Card
                        :main-icon="SirensBackGrenth"
                        main-label="Relic of Grenth"
                        rarity="Ascended"
                        :requirements="[
                            {src: OrrianPearl, label: 'Orrian Pearl', quantity: 200},
                            {src: Karma, label: 'Karma', quantity: 315000}
                            
                        ]"
                        location="Siren's Landing, Living Story 3"
                    >
                        <p>Merp</p>
                    </Card>
                    <Card
                        :main-icon="SirensBackMelandru"
                        main-label="Relic of Melandru"
                        rarity="Ascended"
                        :requirements="[
                            {src: OrrianPearl, label: 'Orrian Pearl', quantity: 200},
                            {src: Karma, label: 'Karma', quantity: 315000}
                            
                        ]"
                        location="Siren's Landing, Living Story 3"
                    >
                        <p>Merp</p>
                    </Card>
                </div>
                <div class="card-grid">
                    <Card
                        :main-icon="EmberBayBack"
                        main-label="Lava Skull Backpack"
                        rarity="Ascended"
                        :requirements="[
                            {src: PetrifiedWood, label: 'Petrified Wood', quantity: 200},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 5000}
                        ]"
                        location="Ember Bay, Living Story 3"
                    />
                    <Card
                        :main-icon="LakeDoricBack"
                        main-label="White Mantle Scroll"
                        rarity="Ascended"
                        :requirements="[
                            {src: JadeShard, label: 'Jade Shard', quantity: 200},
                            {src: UnboundMagic, label: 'Unbound Magic', quantity: 5000}
                            
                        ]"
                        location="Lake Doric, Living Story 3"
                    >
                        <p>Merp</p>
                    </Card>
                    <Card
                        :main-icon="SirensBackDwayna"
                        main-label="Relic of Dwayna"
                        rarity="Ascended"
                        :requirements="[
                            {src: OrrianPearl, label: 'Orrian Pearl', quantity: 200},
                            {src: Karma, label: 'Karma', quantity: 315000}
                            
                        ]"
                        location="Siren's Landing, Living Story 3"
                    >
                        <p>Merp</p>
                    </Card>
                    <Card
                        :main-icon="SirensBackLyssa"
                        main-label="Relic of Lyssa"
                        rarity="Ascended"
                        :requirements="[
                            {src: OrrianPearl, label: 'Orrian Pearl', quantity: 200},
                            {src: Karma, label: 'Karma', quantity: 315000}
                            
                        ]"
                        location="Siren's Landing, Living Story 3"
                    >
                        <p>Merp</p>
                    </Card>
                </div>
            </div>
            
        </div>
    </section>

    <Footer/>
</template>

<script setup>

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import Card from '@/js/vue/components/general/Card.vue'
import Disclaimer from '@/js/vue/components/general/Disclaimer.vue'

import { wiki } from '@/js/vue/composables/BasicFunctions'

// Bloodstone Fen
import BloodstoneRing from '@/imgs/icons/Blood_Ruby_Band.png'
import BloodstoneAmulet from '@/imgs/icons/Blood_Ruby_Pendant.png'
import BloodstoneBack from '@/imgs/icons/Blood_Ruby_Backpack.png'

// Ember Bay
import EmberBayAccessory from '@/imgs/icons/Sparking_Petrified_Wood.png'
import EmberBayBack from '@/imgs/icons/Lava_Skull_Backpack.png'

// Bitterfrost 
import BitterfrostRing from '@/imgs/icons/Black_Ice_Band.png'
import BitterfrostAccessory from '@/imgs/icons/Black_Ice_Earring.png'
import BitterfrostBack from '@/imgs/icons/Icebrood_Horn_Backpack.png'
import BitterfrostAquatic from '@/imgs/icons/Benthic_Breather.png'

// Lake Doric
import LakeDoricAmulet from '@/imgs/icons/Jade_Pendant.png'
import LakeDoricBack from '@/imgs/icons/White_Mantle_Scroll.png'

// Draconis Mons
import DraconisAmulet from '@/imgs/icons/Fire_Orchid_Garland.png'
import DraconisRing from '@/imgs/icons/Gilded_Orchid_Band.png'

// Siren's Landing
import SirensAmulet from '@/imgs/icons/Coral_Choker.png'
import SirensBackBalthazar from '@/imgs/icons/Relic_of_Balthazar.png'
import SirensBackDwayna from '@/imgs/icons/Relic_of_Dwayna.png'
import SirensBackGrenth from '@/imgs/icons/Relic_of_Grenth.png'
import SirensBackLyssa from '@/imgs/icons/Relic_of_Lyssa.png'
import SirensBackMelandru from '@/imgs/icons/Relic_of_Melandru.png'

// Sandswept Isles
import SandsweptRing from '@/imgs/icons/Difluorite_Band.png'
import SandsweptAccessory from '@/imgs/icons/Multifaceted_Difluorite_Earrings.png'

// Dragonfall
import DragonfallAccessory from '@/imgs/icons/Egg_of_the_Crystal_Queen.png'
import DragonfallAmulet from '@/imgs/icons/Scion-Spike_Amulet.png'
import DragonfallRing from '@/imgs/icons/Armbrace_of_Truth.png'

// Bjora Marches
import BjoraAmulet from "@/imgs/icons/Asgeir's_Amulet.png"
import BjoraAccessory from "@/imgs/icons/Asgeir's_Talisman.png"

// Lowland Shore
import LowlandRing1 from '@/imgs/icons/Wood_Rune_Ring.png'
import LowlandRing2 from "@/imgs/icons/Ring_of_the_Crustacean.png"

// Currencies
import UnboundMagic from '@/imgs/icons/Unbound_Magic.png'
import BloodRuby from '@/imgs/icons/Blood_Ruby.png'
import PetrifiedWood from '@/imgs/icons/Petrified_Wood.png'
import Winterberries from '@/imgs/icons/Fresh_Winterberry.png'
import JadeShard from '@/imgs/icons/Jade_Shard.png'
import FireOrchidBlossom from '@/imgs/icons/Fire_Orchid_Blossom.png'
import OrrianPearl from '@/imgs/icons/Orrian_Pearl.png'
import DifluoriteCrystal from '@/imgs/icons/Difluorite_Crystal.png'
import MistbornMote from '@/imgs/icons/Mistborn_Mote.png'
import VolatileMagic from '@/imgs/icons/Volatile_Magic.png'
import EternalIceShard from '@/imgs/icons/Eternal_Ice_Shard.png'
import Karma from '@/imgs/icons/Karma.png'
import UrsusOblige from '@/imgs/icons/Ursus_Oblige.png'
import Gold from '@/imgs/icons/Gold.png'
import UnusualCoin from '@/imgs/icons/Unusual_Coin.png'


</script>

<style scoped>
.content-section{
    display: flex;
    flex-direction: column;
    gap: var(--gap-content);
}
.card-grid{
    /* flex-direction: unset; */
    flex-wrap: wrap;
}
</style>