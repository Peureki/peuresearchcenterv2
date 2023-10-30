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
        map-name="Auric Basin Timers"
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
</template>

<script setup>
import { ref } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue'

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

import Map from '@/imgs/maps/Auric_Basin.jpg'

// INPUT META AND PRE-META TIMES
// name: [name of the event]
// starts: [[hour, min]] 
// If hour is odd UTC, do 3. If even, do 2
let meta = [
    {
        name: "Challenges",
        starts: [2, 45],
        repeats: 2,
        cooldown: ref(0),
        progress: ref(0),
        status: ref(false),
    },
    {
        name: "Mordrem Pre-event",
        starts: [2, 48],
        repeats: 2,
        cooldown: ref(0),
        progress: ref(0),
        status: ref(false),
    },
    {
        name: "Octovine",
        starts: [3, 0],
        repeats: 2,
        cooldown: ref(0),
        progress: ref(0),
        status: ref(false),
    },
    {
        name: "Pylons",
        starts: [3, 30],
        repeats: 2,
        cooldown: ref(0),
        progress: ref(0),
        status: ref(false),
    },
]
// APPLY ONLY if the map has outposts or events that have start collectively when a certain area is completed
let outposts = [
    {
        name: "North Pylon",
        status: ref(true),
    },
    {
        name: "Southeast Pylon",
        status: ref(true),
    },
    {
        name: "South Pylon",
        status: ref(true),
    },
    {
        name: "Southwest Pylon",
        status: ref(true),
    },
    {
        name: "West Pylon",
        status: ref(true),
    },
    {
        name: "West-North Pylon",
        status: ref(true),
    },
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
    /*
     * NORTH PYLON
     */
    {
        name: "Jungle Stalk",
        outpost: "North Pylon",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 11 + 25),
        initialMin: 60 * 0 + 4,
        initialMax: -(60 * 0 + 4),
        respawnCooldown: ref(60 * 10 + 15), 
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
        info: 'Champ stalk. If DPS is meh, may need to CC. Otherwise, takes much longer to die',
        waypointName: "Northwatch Waypoint",
        waypointLink: "[&BN0HAAA=]",
        top: `${8}%`,
        left: `${65}%`, 
    },
    /*
     * SOUTHEAST PYLON
     */
     {
        name: "Wyvern",
        outpost: "Southeast Pylon",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 9 + 35),
        initialMin: 60 * 0 + 37,
        initialMax: -(60 * 0 + 37),
        respawnCooldown: ref(60 * 11 + 10), 
        respawnMin: 60 * 0 + 38,
        respawnMax: -(60 * 0 + 22),
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
        info: 'Champ wyvern. CC when the bar is up, otherwise will become invulnerable and take much longer to die. Do not stand in front. Wyvern go brr',
        waypointName: "Chak Hollow Waypoint",
        waypointLink: "[&BEkIAAA=]",
        top: `${73}%`,
        left: `${102}%`, 
    },
    /*
     * SOUTH PYLON
     */
    {
        name: "Blighted Saplings",
        outpost: "South Pylon",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 6 + 35),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 8 + 35), 
        respawnMin: 60 * 0 + 8,
        respawnMax: -(60 * 0 + 15),
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
        info: "This event repeats 3x AS LONG AS nobody completes the 'Prevent Blight Tendor Monocot' event. Blighted Saplings is the failed event of this. It needs to fail in order to spawn.",
        waypointName: "Southwatch Waypoint",
        waypointLink: "[&BAIIAAA=]",
        top: `${85}%`,
        left: `${65}%`, 
    },
    /*
     * SOUTHWEST
     */
    {
        name: "Stoneheads",
        outpost: "Southwest Pylon",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 10 + 10),
        initialMin: 60 * 0 + 58,
        initialMax: -(60 * 0 + 49),
        respawnCooldown: ref(60 * 10 + 15), 
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
        info: "Two champ stoneheads. When they reach 50%, they go invul and you need to kill rolling devils. Some could be champs if upscaled. This event is only recommended if you have a large DPS squad",
        waypointName: "Southwatch Waypoint",
        waypointLink: "[&BAIIAAA=]",
        top: `${82}%`,
        left: `${22}%`, 
    },
    /*
     * WEST PYLON
     */
    {
        name: "Golden Ooze",
        outpost: "West Pylon",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 13 + 5),
        initialMin: 60 * 0 + 26,
        initialMax: -(60 * 0 + 25),
        respawnCooldown: ref(60 * 13 + 55), 
        respawnMin: 60 * 0 + 51,
        respawnMax: -(60 * 0 + 30),
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
        info: "Champ ooze. DPS and CC fairly quickly to avoid the smaller ooze from constantly healing it. Can bug when attacking too early before it officially spawns.",
        waypointName: "Westwatch Waypoint",
        waypointLink: "[&BAYIAAA=]",
        top: `${38}%`,
        left: `${10}%`, 
    },
    /*
     * WEST-NORTH PYLON
     */
    {
        name: "Gold Guzzler",
        outpost: "West-North Pylon",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 9 + 20),
        initialMin: 60 * 1 + 0,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 9 + 30), 
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
        info: "Throw rocks & CC to remove invul phase. Every CC break spawns arrowheads in the pit.",
        waypointName: "Westwatch Waypoint",
        waypointLink: "[&BAYIAAA=]",
        top: `${20}%`,
        left: `${40}%`, 
    },
    /*
     * INDEPENDENT EVENTS
     */
    {
        name: "Veteran Vinetooth (N)",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 9 + 15),
        initialMin: 60 * 1 + 9,
        initialMax: -(60 * 0 + 40),
        respawnCooldown: ref(60 * 9 + 15), 
        respawnMin: 60 * 1 + 9,
        respawnMax: -(60 * 0 + 40),
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
        info: 'Veteran vinetooth. Depending on the squad size, will need to manage dps',
        waypointName: "Northwatch Waypoint",
        waypointLink: "[&BN0HAAA=]",
        top: `${27}%`,
        left: `${60}%`,
    },
    {
        name: "Veteran Vinetooth (E)",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 9 + 15),
        initialMin: 60 * 1 + 9,
        initialMax: -(60 * 0 + 40),
        respawnCooldown: ref(60 * 9 + 15), 
        respawnMin: 60 * 1 + 9,
        respawnMax: -(60 * 0 + 40),
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
        info: 'Veteran vinetooth. Depending on the squad size, will need to manage dps',
        waypointName: "Eastwatch Waypoint",
        waypointLink: "[&BGwIAAA=]",
        top: `${45}%`,
        left: `${100}%`,
    },
    {
        name: "Veteran Vinetooth (S)",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 9 + 15),
        initialMin: 60 * 1 + 9,
        initialMax: -(60 * 0 + 40),
        respawnCooldown: ref(60 * 9 + 15), 
        respawnMin: 60 * 1 + 9,
        respawnMax: -(60 * 0 + 40),
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
        info: 'Veteran vinetooth. Depending on the squad size, will need to manage dps',
        waypointName: "Southwatch Waypoint",
        waypointLink: "[&BAIIAAA=]",
        top: `${68}%`,
        left: `${63}%`,
    },
    {
        name: "Veteran Vinetooth (W)",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 9 + 15),
        initialMin: 60 * 1 + 9,
        initialMax: -(60 * 0 + 40),
        respawnCooldown: ref(60 * 9 + 15), 
        respawnMin: 60 * 1 + 9,
        respawnMax: -(60 * 0 + 40),
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
        info: 'Veteran vinetooth. Depending on the squad size, will need to manage dps',
        waypointName: "Westwatch Waypoint",
        waypointLink: "[&BAYIAAA=]",
        top: `${53}%`,
        left: `${20}%`,
    },
    {
        name: "Priory Explorer (NE)",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 40),
        initialMin: 60 * 0 + 29,
        initialMax: -(60 * 0 + 27),
        respawnCooldown: ref(60 * 6 + 40), 
        respawnMin: 60 * 0 + 29,
        respawnMax: -(60 * 0 + 27),
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
        info: 'Small escort with a rally defense at the end',
        waypointName: "Eastwatch Waypoint",
        waypointLink: "[&BGwIAAA=]",
        top: `${40}%`,
        left: `${95}%`,
    },
    {
        name: "Priory Explorer (SE)",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 40),
        initialMin: 60 * 0 + 29,
        initialMax: -(60 * 0 + 27),
        respawnCooldown: ref(60 * 6 + 40), 
        respawnMin: 60 * 0 + 29,
        respawnMax: -(60 * 0 + 27),
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
        info: 'Small escort with a rally defense at the end. This specific escort can spawn either south or north where the TM spawns',
        waypointName: "Eastwatch Waypoint",
        waypointLink: "[&BGwIAAA=]",
        top: `${65}%`,
        left: `${90}%`,
    },
    {
        name: "Priory Explorer (W)",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 40),
        initialMin: 60 * 0 + 29,
        initialMax: -(60 * 0 + 27),
        respawnCooldown: ref(60 * 6 + 40), 
        respawnMin: 60 * 0 + 29,
        respawnMax: -(60 * 0 + 27),
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
        info: 'Small escort with a rally defense at the end',
        waypointName: "Westwatch Waypoint",
        waypointLink: "[&BAYIAAA=]",
        top: `${62}%`,
        left: `${25}%`,
    },
    {
        name: "Treasure Mushroom",
        outpost: "",
        
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 9 + 50),
        initialMin: 60 * 0 + 6,
        initialMax: -(60 * 0 + 5),
        respawnCooldown: ref(60 * 9 + 50), 
        respawnMin: 60 * 0 + 6,
        respawnMax: -(60 * 0 + 5),
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
        info: 'Daily TM rewards guranteed rare, spirit shard once per day. But, can still be counted for map bonus rewards after.',
        waypointName: "Eastwatch Waypoint",
        waypointLink: "[&BGwIAAA=]",
        top: `${60}%`,
        left: `${100}%`,
    },
];

</script>