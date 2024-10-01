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
        map-name="Lowland Shore Timers"
        :map="Map"
        alt="Lowland Shore"
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
import Mithril from '@/imgs/icons/Mithril_Ore.png'
import Orichalcum from '@/imgs/icons/Orichalcum_Ore.png'
import Flax from '@/imgs/icons/Pile_of_Flax_Seeds.png'
import DesertHerbs from '@/imgs/icons/Coriander_Seed.png'
import DesertVegs from '@/imgs/icons/Head_of_Garlic.png'
import Mussel from '@/imgs/icons/Mussel.png'
import GhostPepper from '@/imgs/icons/Ghost_Pepper.png'
import Lentils from '@/imgs/icons/Handful_of_Red_Lentils.png'

import EventSwords from '@/imgs/icons/Event_Swords.png'
import EventBoss from '@/imgs/icons/Event_Boss.png'
import EventShield from '@/imgs/icons/Event_Shield.png'
import EventRally from '@/imgs/icons/Event_Rally.png'
import EventCollect from '@/imgs/icons/Event_Collect.png'

import Map from '@/imgs/maps/Lowland_Shore.webp'

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
    // {
    //     name: "Veteran Vinetooth",
    //     toggle: ref(true),
    // },
    // {
    //     name: "Priory Explorer",
    //     toggle: ref(true),
    // },
]

let nodes = [
    {
        name: "Ancient Sapling",
        quantity: ref(0),
        src: AncientWood,
    },
    {
        name: "Mebahya Sapling",
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
        name: "Cluster of Desert Herbs",
        quantity: ref(0),
        src: DesertHerbs,
    },
    {
        name: "Desert Vegetables",
        quantity: ref(0),
        src: DesertVegs,
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
        name: "Ghost Pepper",
        quantity: ref(0),
        src: GhostPepper,
    },
    {
        name: "Lentils",
        quantity: ref(0),
        src: Lentils,
    },
]

let events = [
    {
        name: "Champion Warg",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 7 + 40),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 4 + 40), 
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
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Every 25%, use Warclaw to CC",
        waypointName: "Harvest Den Waypoint",
        waypointLink: "[&BK4OAAA=]",
        top: `${50}%`,
        left: `${110}%`,
    },
    {
        name: "Titanspawn #1",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 10 + 5),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 10 + 5), 
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
                type: 'Skrimish',
                img: EventSwords,
            },
        ],
        info: "Skirmish of titanspawn mobs. Two waves",
        waypointName: "Journeykin Outpost Waypoint",
        waypointLink: "[&BPsOAAA=]",
        top: `${60}%`,
        left: `${28}%`,
    },
    {
        name: "Titanspawn #2",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 10 + 5),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 10 + 5), 
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
                type: 'Skrimish',
                img: EventSwords,
            },
        ],
        info: "Skirmish of titanspawn mobs. Two waves",
        waypointName: "Journeykin Outpost Waypoint",
        waypointLink: "[&BPsOAAA=]",
        top: `${46}%`,
        left: `${38}%`,
    },
    {
        name: "Titanspawn #3",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 10 + 5),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 10 + 5), 
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
                type: 'Skrimish',
                img: EventSwords,
            },
        ],
        info: "Skirmish of titanspawn mobs. Two waves",
        waypointName: "Autumn's Vale Waypoint",
        waypointLink: "[&BC4PAAA=]",
        top: `${17}%`,
        left: `${70}%`,
    },
    {
        name: "Titanspawn #3",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 10 + 5),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 10 + 5), 
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
                type: 'Skrimish',
                img: EventSwords,
            },
        ],
        info: "Skirmish of titanspawn mobs. Two waves",
        waypointName: "Harvest Den Waypoint",
        waypointLink: "[&BK4OAAA=]",
        top: `${17}%`,
        left: `${70}%`,
    },
    {
        name: "Titanspawn #4",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 10 + 5),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 10 + 5), 
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
                type: 'Skrimish',
                img: EventSwords,
            },
        ],
        info: "Skirmish of titanspawn mobs. Two waves",
        waypointName: "Astral Ward Moon Camp Waypoint",
        waypointLink: "[&BCcPAAA=]",
        top: `${75}%`,
        left: `${72}%`,
    },
    {
        name: "Titanspawn #5",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 10 + 5),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 10 + 5), 
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
                type: 'Skrimish',
                img: EventSwords,
            },
        ],
        info: "Skirmish of titanspawn mobs. Two waves",
        waypointName: "Astral Ward Moon Camp Waypoint",
        waypointLink: "[&BCcPAAA=]",
        top: `${38}%`,
        left: `${113}%`,
    },
    {
        name: "Bog Queen",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 45),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 6 + 45), 
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
                type: 'Skrimish',
                img: EventSwords,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Skirmish of titanspawn mobs, then Bog Queen boss where at some HP intervals you must go on your warclaw to dash through maggots",
        waypointName: "Journeykin Outpost Waypoint",
        waypointLink: "[&BPsOAAA=]",
        top: `${15}%`,
        left: `${25}%`,
    },
    {
        name: "Drake Matriarch",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 45),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 6 + 45), 
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
            {
                type: 'Collect',
                img: EventCollect,
            },
        ],
        info: "Collect fish that's been reeled in by the NPC. Champ Drake (need lots of CC). Finish with an event to prepare fish",
        waypointName: "Autumn's Vale Waypoint",
        waypointLink: "[&BC4PAAA=]",
        top: `${30}%`,
        left: `${57}%`,
    },
    {
        name: "Driftwood",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 12 + 55),
        initialMin: 60 * 0 + 35,
        initialMax: -(60 * 0 + 35),
        respawnCooldown: ref(60 * 12 + 55), 
        respawnMin: 60 * 0 + 35,
        respawnMax: -(60 * 0 + 35),
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
        ],
        info: "Collect driftwood",
        waypointName: "Autumn's Vale Waypoint",
        waypointLink: "[&BC4PAAA=]",
        top: `${45}%`,
        left: `${54}%`,
    },
    {
        name: "Valraven",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 3 + 0),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 3 + 0), 
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
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Champion Valraven",
        waypointName: "Autumn's Vale Waypoint",
        waypointLink: "[&BC4PAAA=]",
        top: `${25}%`,
        left: `${40}%`,
    },
    {
        name: "Jagged Sierra",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 4 + 50),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 4 + 50), 
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
                type: 'Escort',
                img: EventShield,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "3 waves of titanspawns then elite or champ at the end depending on the scale",
        waypointName: "Hot Springs Waypoint",
        waypointLink: "[&BMkOAAA=]",
        top: `${65}%`,
        left: `${45}%`,
    },
    {
        name: "Blighted Beast",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 30),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 6 + 30), 
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
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Champion titanspawn",
        waypointName: "Hot Springs Waypoint",
        waypointLink: "[&BMkOAAA=]",
        top: `${75}%`,
        left: `${55}%`,
    },
    {
        name: "Timber Wolf",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 30),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 6 + 30), 
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
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Champion titanspawn",
        waypointName: "Astral Ward Moon Camp Waypoint",
        waypointLink: "[&BCcPAAA=]",
        top: `${85}%`,
        left: `${85}%`,
    },
    {
        name: "Sleuth Brawlfields",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 5 + 0),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 5 + 0), 
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
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Various different events from champs to activities",
        waypointName: "Harvest Den Waypoint",
        waypointLink: "[&BK4OAAA=]",
        top: `${23}%`,
        left: `${103}%`,
    },
    {
        name: "Sleuth Brawlfields",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 3 + 0),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 3 + 0), 
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
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Various different events from champs to activities",
        waypointName: "Harvest Den Waypoint",
        waypointLink: "[&BK4OAAA=]",
        top: `${15}%`,
        left: `${103}%`,
    },
];

</script>