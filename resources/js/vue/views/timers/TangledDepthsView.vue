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
        :map="Map"
        alt="Tangled Depths"
        :events="events"
    >
        <template v-slot:nodeTrackerModal>
            <NodeTrackerModal
                :nodes="nodes"
            />
        </template>

        <template v-slot:info>
            <article class="info-content">
                <p>Tangled Depths is a unique map where there are meta-outpost events that need to be completed before the events listed on this page can begin. Each outpost will have a linear chain of events. </p>

                <p>On the navigation, there are <span><img src="@/imgs/icons/Outpost_Active.png">outpost events</span>(Nuhoch, Ogre, etc). When you complete the final chain of meta-outpost events (the in-game outpost symbol will turn orange), click on the appropiate outpost to start all of that area's timers.</p>

                <p>Since this map is unique, these events have two different kinds of timers. The initial spawn when you complete their meta-outpost events and their respawn timers. After completing an event for the first time, a new cooldown will initiate.</p>
                <p>Priority outposts to complete: Nuhoch &#x2192; Ogre &#x2192; Rata &#x2192; SCAR</p>
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
import JunglePlant from '@/imgs/icons/Maguuma_Lily.png'
import Mussel from '@/imgs/icons/Mussel.png'
import SawgillMushroom from '@/imgs/icons/Sawgill_Mushroom.png'

import EventSwords from '@/imgs/icons/Event_Swords.png'
import EventBoss from '@/imgs/icons/Event_Boss.png'
import EventShield from '@/imgs/icons/Event_Shield.png'
import EventRally from '@/imgs/icons/Event_Rally.png'

import Map from '@/imgs/maps/Tangled_Depths.jpg'

// TD meta time example
// Meta UTC times
// 0:30, 2:30, 4:30, 6:30, 8:30, 10:30, 12:30, 14:30, 16:30, 18:30, 20:30, 22:30
// Outposts
// 0:46, 2:46, 4:46
// 2:25
let meta = [
    {
        name: "Prep",
        starts: [2, 25],
        repeats: 2,
        cooldown: ref(0),
        progress: ref(0),
        status: ref(false),
    },
    {
        name: "Chak Gerant",
        starts: [2, 30],
        repeats: 2,
        cooldown: ref(0),
        progress: ref(0),
        status: ref(false),
    },
    {
        name: "Help the Outposts",
        starts: [2, 46],
        repeats: 2,
        cooldown: ref(0),
        progress: ref(0),
        status: ref(false),
    },
    
]

let outposts = [
    {
        name: "Nuhoch",
        status: ref(true),
    },
    {
        name: "Ogre",
        status: ref(true),
    },
    {
        name: "Rata",
        status: ref(true),
    },
    {
        name: "SCAR",
        status: ref(true),
    },
]

let checkboxes = [
    {
        name: "Nuhoch",
        toggle: ref(true),
    },
    {
        name: "Ogre",
        toggle: ref(true),
    },
    {
        name: "Rata",
        toggle: ref(true),
    },
    {
        name: "SCAR",
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
    /*
     * NUHOCH EVENTS
     */
    {
        name: "Chak Lobber (Nuh)",
        outpost: "Nuhoch",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 7 + 13),
        initialMin: 60 * 1 + 50,
        initialMax: -(60 * 2 + 14),
        respawnCooldown: ref(60 * 35 + 50), 
        respawnMin: 60 * 2 + 10,
        respawnMax: -(60 * 2 + 10),
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
        info: '1st event: Kill chak. Does not scale well with a large squad when initially spawned. 2nd event: Champ in the cave, south',
        waypointName: "Teku Nuhoch Waypoint",
        waypointLink: "[&BAwIAAA=]",
        top: `${33}%`,
        left: `${55}%`,
        
    },
    {
        name: "Sporling",
        outpost: "Nuhoch",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 7 + 40),
        initialMin: 60 * 1 + 46,
        initialMax: -(60 * 2 + 11),
        respawnCooldown: ref(60 * 30 + 14),
        respawnMin: 60 * 2 + 22,
        respawnMax: -(60 * 2 + 22),
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
        info: '1st event: Kill chak. Does not scale well with a large squad when initially spawned. 2nd event: Champ in the cave, south',
        waypointName: "Teku Nuhoch Waypoint",
        waypointLink: "[&BAwIAAA=]",
        top: `${5}%`,
        left: `${70}%`,
    },
    {
        name: "Elementals",
        outpost: "Nuhoch",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 2 + 50),
        initialMin: 60 * 0 + 59,
        initialMax: -(60 * 0 + 59),
        respawnCooldown: ref(60 * 12 + 20),
        respawnMin: 60 * 1 + 23,
        respawnMax: -(60 * 1 + 32),
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
        info: "Mobs have 'last laugh' when killed. Can upscale to champ Elementals and Sparks",
        waypointName: "Teku Nuhoch Waypoint",
        waypointLink: "[&BAwIAAA=]",
        top: `${15}%`,
        left: `${100}%`,
    },
    {
        name: "Grub Pit",
        outpost: "Nuhoch",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 0 + 0),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 10 + 15),
        respawnMin: 60 * 2 + 31,
        respawnMax: -(60 * 2 + 50),
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
        info: "Witout people, it spawns only a few chak. With a squad, it could spawn over 30+ chak",
        waypointName: "Teku Nuhoch Waypoint",
        waypointLink: "[&BAwIAAA=]",
        top: `${8}%`,
        left: `${43}%`,
    },
    {
        name: "Beetle",
        outpost: "Nuhoch",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 10 + 25),
        initialMin: 60 * 1 + 10,
        initialMax: -(60 * 1 + 14),
        respawnCooldown: ref(60 * 12 + 10),
        respawnMin: 60 * 1 + 29,
        respawnMax: -(60 * 1 + 29),
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
        info: "This event has multiple location spawns. All on the surface level of Nuhoch. Sometimes can spawn in the middle, south of the main tree, east or north, but the target location is always west. Very slow event without constant superspeed.",
        waypointName: "Teku Nuhoch Waypoint",
        waypointLink: "[&BAwIAAA=]",
        top: `${25}%`,
        left: `${70}%`,
    },
    {
        name: "Alchemist Patli",
        outpost: "Nuhoch",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 12 + 50),
        initialMin: 60 * 1 + 11,
        initialMax: -(60 * 1 + 35),
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
                type: 'Escort',
                img: EventShield,
            },
            {
                type: 'Skirmish',
                img: EventSwords,
            },
        ],
        info: "First event: starts at the surface level, north. Escort moves quick and has a few waves of enemies along the way. Upscales to champs in the very beginning. Second event: Not worth doing",
        waypointName: "Teku Nuhoch Waypoint",
        waypointLink: "[&BAwIAAA=]",
        top: `${20}%`,
        left: `${50}%`,
    },
    {
        name: "Zintl",
        outpost: "Nuhoch",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 23 + 5),
        initialMin: 60 * 3 + 53,
        initialMax: -(60 * 5 + 44),
        respawnCooldown: ref(60 * 28 + 50),
        respawnMin: 60 * 0 + 17,
        respawnMax: -(60 * 0 + 17),
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
        info: "Surface level. Waves of Zintl. Can spawn multiple champs. The event does complete itself after a while if no one is present",
        waypointName: "Teku Nuhoch Waypoint",
        waypointLink: "[&BAwIAAA=]",
        top: `${11}%`,
        left: `${55}%`,
    },
    {
        name: "Skelk",
        outpost: "Nuhoch",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 22 + 5),
        initialMin: 60 * 5 + 55,
        initialMax: -(60 * 4 + 35),
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
                type: 'Escort',
                img: EventShield,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: "Spawns underneth the Nuhoch waypoint. Escort travels down the tunnel to the water. Then champ skelk. The skelk needs to be CCed to prevent it from teleporting faster, but still might do so",
        waypointName: "Teku Nuhoch Waypoint",
        waypointLink: "[&BAwIAAA=]",
        top: `${18}%`,
        left: `${78}%`,
    },
    /*
     * OGRE EVENTS
     */
    {
        name: "Wyvern Nest",
        outpost: "Ogre",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 3 + 0),
        initialMin: 60 * 1 + 5,
        initialMax: -(60 * 1 + 27),
        respawnCooldown: ref(60 * 17 + 30), 
        respawnMin: 60 * 2 + 19,
        respawnMax: -(60 * 2 + 31),
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
        info: '5 Wyvern nests to destroy. Surrounded by Fire Wyverns. Possible champs, but delayed',
        waypointName: "Ogre Camp Waypoint",
        waypointLink: "[&BMwHAAA=]",
        top: `${70}%`,
        left: `${65}%`,
    },
    {
        name: "Matriarch Bat",
        outpost: "Ogre",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 7 + 15),
        initialMin: 60 * 2 + 1,
        initialMax: -(60 * 1 + 54),
        respawnCooldown: ref(60 * 18 + 40), 
        respawnMin: 60 * 0 + 18,
        respawnMax: -(60 * 0 + 33),
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
        info: 'Very short escort that starts from the waypoint. Second event is a champ that produces condis that can last for over a minute. BRING CONDI CLEANSES',
        waypointName: "Ogre Camp Waypoint",
        waypointLink: "[&BMwHAAA=]",
        top: `${52}%`,
        left: `${43}%`,
    },
    {
        name: "Chak Morale",
        outpost: "Ogre",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 12 + 55),
        initialMin: 60 * 2 + 25,
        initialMax: -(60 * 2 + 16),
        respawnCooldown: ref(60 * 17 + 35), 
        respawnMin: 60 * 2 + 17,
        respawnMax: -(60 * 1 + 28),
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
        info: 'Kill chak. If with a squad, spread out. Otherwise the event takes forever',
        waypointName: "Ogre Camp Waypoint",
        waypointLink: "[&BMwHAAA=]",
        top: `${70}%`,
        left: `${36}%`,
    },
    {
        name: "Grubs",
        outpost: "Ogre",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 17 + 20),
        initialMin: 60 * 2 + 22,
        initialMax: -(60 * 2 + 25),
        respawnCooldown: ref(60 * 18 + 45), 
        respawnMin: 60 * 0 + 7,
        respawnMax: -(60 * 0 + 6),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(false),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Escort',
                img: EventShield,
            },
        ],
        info: 'NOT RECOMMENDED with a squad. Can easily bug out if someone interacts with the escort bat. Otherwise, can finish very quickly. Champs are fake.',
        waypointName: "Ogre Camp Waypoint",
        waypointLink: "[&BMwHAAA=]",
        top: `${63}%`,
        left: `${50}%`,
    },
    /* 
     * RATA
     */
    {
        name: "Haywire Golems",
        outpost: "Rata",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 4 + 20),
        initialMin: 60 * 0 + 20,
        initialMax: -(60 * 0 + 20),
        respawnCooldown: ref(60 * 22 + 15), 
        respawnMin: 60 * 2 + 1,
        respawnMax: -(60 * 2 + 30),
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
        info: 'Recommended with squad < 30. With a very large squad, could take a while if no elite/champs spawn.',
        waypointName: "Rata Novas Waypoint",
        waypointLink: "[&BAMIAAA=]",
        top: `${45}%`,
        left: `${95}%`,
    },
    {
        name: "Chak Lobber (Rata)",
        outpost: "Rata",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 8 + 5),
        initialMin: 60 * 0 + 40,
        initialMax: -(60 * 0 + 40),
        respawnCooldown: ref(60 * 18 + 20), 
        respawnMin: 60 * 2 + 6,
        respawnMax: -(60 * 1 + 40),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(false),
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
        info: 'NOT RECOMMENDED. Very long escort. If the boss is up, then that is worth doing.',
        waypointName: "Rata Novas Waypoint",
        waypointLink: "[&BAMIAAA=]",
        top: `${35}%`,
        left: `${80}%`,
    },
    {
        name: "Mushrooms",
        outpost: "Rata",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 3 + 10),
        initialMin: 60 * 0 + 3,
        initialMax: -(60 * 0 + 2),
        respawnCooldown: ref(60 * 30 + 5), 
        respawnMin: 60 * 1 + 31,
        respawnMax: -(60 * 0 + 36),
        active: ref(false),
        respawnActive: ref(false),
        toggleCheckbox: ref(false),
        togglePlay: ref(true),
        toggleInfo: ref(false),
        toggleTooltip: ref(false),
        chain: [
            {
                type: 'Skrimish',
                img: EventSwords,
            },
        ],
        info: 'NOT RECOMMENDED w/ a squad. Far location and may get too chaotic with the scaling/one shot downs',
        waypointName: "Rata Novas Waypoint",
        waypointLink: "[&BAMIAAA=]",
        top: `${55}%`,
        left: `${85}%`,
    },
    /*
     * SCAR
     */
    {
        name: "Chak Crown",
        outpost: "SCAR",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 8 + 25),
        initialMin: 60 * 2 + 55,
        initialMax: -(60 * 1 + 9),
        respawnCooldown: ref(60 * 36 + 35), 
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
                type: 'Rally',
                img: EventRally,
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
        info: '1) Spawns at the waypoint. Lots of chak + champ. 2) Escort from SCAR to Confluence waypoint (can upscale once to champs). 3) Chak Crown (kill vets and then boss)',
        waypointName: "SCAR Camp Waypoint",
        waypointLink: "[&BAAIAAA=]",
        top: `${70}%`,
        left: `${100}%`,
    },
    {
        name: "Fire Wyvern",
        outpost: "SCAR",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 7 + 10),
        initialMin: 60 * 0 + 54,
        initialMax: -(60 * 1 + 55),
        respawnCooldown: ref(60 * 22 + 25), 
        respawnMin: 60 * 2 + 3,
        respawnMax: -(60 * 1 + 39),
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
        info: 'Veteran Fire Wyvern. If large squad, small pokes.',
        waypointName: "SCAR Camp Waypoint",
        waypointLink: "[&BAAIAAA=]",
        top: `${85}%`,
        left: `${120}%`,
    },
    {
        name: "Wasps",
        outpost: "SCAR",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 16 + 35),
        initialMin: 60 * 2 + 47,
        initialMax: -(60 * 2 + 42),
        respawnCooldown: ref(60 * 18 + 10), 
        respawnMin: 60 * 2 + 24,
        respawnMax: -(60 * 1 + 39),
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
        info: 'Lots of wasps. Can upscale to multiple champs',
        waypointName: "SCAR Camp Waypoint",
        waypointLink: "[&BAAIAAA=]",
        top: `${68}%`,
        left: `${122}%`,
    },
    {
        name: "Chak Lobber (SCAR)",
        outpost: "SCAR",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 30 + 25),
        initialMin: 60 * 1 + 25,
        initialMax: -(60 * 1 + 25),
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
                type: 'Escort',
                img: EventShield,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: '1) Escort from the SCAR wp to the end of the lane. 2) Either DPS the boss quickly or CC, otherwise the event will delay. It has a history of stalling at the escort.',
        waypointName: "SCAR Camp Waypoint",
        waypointLink: "[&BAAIAAA=]",
        top: `${57}%`,
        left: `${107}%`,
    },
    /*
     * INDEPENDENT EVENTS
     */
    {
        name: "Mushroom King",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 18 + 45),
        initialMin: 60 * 0 + 40,
        initialMax: -(60 * 0 + 29),
        respawnCooldown: ref(60 * 18 + 45), 
        respawnMin: 60 * 0 + 40,
        respawnMax: -(60 * 0 + 29),
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
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: '1) Spawns lots of mushrooms. Finishes very quickly and NPCs usually do it themselves after a minute. 2) Champ mushroom. 3) Escort to Ogre wp. Slight for the escort to spawn champs',
        waypointName: "Order of Whispers Camp Waypoint",
        waypointLink: "[&BA4IAAA=]",
        top: `${35}%`,
        left: `${25}%`,
    },
    {
        name: "Treasure Mushroom",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 9 + 30),
        initialMin: 60 * 1 + 14,
        initialMax: -(60 * 0 + 55),
        respawnCooldown: ref(60 * 9 + 30), 
        respawnMin: 60 * 1 + 14,
        respawnMax: -(60 * 0 + 55),
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
        info: 'Daily boss. Can only be rewarded with a guaranteed rare, spirit shard, bouncy chest once per day. But, can still continously count for map bonus rewards.',
        waypointName: "Teku Nuhoch Waypoint",
        waypointLink: "[&BAwIAAA=]",
        top: `${2}%`,
        left: `${45}%`,
    },
    {
        name: "Chak Driver",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 38 + 10),
        initialMin: 60 * 5 + 43,
        initialMax: -(60 * 5 + 52),
        respawnCooldown: ref(60 * 38 + 10), 
        respawnMin: 60 * 5 + 43,
        respawnMax: -(60 * 5 + 52),
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
        info: "Manually activate this event if there's an invisible char waiting when you enter the Chak Stronghold. 1) Kill chak (difficult to get gold credit). 2) Boss @ 50% will move northward. **Event 2) counts for two events in one**",
        waypointName: "Teku Nuhoch Waypoint",
        waypointLink: "[&BAwIAAA=]",
        top: `${15}%`,
        left: `${25}%`,
    },
    {
        name: "Rock Hands",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 30 + 0),
        initialMin: 60 * 0 + 0,
        initialMax: -(60 * 0 + 0),
        respawnCooldown: ref(60 * 30 + 0), 
        respawnMin: 60 * 0 + 0,
        respawnMax: -(60 * 0 + 0),
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
        info: "There's a mastery at the map location at Northern Confluence Tunnel. Fly up and, if there are 3 Earth Elementals defending a hidden room, then the event is up.",
        waypointName: "Teku Nuhoch Waypoint",
        waypointLink: "[&BAwIAAA=]",
        top: `${50}%`,
        left: `${70}%`,
    },
];

</script>