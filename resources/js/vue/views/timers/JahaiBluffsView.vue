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
        map-name="Jahai Bluffs Timers"
        :map="Map"
        alt="Jahai Bluffs"
        :events="events"
    >
        <template v-slot:nodeTrackerModal>
            <NodeTrackerModal
                :nodes="nodes"
            />
        </template>

        <template v-slot:info>
            <article class="info-content">
                <p>Coming soon</p>
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
import EventBounty from '@/imgs/icons/Bounty_Target.png'

import Map from '@/imgs/maps/Jahai_Bluffs.webp'

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
        name: "Vatendi Village",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 23),
        initialMin: 60 * 3,
        initialMax: -(60 * 1 + 45),
        respawnCooldown: ref(60 * 23), 
        respawnMin: 60 * 3,
        respawnMax: -(60 * 1 + 45),
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
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'Multiple spawns of enemies around the village. Then, 2 elites and 2 champions',
        waypointName: "Yatendi Village Waypoint",
        waypointLink: "[&BH4LAAA=]",
        top: `${63}%`,
        left: `${100}%`, 
    },
    {
        name: "Ziya",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 13 + 45),
        initialMin: 60 * 0 + 50,
        initialMax: -(60 * 1 + 11),
        respawnCooldown: ref(60 * 13 + 45), 
        respawnMin: 60 * 0 + 50,
        respawnMax: -(60 * 1 + 11),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Escort',
                img: EventShield,
            },
            {
                type: 'Skirmish',
                img: EventSwords,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'Escort Ziya through multiple waves of Branded (can upscale to champs). Then a quick destruction of a crystal, then a Djinn boss',
        waypointName: "Yatendi Village Waypoint",
        waypointLink: "[&BH4LAAA=]",
        top: `${85}%`,
        left: `${103}%`, 
    },
    {
        name: "Ziya",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 13 + 45),
        initialMin: 60 * 0 + 50,
        initialMax: -(60 * 1 + 11),
        respawnCooldown: ref(60 * 13 + 45), 
        respawnMin: 60 * 0 + 50,
        respawnMax: -(60 * 1 + 11),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Escort',
                img: EventShield,
            },
            {
                type: 'Skirmish',
                img: EventSwords,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'Escort Ziya through multiple waves of Branded (can upscale to champs). Then a quick destruction of a crystal, then a Djinn boss',
        waypointName: "Yatendi Village Waypoint",
        waypointLink: "[&BH4LAAA=]",
        top: `${85}%`,
        left: `${103}%`, 
    },
    {
        name: "Chantry",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 13 + 5),
        initialMin: 60 * 2,
        initialMax: -(60 * 2),
        respawnCooldown: ref(60 * 13 + 5), 
        respawnMin: 60 * 2,
        respawnMax: -(60 * 2),
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
        info: 'Split the group up into 3 areas and defend',
        waypointName: "Reclaimed Chantry Waypoint",
        waypointLink: "[&BJkLAAA=]",
        top: `${10}%`,
        left: `${90}%`, 
    },
    {
        name: "DERV",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 14 + 40),
        initialMin: 60 * 1 + 20,
        initialMax: -(60 * 1 + 20),
        respawnCooldown: ref(60 * 14 + 40), 
        respawnMin: 60 * 1 + 20,
        respawnMax: -(60 * 1 + 20),
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
        info: 'Quick champion DERV',
        waypointName: "Soul's Vendetta Waypoint",
        waypointLink: "[&BIMLAAA=]",
        top: `${77}%`,
        left: `${30}%`, 
    },
    {
        name: "Legendary Wyverns",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 30),
        initialMin: 60 * 1,
        initialMax: -(60 * 1),
        respawnCooldown: ref(60 * 30), 
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
                type: 'Bounty',
                img: EventBounty,
            },
        ],
        info: 'Legendary bounty Wyverns',
        waypointName: "Reclaimed Chantry Waypoint",
        waypointLink: "[&BJkLAAA=]",
        top: `${20}%`,
        left: `${55}%`, 
    },
];

</script>