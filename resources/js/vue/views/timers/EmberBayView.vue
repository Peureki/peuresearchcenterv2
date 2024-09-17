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
        map-name="Ember Bay Timers"
        :map="Map"
        alt="Ember Bay"
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

import Nav from '@/js/vue/components/general/Nav.vue'
import Footer from '@/js/vue/components/general/Footer.vue'

import NodeTrackerModal from '@/js/vue/components/timers/NodeTrackerModal.vue'

import NavTimers from '@/js/vue/components/timers/NavTimers.vue'
import MainTimers from '@/js/vue/components/timers/MainTimers.vue'

// NODES
import AncientWood from '@/imgs/icons/Ancient_Wood_Log.png'
import ElderWood from '@/imgs/icons/Elder_Wood_Log.png'
import PetrifiedWood from '@/imgs/icons/Petrified_Wood.png'
import Mithril from '@/imgs/icons/Mithril_Ore.png'
import Orichalcum from '@/imgs/icons/Orichalcum_Ore.png'
import Flax from '@/imgs/icons/Pile_of_Flax_Seeds.png'
import JunglePlant from '@/imgs/icons/Maguuma_Lily.png'
import Mussel from '@/imgs/icons/Mussel.png'
import SawgillMushroom from '@/imgs/icons/Sawgill_Mushroom.png'
import Lotus from '@/imgs/icons/Lotus_Root.png'
import Passiflora from '@/imgs/icons/Passion_Fruit.png'
import BloomingPassiflora from '@/imgs/icons/Passion_Flower.png'


import EventSwords from '@/imgs/icons/Event_Swords.png'
import EventBoss from '@/imgs/icons/Event_Boss.png'
import EventShield from '@/imgs/icons/Event_Shield.png'
import EventRally from '@/imgs/icons/Event_Rally.png'
import EventCollect from '@/imgs/icons/Event_Collect.png'

import Map from '@/imgs/maps/Ember_Bay.jpg'

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
        name: "Petrified Wood",
        quantity: ref(0),
        src: PetrifiedWood,
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
        name: "Lotus",
        quantity: ref(0),
        src: Lotus,
    },
    {
        name: "Passiflora",
        quantity: ref(0),
        src: Passiflora,
    },
    {
        name: "Blooming Passiflora",
        quantity: ref(0),
        src: BloomingPassiflora,
    },
]

let events = [
    {
        name: "Coalescence West",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 16 + 15),
        initialMin: 60 * 4 + 49,
        initialMax: -(60 * 3 + 35),
        respawnCooldown: ref(60 * 16 + 15), 
        respawnMin: 60 * 4 + 49,
        respawnMax: -(60 * 3 + 35),
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
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'These events will only spawn when a player gets close to them. They are ready when there are sparks and orange leylines. 1) First event is a defense for 3 minutes. 2) Champ Coalescence. This gives a guaranteed rare. Every completed champ gives 3 champ bags instead of 1',
        waypointName: "Promontory Waypoint",
        waypointLink: "[&BF8JAAA=]",
        top: `${78}%`,
        left: `${35}%`,
    },
    {
        name: "Coalescence North",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 16 + 15),
        initialMin: 60 * 4 + 49,
        initialMax: -(60 * 3 + 35),
        respawnCooldown: ref(60 * 16 + 15), 
        respawnMin: 60 * 4 + 49,
        respawnMax: -(60 * 3 + 35),
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
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'These events will only spawn when a player gets close to them. They are ready when there are sparks and orange leylines. 1) First event is a defense for 3 minutes. 2) Champ Coalescence. This gives a guaranteed rare. Every completed champ gives 3 champ bags instead of 1',
        waypointName: "Promontory Waypoint",
        waypointLink: "[&BF8JAAA=]",
        top: `${38}%`,
        left: `${80}%`,
    },
    {
        name: "Coalescence East",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 16 + 15),
        initialMin: 60 * 4 + 49,
        initialMax: -(60 * 3 + 35),
        respawnCooldown: ref(60 * 16 + 15), 
        respawnMin: 60 * 4 + 49,
        respawnMax: -(60 * 3 + 35),
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
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'These events will only spawn when a player gets close to them. They are ready when there are sparks and orange leylines. 1) First event is a defense for 3 minutes. 2) Champ Coalescence. This gives a guaranteed rare. Every completed champ gives 3 champ bags instead of 1',
        waypointName: "Promontory Waypoint",
        waypointLink: "[&BF8JAAA=]",
        top: `${62}%`,
        left: `${95}%`,
    },
    {
        name: "Dominator",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 15 + 0),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 15 + 0), 
        respawnMin: 60 * 1 + 0,
        respawnMax: -(60 * 1 + 0),
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
        info: "1) CC 12 skritts that are surrounded by Destroyers. 2) Boss. Every 25%, it goes invul and will spawn mobs in the lava pit. Can upscale to champs with enough people. Guaranteed rare once per day.",
        waypointName: "Promontory Waypoint",
        waypointLink: "[&BF8JAAA=]",
        top: `${77}%`,
        left: `${83}%`,
    },
    {
        name: "Jade Construct",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 18 + 10),
        initialMin: 60 * 0 + 49,
        initialMax: -(60 * 0 + 29),
        respawnCooldown: ref(60 * 18 + 10), 
        respawnMin: 60 * 0 + 49,
        respawnMax: -(60 * 0 + 29),
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
        info: "1) CC and kill elite Jade Contructs. 2) Champ Jade in the lava pit. The left-most platform is safe from lava if you get pushed back. There will be two instances where you need to grab rocks and throw to CC.",
        waypointName: "Castaway Circus Waypoint",
        waypointLink: "[&BHgJAAA=]",
        top: `${25}%`,
        left: `${7}%`,
    },
    {
        name: "Sloth",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 15 + 0),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 15 + 0), 
        respawnMin: 60 * 1 + 0,
        respawnMax: -(60 * 1 + 0),
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
                type: 'Escort',
                img: EventShield,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "1) Collect Rolling Devil poop and water 2) Escort NPC 3) Kill a champ sloth. Guarantees a rare once per day",
        waypointName: "Castaway Circus Waypoint",
        waypointLink: "[&BHgJAAA=]",
        top: `${70}%`,
        left: `${20}%`,
    },
    {
        name: "Karka",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 20),
        initialMin: 60 * 0 + 39,
        initialMax: -(60 * 0 + 58),
        respawnCooldown: ref(60 * 6 + 20), 
        respawnMin: 60 * 0 + 39,
        respawnMax: -(60 * 0 + 58),
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
                type: 'Rally',
                img: EventRally,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "1) Escort Skritt with waves of Destroyers and Karka. 2) Secure a rally point and kill Karka 3) Champion Karka",
        waypointName: "Scratch Gate Waypoint",
        waypointLink: "[&BFUJAAA=]",
        top: `${40}%`,
        left: `${115}%`,
    },
    {
        name: "Wurm",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 10 + 50),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 10 + 50), 
        respawnMin: 60 * 1 + 0,
        respawnMax: -(60 * 1 + 0),
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
        info: "1) Kill Destroyers and collect energy balls for 4 turrets. 2) Defend the turrets while it powers an NPC that kills the main boss.",
        waypointName: "Crumbling Trail Waypoint",
        waypointLink: "[&BGAJAAA=]",
        top: `${20}%`,
        left: `${76}%`,
    },
    {
        name: "Drake",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 19 + 45),
        initialMin: 60 * 3 + 40,
        initialMax: -(60 * 3 + 1),
        respawnCooldown: ref(60 * 19 + 45), 
        respawnMin: 60 * 3 + 40,
        respawnMax: -(60 * 3 + 1),
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
        info: "Champ Drake. It's underwater, but sometimes can be close enough to be pulled on land.",
        waypointName: "Castaway Circus Waypoint",
        waypointLink: "[&BHgJAAA=]",
        top: `${55}%`,
        left: `${15}%`,
    },
    {
        name: "Captain Huuhes",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 12 + 5),
        initialMin: 60 * 1 + 50,
        initialMax: -(60 * 1 + 30),
        respawnCooldown: ref(60 * 12 + 5), 
        respawnMin: 60 * 1 + 50,
        respawnMax: -(60 * 1 + 30),
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
        info: "Veteran Skritt. Very quick. If there is a CC bar, you can throw a bottle.",
        waypointName: "Scratch Gate Waypoint",
        waypointLink: "[&BFUJAAA=]",
        top: `${50}%`,
        left: `${100}%`,
    },
    {
        name: "Fissure North",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 8 + 40),
        initialMin: 60 * 0 + 31,
        initialMax: -(60 * 1 + 1),
        respawnCooldown: ref(60 * 8 + 40), 
        respawnMin: 60 * 0 + 31,
        respawnMax: -(60 * 1 + 1),
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
        info: "Destroy the fissure. Surrounded by Destroyers. Can upscale if you're here before it spawns.",
        waypointName: "Castaway Circus Waypoint",
        waypointLink: "[&BHgJAAA=]",
        top: `${11}%`,
        left: `${15}%`,
    },
    {
        name: "Fissure East",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 8 + 40),
        initialMin: 60 * 0 + 31,
        initialMax: -(60 * 1 + 1),
        respawnCooldown: ref(60 * 8 + 40), 
        respawnMin: 60 * 0 + 31,
        respawnMax: -(60 * 1 + 1),
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
        info: "Destroy the fissure. Surrounded by Destroyers. Can upscale if you're here before it spawns.",
        waypointName: "Castaway Circus Waypoint",
        waypointLink: "[&BHgJAAA=]",
        top: `${29}%`,
        left: `${94}%`,
    },
    
];

</script>