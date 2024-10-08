<template>
    <Nav>
        <template v-slot:timer>
            <NavTimers
                :outposts="outposts"
                :events="events"
                :meta="meta"
                :checkboxes="checkboxes"
            />
        </template>
    </Nav>

    


    <MainTimers
        map-name="Janthir Syntri Timers"
        :map="Map"
        alt="Janthir Syntri"
        :events="events"
    >
        <template v-slot:nodeTrackerModal>
            <NodeTrackerModal
                :nodes="nodes"
            />
        </template>

        <template v-slot:info>
            <article class="info-content">
                <p>Auric Basin is a unique map where there are pylon(outpost) events that need to be completed before some of the events listed on this page can begin. Each outpost will have a linear chain of events. </p>

                <p>On the navigation, there are <span><img src="@/imgs/icons/Outpost_Active.png">pylon events</span>(North, Souteast, etc). When you complete the final chain of meta-outpost events (the in-game pylon symbol will turn orange), click on the appropiate outpost to start all of that area's timers.</p>

                <p>Since this map is unique, these events have two different kinds of timers. The initial spawn when you complete their meta-outpost events and their respawn timers. After completing an event for the first time, a new cooldown will initiate.</p>
                <p>Priority pylons to complete: South &#x2192; Southeast &#x2192; West &#x2192; West-North &#x2192; North (if has progress already) &#x2192; Southwest &#x2192; East</p>

                <p>Repeatable priority of events:</p>
                <ul class="list-general">
                    <li>1. Veteran Vinetooths</li>
                    <li>2. Blighted Saplings (south)</li>
                    <li>3. Wyvern (southeast)</li>
                    <li>4. Golden Ooze (west)</li>
                    <li>5. Gold Guzzler (west-north)</li>
                    <li>6. Stalk (north)</li>
                    <li>7. Stoneheads (southwest & if squad has great DPS/CC)</li>
                    <li>8. Priory Escorts</li>
                </ul>
            </article>
        </template>
    </MainTimers>

    <Footer/>
</template>

<script setup>
import { ref } from 'vue'
import { isMobile } from '@/js/vue/composables/Global'

import Nav from '@/js/vue/components/general/Nav.vue'
import Footer from '@/js/vue/components/general/Footer.vue'

import NodeTrackerModal from '@/js/vue/components/timers/NodeTrackerModal.vue'

import NavTimers from '@/js/vue/components/timers/NavTimers.vue'
import MainTimers from '@/js/vue/components/timers/MainTimers.vue'

// NODES
import AncientWood from '@/imgs/icons/Ancient_Wood_Log.png'
import ElderWood from '@/imgs/icons/Elder_Wood_Log.png'
import Mithril from '@/imgs/icons/Mithril_Ore.png'
import Orichalcum from '@/imgs/icons/Orichalcum_Ore.png'
import Flax from '@/imgs/icons/Pile_of_Flax_Seeds.png'
import JunglePlant from '@/imgs/icons/Maguuma_Lily.png'
import Mussel from '@/imgs/icons/Mussel.png'
import SawgillMushroom from '@/imgs/icons/Sawgill_Mushroom.png'

import EventSwords from '@/imgs/icons/Event_Swords.png'
import EventBoss from '@/imgs/icons/Event_Boss.png'
import EventShield from '@/imgs/icons/Event_Shield.png'
import EventRally from '@/imgs/icons/Event_Rally.png'
import EventCollect from '@/imgs/icons/Event_Collect.png'
import EventBounty from '@/imgs/icons/Bounty_Target.png'
import EventHand from '@/imgs/icons/Event_Hand.png'

import Map from '@/imgs/maps/Janthir_Syntri.webp'

// INPUT META AND PRE-META TIMES
// name: [name of the event]
// starts: [[hour, min]] 
// If hour is odd UTC, do 3. If even, do 2
let meta = [

]
// APPLY ONLY if the map has outposts or events that have start collectively when a certain area is completed
let outposts = [
]

let checkboxes = [
    {
        name: "Veteran Vinetooth",
        toggle: ref(true),
    },
    {
        name: "Priory Explorer",
        toggle: ref(true),
    },
]

let nodes = [
    {
        name: "Ancient Sapling",
        quantity: ref(0),
        src: AncientWood,
    },
    {
        name: "Palm Sapling",
        quantity: ref(0),
        src: ElderWood,
    },
    {
        name: "Mithril Ore",
        quantity: ref(0),
        src: Mithril, 
    },
    {
        name: "Orichalcum Ore",
        quantity: ref(0),
        src: Orichalcum,
    },
    {
        name: "Jungle Plants",
        quantity: ref(0),
        src: JunglePlant,
    },
    {
        name: "Flax",
        quantity: ref(0),
        src: Flax,
    },
    {
        name: "Mussels",
        quantity: ref(0),
        src: Mussel,
    },
    {
        name: "Sawgill Mushrooms",
        quantity: ref(0),
        src: SawgillMushroom,
    },
]

let events = [
    {
        name: "Camp Threats",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 12 + 55),
        initialMin: 60 * 1 + 5,
        initialMax: -(60 * 1 + 5),
        respawnCooldown: ref(60 * 12 + 55), 
        respawnMin: 60 * 1 + 5,
        respawnMax: -(60 * 1 + 5),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Skirmish',
                img: EventSwords,
            },
        ],
        info: 'Interact with tents and crates to spawn mobs',
        waypointName: "Forager's Hunt Waypoint",
        waypointLink: "[&BLcOAAA=]",
        top: `${85}%`,
        left: `${100}%`, 
    },
    {
        name: "Storm Chaser",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 12 + 45),
        initialMin: 60 * 0 + 29,
        initialMax: -(60 * 0 + 47),
        respawnCooldown: ref(60 * 12 + 45), 
        respawnMin: 60 * 0 + 29,
        respawnMax: -(60 * 0 + 47),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Defense',
                img: EventShield,
            },
        ],
        info: '3 waves of large mobs',
        waypointName: "Stricken Plains Waypoint",
        waypointLink: "[&BCoPAAA=]",
        top: `${35}%`,
        left: `${105}%`, 
    },
    {
        name: "Leviathan",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 23 + 35),
        initialMin: 60 * 1 + 26,
        initialMax: -(60 * 1 + 8),
        respawnCooldown: ref(60 * 23 + 35), 
        respawnMin: 60 * 1 + 26,
        respawnMax: -(60 * 1 + 8),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Collect',
                img: EventCollect,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'Pre-event is to collect debris. Then Levi in the water',
        waypointName: "Stricken Plains Waypoint",
        waypointLink: "[&BCoPAAA=]",
        top: `${19}%`,
        left: `${102}%`, 
    },
    {
        name: "Iboga",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 8 + 20),
        initialMin: 60 * 0 + 34,
        initialMax: -(60 * 0 + 28),
        respawnCooldown: ref(60 * 8 + 20), 
        respawnMin: 60 * 0 + 34,
        respawnMax: -(60 * 0 + 28),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Skrimish',
                img: EventSwords,
            },
        ],
        info: 'SO MANY IBOGAS',
        waypointName: "Forager's Hunt Waypoint",
        waypointLink: "[&BLcOAAA=]",
        top: `${79}%`,
        left: `${115}%`, 
    },
    {
        name: "Ekto",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 10),
        initialMin: 60 * 1,
        initialMax: -(60 * 1),
        respawnCooldown: ref(60 * 10), 
        respawnMin: 60 * 1,
        respawnMax: -(60 * 1),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Interact',
                img: EventHand,
            },
        ],
        info: 'Interact with shiny stuff and spirits will spawn',
        waypointName: "Sanguine Crater Waypoint",
        waypointLink: "[&BCwPAAA=]",
        top: `${62}%`,
        left: `${53}%`, 
    },
    {
        name: "Gosta",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 10 + 20),
        initialMin: 60 * 1,
        initialMax: -(60 * 1),
        respawnCooldown: ref(60 * 10 + 20), 
        respawnMin: 60 * 1,
        respawnMax: -(60 * 1),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'Similar to a bounty and spawns spirits from the cliffs',
        waypointName: "Sanguine Crater Waypoint",
        waypointLink: "[&BCwPAAA=]",
        top: `${60}%`,
        left: `${33}%`, 
    },
];

</script>