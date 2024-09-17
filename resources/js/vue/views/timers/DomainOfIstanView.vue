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
        map-name="Domain of Istan Timers"
        :map="Map"
        alt="Domain of Istan"
        :events="events"
    >
        <template v-slot:nodeTrackerModal>
            <NodeTrackerModal
                :nodes="nodes"
            />
        </template>

        <template v-slot:info>
            <article class="info-content">
                <p>Istan has two metas and the best time to start a train is to start with Palawadan. While the Great Hall meta can spawn at any moment as long as you kill enough Mordent Cresent, it always will spawn at the xx:20 mark after Palawadan. This makes farming this map more structured and easier to manage.</p>

                <p>In between metas, there should be enough time to do all the recommended events below at least once. If you're not doing a farm that should last an hour, then you can finish your farm after Great Hall.</p>

                <p>Repeatable priority of events:</p>
                <ul class="list-general">
                    <li>1. Metas</li>
                    <li>2. Akali or Book Raid</li>
                    <li>3. Pirates</li>
                    <li>4. Graveyard</li>
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
import DesertHerb from '@/imgs/icons/Coriander_Seed.png'
import DesertVeg from '@/imgs/icons/Head_of_Garlic.png'
import Lentils from '@/imgs/icons/Handful_of_Red_Lentils.png'
import Seaweed from '@/imgs/icons/Seaweed.png'
import Mussel from '@/imgs/icons/Mussel.png'
import SawgillMushroom from '@/imgs/icons/Sawgill_Mushroom.png'

import EventSwords from '@/imgs/icons/Event_Swords.png'
import EventBoss from '@/imgs/icons/Event_Boss.png'
import EventShield from '@/imgs/icons/Event_Shield.png'
import EventRally from '@/imgs/icons/Event_Rally.png'
// MAP
import Map from '@/imgs/maps/Domain_of_Istan.jpg'

// INPUT META AND PRE-META TIMES
// name: [name of the event]
// starts: [[hour, min]] 
// If hour is odd UTC, do 3. If even, do 2
let meta = [
    {
        name: "Palawadan",
        starts: [3, 45],
        repeats: 2,
        cooldown: ref(0),
        progress: ref(0),
        status: ref(false),
    },
    {
        name: "Great Hall",
        starts: [2, 20],
        repeats: 2,
        cooldown: ref(0),
        progress: ref(0),
        status: ref(false),
    },
]
// APPLY ONLY if the map has outposts or events that have start collectively when a certain area is completed
let outposts = [
]

let checkboxes = [
    
]

let nodes = [
{
        name: "Baoba Sapling",
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
        name: "Seaweed",
        quantity: ref(0),
        src: Seaweed,
    },
    {
        name: "Lentils",
        quantity: ref(0),
        src: Lentils,
    },
]

let events = [
    {
        name: "Akili",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 15 + 15),
        initialMin: 60 * 1 + 59,
        initialMax: -(60 * 0 + 58),
        respawnCooldown: ref(60 * 15 + 15), 
        respawnMin: 60 * 1 + 59,
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
        ],
        info: "NOTE: If this event is ongoing, then AKILI won't spawn. AKILI will spawn 6m 30s after a successful Book event. If AKILI is ongoing, then this event won't spawn. This event will spawn 2m 30s after a successful Akili event *unless* AKILI finished after 15m of the previous Book event. At that point, the respawn timer is unknown. --- There are 3 rounds of defenses. The mobs have a weird spawn where they spawn underground and can take damage. Can upscale to champs",
        waypointName: "Astralarium Waypoint",
        waypointLink: "[&BPoKAAA=]",
        top: `${18}%`,
        left: `${30}%`,
    },
    {
        name: "Book Raid",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 19 + 50),
        initialMin: 60 * 2 + 27,
        initialMax: -(60 * 1 + 7),
        respawnCooldown: ref(60 * 19 + 50), 
        respawnMin: 60 * 2 + 27,
        respawnMax: -(60 * 1 + 7),
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
        info: "NOTE: If this event is ongoing, then AKILI won't spawn. AKILI will spawn 6m 30s after a successful Book event. If AKILI is ongoing, then this event won't spawn. This event will spawn 2m 30s after a successful Akili event *unless* AKILI finished after 15m of the previous Book event. At that point, the respawn timer is unknown. --- Tons of Awakened spawn at the southeast section of the area. Where they spawn is an area where you can camp mobs until the event is over. Can upscale to champs. ",
        waypointName: "Astralarium Waypoint",
        waypointLink: "[&BPoKAAA=]",
        top: `${25}%`,
        left: `${20}%`,
    },
    {
        name: "Pirates",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 12 + 35),
        initialMin: 60 * 1 + 30,
        initialMax: -(60 * 1 + 56),
        respawnCooldown: ref(60 * 12 + 35), 
        respawnMin: 60 * 1 + 30,
        respawnMax: -(60 * 1 + 56),
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
            {
                type: 'Skrimish',
                img: EventSwords,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
            {
                type: 'Skrimish',
                img: EventSwords,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "There are 6 events in this chain, meaing the first two repeat itself, but with different mobs and bosses. It always starts with a skirmish then a boss",
        waypointName: "Astralarium Waypoint",
        waypointLink: "[&BPoKAAA=]",
        top: `${10}%`,
        left: `${50}%`,
    },
    {
        name: "Graveyard",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 15 + 10),
        initialMin: 60 * 1 + 6,
        initialMax: -(60 * 1 + 18),
        respawnCooldown: ref(60 * 15 + 10), 
        respawnMin: 60 * 1 + 6,
        respawnMax: -(60 * 1 + 18),
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
        info: "This is a failed outcome of a different event. It's more realistic to see this event than the previous (fails very quickly). Tons of Awakened mobs.",
        waypointName: "Champion's Dawn Waypoint",
        waypointLink: "[&BBoLAAA=]",
        top: `${80}%`,
        left: `${38}%`,
    },
];

</script>