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
        map-name="Sandswept Isles Timers"
        :map="Map"
        alt="Sandswept Isles"
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
import Difluorite from '@/imgs/icons/Difluorite_Crystal.png'
import AncientWood from '@/imgs/icons/Ancient_Wood_Log.png'
import ElderWood from '@/imgs/icons/Elder_Wood_Log.png'
import Mithril from '@/imgs/icons/Mithril_Ore.png'
import Orichalcum from '@/imgs/icons/Orichalcum_Ore.png'
import Flax from '@/imgs/icons/Pile_of_Flax_Seeds.png'
import DesertHerb from '@/imgs/icons/Coriander_Seed.png'
import DesertVeg from '@/imgs/icons/Head_of_Garlic.png'
import Lentils from '@/imgs/icons/Handful_of_Red_Lentils.png'
import Artichoke from '@/imgs/icons/Artichoke.png'
import Cabbage from '@/imgs/icons/Head_of_Cabbage.png'
import Coral from '@/imgs/icons/Coral_Orb.png'
import Passiflora from '@/imgs/icons/Passion_Flower.png'
import Mussel from '@/imgs/icons/Mussel.png'

import EventSwords from '@/imgs/icons/Event_Swords.png'
import EventBoss from '@/imgs/icons/Event_Boss.png'
import EventShield from '@/imgs/icons/Event_Shield.png'
import EventRally from '@/imgs/icons/Event_Rally.png'
import EventBounty from '@/imgs/icons/Bounty_Target.png'
// MAP
import Map from '@/imgs/maps/Sandswept_Isles.jpg'

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
    
]

let nodes = [
    {
        name: "Difluorite Crystals",
        quantity: ref(0),
        src: Difluorite,
    },
    {
        name: "Baoba Sapling",
        quantity: ref(0),
        src: ElderWood,
    },
    {
        name: "Eerie Driftwood",
        quantity: ref(0),
        src: ElderWood,
    },
    {
        name: "Ancient Sapling",
        quantity: ref(0),
        src: AncientWood,
    },
    {
        name: "Mithril Ore",
        quantity: ref(0),
        src: Mithril, 
    },
    {
        name: "Rich Mithril Ore",
        quantity: ref(0),
        src: Mithril, 
    },
    {
        name: "Orichalcum Ore",
        quantity: ref(0),
        src: Orichalcum,
    },
    {
        name: "Rich Orichalcum Ore",
        quantity: ref(0),
        src: Orichalcum,
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
        name: "Cluster of Desert Herbs",
        quantity: ref(0),
        src: DesertHerb,
    },
    {
        name: "Desert Vegetables",
        quantity: ref(0),
        src: DesertVeg,
    },
    {
        name: "Artichoke",
        quantity: ref(0),
        src: Artichoke,
    },
    {
        name: "Lentils",
        quantity: ref(0),
        src: Lentils,
    },
    {
        name: "Cabbage",
        quantity: ref(0),
        src: Cabbage,
    },
    {
        name: "Passiflora",
        quantity: ref(0),
        src: Passiflora,
    },
    {
        name: "Coral",
        quantity: ref(0),
        src: Coral,
    },
]

let events = [
    {
        name: "Gathering Storms",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 33 + 0),
        initialMin: 60 * 0 + 51,
        initialMax: -(60 * 0 + 50),
        respawnCooldown: ref(60 * 33 + 0), 
        respawnMin: 60 * 0 + 51,
        respawnMax: -(60 * 0 + 50),
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
                type: 'Skirmish',
                img: EventSwords,
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
        info: "North meta. 1) First event, there are 4 roaming skirmishes roaming around the north. They will labeled on the mini map. They do not spawn all at once. --- 2) There will be 3 events with 3 champions each --- 3) Escort will start from the north waypoint --- 4) Main boss. Bring CC and condi cleanses to avoid Slow",
        waypointName: "Atholma Waypoint",
        waypointLink: "[&BEMLAAA=]",
        top: `${15}%`,
        left: `${40}%`,
    },
    {
        name: "Specimen Chamber",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 40 + 0),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 10 + 0),
        respawnCooldown: ref(60 * 40 + 0), 
        respawnMin: 60 * 1 + 0,
        respawnMax: -(60 * 10 + 0),
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
        info: "1) There are 3 sections where enemies spawn. There will always be two ongoing at a time. The next wave won't spawn until one of the waves have been decimated. 2) Multiple boss fights. It's random what boss you'll get. You fight two bosses, one at a time, then both. They share the same HP",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${50}%`,
        left: `${60}%`,
    },
    {
        name: "Dominus Crystallum",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 12 + 5),
        initialMin: 60 * 1 + 37,
        initialMax: -(60 * 1 + 19),
        respawnCooldown: ref(60 * 12 + 5), 
        respawnMin: 60 * 1 + 37,
        respawnMax: -(60 * 1 + 19),
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
        info: "Cute lil wyvern. This gives a daily chest with 3 Difluorite and uni gear.",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${51}%`,
        left: `${15}%`,
    },
    // 4
    {
        name: "Awakened Patrol",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 7 + 10),
        initialMin: 60 * 0 + 38,
        initialMax: -(60 * 0 + 47),
        respawnCooldown: ref(60 * 7 + 10), 
        respawnMin: 60 * 0 + 38,
        respawnMax: -(60 * 0 + 47),
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
        info: "Group of vet Awakened mobs. They swap spawn locations. If you killed the group that spawned on the west side of the water, then it will spawn on the east side and vise versa.",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${55}%`,
        left: `${65}%`,
    },
    // 4
    {
        name: "Inquest Patrol @1",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 11 + 25),
        initialMin: 60 * 1 + 24,
        initialMax: -(60 * 1 + 12),
        respawnCooldown: ref(60 * 11 + 25), 
        respawnMin: 60 * 1 + 24,
        respawnMax: -(60 * 1 + 12),
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
        info: "Group of Inquest mobs. There are 3 possible locations for this. 1) Eastern Complex, 2) Between Western Complex and Damos Isles, 3) south of Eastern Complex",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${45}%`,
        left: `${90}%`,
        sync: [4, 5, 6],
    },
    // 5
    {
        name: "Inquest Patrol @2",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 11 + 25),
        initialMin: 60 * 1 + 24,
        initialMax: -(60 * 1 + 12),
        respawnCooldown: ref(60 * 11 + 25), 
        respawnMin: 60 * 1 + 24,
        respawnMax: -(60 * 1 + 12),
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
        info: "Group of Inquest mobs. There are 3 possible locations for this. 1) Eastern Complex, 2) Between Western Complex and Damos Isles, 3) south of Eastern Complex",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${46}%`,
        left: `${30}%`,
        sync: [4, 5, 6],
    },
    // 6
    {
        name: "Inquest Patrol @3",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 11 + 25),
        initialMin: 60 * 1 + 24,
        initialMax: -(60 * 1 + 12),
        respawnCooldown: ref(60 * 11 + 25), 
        respawnMin: 60 * 1 + 24,
        respawnMax: -(60 * 1 + 12),
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
        info: "Group of Inquest mobs. There are 3 possible locations for this. 1) Eastern Complex, 2) Between Western Complex and Damos Isles, 3) south of Eastern Complex",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${85}%`,
        left: `${110}%`,
        sync: [4, 5, 6],
    },
    // 7
    {
        name: "Inquest Data @1",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 55),
        initialMin: 60 * 0 + 52,
        initialMax: -(60 * 0 + 36),
        respawnCooldown: ref(60 * 6 + 55), 
        respawnMin: 60 * 0 + 52,
        respawnMax: -(60 * 0 + 36),
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
        info: "Group of Iquest mobs and an Inquest champ",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${42}%`,
        left: `${50}%`,
        sync: [7, 8, 9],
    },
    // 8
    {
        name: "Inquest Data @2",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 55),
        initialMin: 60 * 0 + 52,
        initialMax: -(60 * 0 + 36),
        respawnCooldown: ref(60 * 6 + 55), 
        respawnMin: 60 * 0 + 52,
        respawnMax: -(60 * 0 + 36),
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
        info: "Group of Iquest mobs and an Inquest champ",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${62}%`,
        left: `${30}%`,
        sync: [7, 8, 9],
    },
    // 9
    {
        name: "Inquest Data @3",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 55),
        initialMin: 60 * 0 + 52,
        initialMax: -(60 * 0 + 36),
        respawnCooldown: ref(60 * 6 + 55), 
        respawnMin: 60 * 0 + 52,
        respawnMax: -(60 * 0 + 36),
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
        info: "Group of Iquest mobs and an Inquest champ",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${92}%`,
        left: `${101}%`,
        sync: [7, 8, 9],
    },
    // 10
    {
        name: "Mark III Golem @1",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 10 + 5),
        initialMin: 60 * 1 + 41,
        initialMax: -(60 * 1 + 53),
        respawnCooldown: ref(60 * 10 + 5), 
        respawnMin: 60 * 1 + 41,
        respawnMax: -(60 * 1 + 53),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Boss',
                img: EventSwords,
            },
        ],
        info: "Same as the Inquest Golem world boss. This gives a daily chest of 3 Difluorite Crystals and uni gear. There are 3 possible spawn locations. 1) Western Complex, 2) Damos Isles, 3) Invarient Enclave.",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${47}%`,
        left: `${47}%`,
        sync: [10, 11, 12],
    },
    // 11
    {
        name: "Mark III Golem @2",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 10 + 5),
        initialMin: 60 * 1 + 41,
        initialMax: -(60 * 1 + 53),
        respawnCooldown: ref(60 * 10 + 5), 
        respawnMin: 60 * 1 + 41,
        respawnMax: -(60 * 1 + 53),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Boss',
                img: EventSwords,
            },
        ],
        info: "Same as the Inquest Golem world boss. This gives a daily chest of 3 Difluorite Crystals and uni gear. There are 3 possible spawn locations. 1) Western Complex, 2) Damos Isles, 3) Invarient Enclave.",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${68}%`,
        left: `${37}%`,
        sync: [10, 11, 12],
    },
    // 12
    {
        name: "Mark III Golem @3",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 10 + 5),
        initialMin: 60 * 1 + 41,
        initialMax: -(60 * 1 + 53),
        respawnCooldown: ref(60 * 10 + 5), 
        respawnMin: 60 * 1 + 41,
        respawnMax: -(60 * 1 + 53),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Boss',
                img: EventSwords,
            },
        ],
        info: "Same as the Inquest Golem world boss. This gives a daily chest of 3 Difluorite Crystals and uni gear. There are 3 possible spawn locations. 1) Western Complex, 2) Damos Isles, 3) Invarient Enclave.",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${72}%`,
        left: `${102}%`,
        sync: [10, 11, 12],
    },
    {
        name: "Power Cores",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 12 + 5),
        initialMin: 60 * 1 + 58,
        initialMax: -(60 * 2 + 4),
        respawnCooldown: ref(60 * 12 + 5), 
        respawnMin: 60 * 1 + 58,
        respawnMax: -(60 * 2 + 4),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(true),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Gathering',
                img: EventBoss,
            },
        ],
        info: "Kill Inquest around the perimeter and turn in power cores in the building",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${51}%`,
        left: `${110}%`,
    },
    // * START OF BOUNTIES
    // *
    // *
    {
        name: "Starcaller",
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
                type: 'Bounty',
                img: EventBounty,
            },
        ],
        info: "Legendary hydra",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${7}%`,
        left: `${70}%`,
    },
    {
        name: "Seneb",
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
                type: 'Bounty',
                img: EventBounty,
            },
        ],
        info: "Legendary Awakened",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        top: `${64}%`,
        left: `${47}%`,
    },
];

</script>