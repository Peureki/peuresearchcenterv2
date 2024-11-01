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
        map-name="Domain of Kourna Timers"
        :map="Map"
        alt="Domain of Kourna"
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

import Map from '@/imgs/maps/Domain_of_Kourna.jpg'

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
        name: "Scarab Plague Meta",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 30 + 0),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 30 + 0), 
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
                type: 'Defence',
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
        info: "1) Turn in Spare Parts (gathered from events nad mobs) to start the meta. There will be 3 pylons throughout the map to destroy too. 2) Defend 3 cannons for a few minutes. Mob do scale, but do not give loot. 3) Defend a couple rally points at Gendara, each will have a chest. 4) Kill a champ that phases every 25%. Then kill random lab equipments. Consume 'key' in your inventory to access the chest room. ",
        waypointName: "Allied Encampment Waypoint",
        waypointLink: "[&BFcLAAA=]",
        top: `${85}%`,
        left: `${60}%`,
    },
    {
        name: "Researcher Emm",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 9 + 10),
        initialMin: 60 * 0 + 29,
        initialMax: -(60 * 0 + 22),
        respawnCooldown: ref(60 * 9 + 10), 
        respawnMin: 60 * 0 + 29,
        respawnMax: -(60 * 0 + 22),
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
                type: 'Escort',
                img: EventShield,
            },
        ],
        info: "First event is just killing rats. Second event is the money marker escort. There are two possible outcomes for this escort. The escort will always spawn waves of Hyenas, but then diverge into 1 of 2 paths. 1) Left path with Skales 2) Right path with Bats. Path 1 is better for better spawn points and loot. ",
        waypointName: "Allied Encampment Waypoint",
        waypointLink: "[&BFcLAAA=]",
        top: `${20}%`,
        left: `${30}%`,
    },
    {
        name: "Researcher Siris",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 8 + 35),
        initialMin: 60 * 0 + 13,
        initialMax: -(60 * 0 + 17),
        respawnCooldown: ref(60 * 8 + 35), 
        respawnMin: 60 * 0 + 13,
        respawnMax: -(60 * 0 + 17),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Defence',
                img: EventShield,
            },
        ],
        info: "Make sure to kill mobs within the NPC's white circle range. First area of defense does not grant loot and only EXP. Second area of defense does.",
        waypointName: "Allied Encampment Waypoint",
        waypointLink: "[&BFcLAAA=]",
        top: `${40}%`,
        left: `${35}%`,
    },
    {
        name: "Researcher Siris",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 8 + 35),
        initialMin: 60 * 0 + 13,
        initialMax: -(60 * 0 + 17),
        respawnCooldown: ref(60 * 8 + 35), 
        respawnMin: 60 * 0 + 13,
        respawnMax: -(60 * 0 + 17),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Defence',
                img: EventShield,
            },
        ],
        info: "Make sure to kill mobs within the NPC's white circle range. First area of defense does not grant loot and only EXP. Second area of defense does.",
        waypointName: "Allied Encampment Waypoint",
        waypointLink: "[&BFcLAAA=]",
        top: `${40}%`,
        left: `${35}%`,
    },
    {
        name: "Cannons",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 5 + 20),
        initialMin: 60 * 0 + 26,
        initialMax: -(60 * 0 + 23),
        respawnCooldown: ref(60 * 5 + 20), 
        respawnMin: 60 * 0 + 26,
        respawnMax: -(60 * 0 + 23),
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
        info: "Unlike the meta, instead of defending, you're killing the cannons. Only one of the three cannons will be active at a time. You can focus on killing mobs to extend the event's duration for more waves.",
        waypointName: "Apizmic Grounds Waypoint",
        waypointLink: "[&BFALAAA=]",
        top: `${45}%`,
        left: `${90}%`,
    },
    {
        name: "Choya Chieftain",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 14 + 55),
        initialMin: 60 * 5 + 17,
        initialMax: -(60 * 6 + 54),
        respawnCooldown: ref(60 * 14 + 55), 
        respawnMin: 60 * 5 + 17,
        respawnMax: -(60 * 6 + 54),
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
        info: "Veteran Choya. If the fight prolongs, then it summons more choyas",
        waypointName: "Apizmic Grounds Waypoint",
        waypointLink: "[&BFALAAA=]",
        top: `${31}%`,
        left: `${115}%`,
    },
    {
        name: "Champion Shark",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 13 + 30),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 13 + 30), 
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
        info: "Champion Sand Shark",
        waypointName: "Apizmic Grounds Waypoint",
        waypointLink: "[&BFALAAA=]",
        top: `${20}%`,
        left: `${95}%`,
    },
    {
        name: "Inquest Lab",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 13 + 5),
        initialMin: 60 * 1 + 25,
        initialMax: -(60 * 1 + 16),
        respawnCooldown: ref(60 * 13 + 5), 
        respawnMin: 60 * 1 + 25,
        respawnMax: -(60 * 1 + 16),
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
        info: "There will be a holographic wall that prevents the cave from being entered. It's halfway between the top of the cliff. Press F to activate and it will spawn the mobs",
        waypointName: "Allied Encampment Waypoint",
        waypointLink: "[&BFcLAAA=]",
        top: `${28}%`,
        left: `${65}%`,
    },
    {
        name: "Researcher Maggin",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 7 + 5),
        initialMin: 60 * 0 + 35,
        initialMax: -(60 * 0 + 56),
        respawnCooldown: ref(60 * 7 + 5), 
        respawnMin: 60 * 0 + 35,
        respawnMax: -(60 * 0 + 56),
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
        ],
        info: "Escort with 3 waves and a champ at the end. The last wave does not upscale and the champ does not give loot.",
        waypointName: "Allied Encampment Waypoint",
        waypointLink: "[&BFcLAAA=]",
        top: `${60}%`,
        left: `${29}%`,
    },
    {
        name: "Awakened Abomination",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 12 + 5),
        initialMin: 60 * 1 + 37,
        initialMax: -(60 * 2 + 39),
        respawnCooldown: ref(60 * 12 + 5), 
        respawnMin: 60 * 1 + 37,
        respawnMax: -(60 * 2 + 39),
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
        info: "Champ Awakened Abomination. RIP everyone. When the shields are up, stand behind someone, or a clone, minion, and do not attack.",
        waypointName: "Allied Encampment Waypoint",
        waypointLink: "[&BFcLAAA=]",
        top: `${60}%`,
        left: `${65}%`,
    },
    {
        name: "Bounty Agasaya",
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
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Dies fairly quick with DPS. Avoid bomb aoes to avoid being knockdown.",
        waypointName: "Allied Encampment Waypoint",
        waypointLink: "[&BFcLAAA=]",
        top: `${50}%`,
        left: `${0}%`,
    },
    {
        name: "Bounty Aspohdel",
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
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Iboga. Dies fairly quick with DPS and is easy to handle",
        waypointName: "Allied Encampment Waypoint",
        waypointLink: "[&BFcLAAA=]",
        top: `${55}%`,
        left: `${0}%`,
    },
    {
        name: "Bounty Cabochon",
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
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Branded Griffon. Evades while flying..otherwise dies fairly quickly",
        waypointName: "Allied Encampment Waypoint",
        waypointLink: "[&BFcLAAA=]",
        top: `${60}%`,
        left: `${0}%`,
    },
    {
        name: "Bounty Enbilulu",
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
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Sand Shark. Careful of the spinny spins",
        waypointName: "Allied Encampment Waypoint",
        waypointLink: "[&BFcLAAA=]",
        top: `${65}%`,
        left: `${0}%`,
    },
    {
        name: "Bounty Troopmarshal",
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
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Legendary Awakened. Prepare to be YEETED. Take the portal for the meta to get there faster",
        waypointName: "Allied Encampment Waypoint",
        waypointLink: "[&BFcLAAA=]",
        top: `${70}%`,
        left: `${0}%`,
    },
];

</script>