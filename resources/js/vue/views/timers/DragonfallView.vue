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
        map-name="Dragonfall Timers"
        :map="Map"
        alt="Dragonfall"
        :events="events"
    >
        <template v-slot:nodeTrackerModal>
            <NodeTrackerModal
                :nodes="nodes"
            />
        </template>

        <template v-slot:info>
            <article class="info-content">
                <p>The overall goal is to get to the meta as fast as possible. Complete each sector/outpost by doing events in their area. When you complete them, click on the <span><img src="@/imgs/icons/Outpost_Active.png"> ouposts</span> to start their timers.</p>

                <p>For Menders: Menders spawn at T3 at Mist Warden and Crystal Bloom sector, but T2 at Olmakhan.</p>

                <p>For Bridges: The first cooldown is after completing the salvage event. Restart the timer after completing the first defense.</p>

                <p>Repeatable priority of events:</p>
                <ul class="list-general">
                    <li>1. Menders</li>
                    <li>2. Culls</li>
                    <li>3. Brandstorms</li>
                    <li>4. Champs</li>
                    <li>5. Sector/Outpost Objectives</li>
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
import Mistborn from '@/imgs/icons/Mistborn_Mote.png'
import JunglePlant from '@/imgs/icons/Maguuma_Lily.png'
import Mussel from '@/imgs/icons/Mussel.png'
import BlackCrocus from '@/imgs/icons/Saffron_Thread.png'
import VerdantHerbs from '@/imgs/icons/Coriander_Seed.png'
import CayennePepper from '@/imgs/icons/Cayenne_Pepper.png'
import GhostPepper from '@/imgs/icons/Ghost_Pepper.png'
import Lentils from '@/imgs/icons/Handful_of_Red_Lentils.png'

import EventSwords from '@/imgs/icons/Event_Swords.png'
import EventBoss from '@/imgs/icons/Event_Boss.png'
import EventShield from '@/imgs/icons/Event_Shield.png'
import EventRally from '@/imgs/icons/Event_Rally.png'

import Map from '@/imgs/maps/Dragonfall.jpg'

// INPUT META AND PRE-META TIMES
// name: [name of the event]
// starts: [[hour, min]] 
// If hour is odd UTC, do 3. If even, do 2
let meta = [

]
// APPLY ONLY if the map has outposts or events that have start collectively when a certain area is completed
let outposts = [
    {
        name: "Crystal Bloom (Captured)",
        status: ref(true),
    },
    {
        name: "Crystal Bloom (Finished T2)",
        status: ref(true),
    },
    {
        name: "Olmakhan (Captured)",
        status: ref(true),
    },
    {
        name: "Olmakhan (Finished T1)",
        status: ref(true),
    },
    {
        name: "Mist Warden (Captured)",
        status: ref(true),
    },
    {
        name: "Mist Warden (Finished T2)",
        status: ref(true),
    },
]

let checkboxes = [
    {
        name: "Crystal Bloom",
        toggle: ref(true),
    },
    {
        name: "Olmakhan",
        toggle: ref(true),
    },
    {
        name: "Mist Warden",
        toggle: ref(true),
    },
    {
        name: "Cull",
        toggle: ref(false),
    },
    {
        name: "Brandstorm",
        toggle: ref(true),
    },
    {
        name: "Champ",
        toggle: ref(true),
    },
    {
        name: "Mender",
        toggle: ref(true),
    },
    {
        name: "Bridge",
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
        name: "Elder Wood Nodes",
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
        name: "Mistborn Mote",
        quantity: ref(0),
        src: Mistborn,
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
        name: "Black Crocus",
        quantity: ref(0),
        src: BlackCrocus,
    },
    {
        name: "Verdant Herbs",
        quantity: ref(0),
        src: VerdantHerbs,
    },
    {
        name: "Cayenne Pepper",
        quantity: ref(0),
        src: CayennePepper,
    },
    {
        name: "Lentils",
        quantity: ref(0),
        src: Lentils,
    },
]

let events = [
    /*
     * CRYSTAL BLOOM (CAPTURED)
     */
    {
        name: "Cull (Crystal Bloom, W)",
        outpost: "Crystal Bloom (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 1 + 40),
        initialMin: 60 * 0 + 25,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 4 + 0), 
        respawnMin: 60 * 0 + 56,
        respawnMax: -(60 * 1 + 2),
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
        info: 'Small bunch of regular mobs + veteran',
        waypointName: "Burning Forest Waypoint",
        waypointLink: "[&BOYLAAA=]",
        top: `${8}%`,
        left: `${15}%`, 
    },
    {
        name: "Cull (Crystal Bloom, S)",
        outpost: "Crystal Bloom (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 1 + 40),
        initialMin: 60 * 0 + 25,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 4 + 0), 
        respawnMin: 60 * 0 + 56,
        respawnMax: -(60 * 1 + 2),
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
        info: 'Small bunch of regular mobs + veteran',
        waypointName: "Burning Forest Waypoint",
        waypointLink: "[&BOYLAAA=]",
        top: `${27}%`,
        left: `${30}%`, 
    },
    {
        name: "Cull (Crystal Bloom, E)",
        outpost: "Crystal Bloom (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 1 + 40),
        initialMin: 60 * 0 + 25,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 4 + 0), 
        respawnMin: 60 * 0 + 56,
        respawnMax: -(60 * 1 + 2),
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
        info: 'Small bunch of regular mobs + veteran',
        waypointName: "Burning Forest Waypoint",
        waypointLink: "[&BOYLAAA=]",
        top: `${9}%`,
        left: `${60}%`, 
    },
    {
        name: "Champ Abyssal",
        outpost: "Crystal Bloom (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 3 + 45),
        initialMin: 60 * 0 + 48,
        initialMax: -(60 * 1 + 14),
        respawnCooldown: ref(60 * 9 + 25), 
        respawnMin: 60 * 0 + 19,
        respawnMax: -(60 * 0 + 19),
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
        info: 'Champ',
        waypointName: "Burning Forest Waypoint",
        waypointLink: "[&BOYLAAA=]",
        top: `${18}%`,
        left: `${22}%`, 
    },
    {
        name: "Brandstorm (Crystal Bloom)",
        outpost: "Crystal Bloom (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 1 + 40),
        initialMin: 60 * 0 + 25,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 4 + 0), 
        respawnMin: 60 * 0 + 56,
        respawnMax: -(60 * 1 + 2),
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
        info: 'Bunch of mobs and a tanky brandstorm',
        waypointName: "Burning Forest Waypoint",
        waypointLink: "[&BOYLAAA=]",
        top: `${17}%`,
        left: `${40}%`, 
    },
    {
        name: "Mender (Crystal Bloom)",
        outpost: "Crystal Bloom (Finished T2)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 2 + 25),
        initialMin: 60 * 0 + 37,
        initialMax: -(60 * 0 + 37),
        respawnCooldown: ref(60 * 8 + 55), 
        respawnMin: 60 * 0 + 36,
        respawnMax: -(60 * 0 + 43),
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
        info: 'It is both an escort and champ. At the end, it will spawn 3 Mistborn chests. For Olmakhan, it can spawn at T2+. For the others, it spawns at T3.',
        waypointName: "Burning Forest Waypoint",
        waypointLink: "[&BOYLAAA=]",
        top: `${25}%`,
        left: `${5}%`, 
    },
    /*
     * OLMAKHAN (CAPTURED)
     */
     {
        name: "Cull (Olmakhan, W)",
        outpost: "Olmakhan (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 1 + 40),
        initialMin: 60 * 0 + 25,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 4 + 0), 
        respawnMin: 60 * 0 + 56,
        respawnMax: -(60 * 1 + 2),
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
        info: 'Small bunch of regular mobs + veteran',
        waypointName: "The Underworld Waypoint",
        waypointLink: "[&BNELAAA=]",
        top: `${55}%`,
        left: `${5}%`, 
    },
    {
        name: "Cull (Olmakhan, S)",
        outpost: "Olmakhan (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 1 + 40),
        initialMin: 60 * 0 + 25,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 4 + 0), 
        respawnMin: 60 * 0 + 56,
        respawnMax: -(60 * 1 + 2),
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
        info: 'Small bunch of regular mobs + veteran',
        waypointName: "The Underworld Waypoint",
        waypointLink: "[&BNELAAA=]",
        top: `${82}%`,
        left: `${35}%`, 
    },
    {
        name: "Cull (Olmakhan, E)",
        outpost: "Olmakhan (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 1 + 40),
        initialMin: 60 * 0 + 25,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 4 + 0), 
        respawnMin: 60 * 0 + 56,
        respawnMax: -(60 * 1 + 2),
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
        info: 'Small bunch of regular mobs + veteran',
        waypointName: "The Underworld Waypoint",
        waypointLink: "[&BNELAAA=]",
        top: `${67}%`,
        left: `${47}%`, 
    },
    {
        name: "Champ Arbiter",
        outpost: "Olmakhan (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 3 + 45),
        initialMin: 60 * 0 + 48,
        initialMax: -(60 * 1 + 14),
        respawnCooldown: ref(60 * 9 + 25), 
        respawnMin: 60 * 0 + 19,
        respawnMax: -(60 * 0 + 19),
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
        info: 'Champ',
        waypointName: "The Underworld Waypoint",
        waypointLink: "[&BNELAAA=]",
        top: `${70}%`,
        left: `${5}%`, 
    },
    {
        name: "Brandstorm (Olmakhan)",
        outpost: "Olmakhan (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 1 + 40),
        initialMin: 60 * 0 + 25,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 4 + 0), 
        respawnMin: 60 * 0 + 56,
        respawnMax: -(60 * 1 + 2),
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
        info: 'Bunch of mobs and a tanky brandstorm',
        waypointName: "The Underworld Waypoint",
        waypointLink: "[&BNELAAA=]",
        top: `${73}%`,
        left: `${25}%`, 
    },
    {
        name: "Mender (Olmakhan)",
        outpost: "Olmakhan (Finished T1)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 2 + 25),
        initialMin: 60 * 0 + 37,
        initialMax: -(60 * 0 + 37),
        respawnCooldown: ref(60 * 8 + 55), 
        respawnMin: 60 * 0 + 36,
        respawnMax: -(60 * 0 + 43),
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
        info: 'It is both an escort and champ. At the end, it will spawn 3 Mistborn chests. For Olmakhan, it can spawn at T2+. For the others, it spawns at T3.',
        waypointName: "The Underworld Waypoint",
        waypointLink: "[&BNELAAA=]",
        top: `${65}%`,
        left: `${28}%`, 
    },
    /*
     * MIST WARDEN (CAPTURED)
     */
     {
        name: "Cull (Mist Warden, E)",
        outpost: "Mist Warden (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 1 + 40),
        initialMin: 60 * 0 + 25,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 4 + 0), 
        respawnMin: 60 * 0 + 56,
        respawnMax: -(60 * 1 + 2),
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
        info: 'Small bunch of regular mobs + veteran',
        waypointName: "Melandru's Lost Domain Waypoint",
        waypointLink: "[&BNILAAA=]",
        top: `${40}%`,
        left: `${115}%`, 
    },
    {
        name: "Cull (Mist Warden, S)",
        outpost: "Mist Warden (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 1 + 40),
        initialMin: 60 * 0 + 25,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 4 + 0), 
        respawnMin: 60 * 0 + 56,
        respawnMax: -(60 * 1 + 2),
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
        info: 'Small bunch of regular mobs + veteran',
        waypointName: "Melandru's Lost Domain Waypoint",
        waypointLink: "[&BNILAAA=]",
        top: `${75}%`,
        left: `${107}%`, 
    },
    {
        name: "Cull (Mist Warden, W)",
        outpost: "Mist Warden (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 1 + 40),
        initialMin: 60 * 0 + 25,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 4 + 0), 
        respawnMin: 60 * 0 + 56,
        respawnMax: -(60 * 1 + 2),
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
        info: 'Small bunch of regular mobs + veteran',
        waypointName: "Melandru's Lost Domain Waypoint",
        waypointLink: "[&BNILAAA=]",
        top: `${55}%`,
        left: `${85}%`, 
    },
    {
        name: "Champ Elemental",
        outpost: "Mist Warden (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 3 + 45),
        initialMin: 60 * 0 + 48,
        initialMax: -(60 * 1 + 14),
        respawnCooldown: ref(60 * 9 + 25), 
        respawnMin: 60 * 0 + 19,
        respawnMax: -(60 * 0 + 19),
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
        info: 'Champ',
        waypointName: "Melandru's Lost Domain Waypoint",
        waypointLink: "[&BNILAAA=]",
        top: `${33}%`,
        left: `${115}%`, 
    },
    {
        name: "Brandstorm (Mist Warden)",
        outpost: "Mist Warden (Captured)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 1 + 40),
        initialMin: 60 * 0 + 25,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 4 + 0), 
        respawnMin: 60 * 0 + 56,
        respawnMax: -(60 * 1 + 2),
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
        info: 'Bunch of mobs and a tanky brandstorm',
        waypointName: "Melandru's Lost Domain Waypoint",
        waypointLink: "[&BNILAAA=]",
        top: `${80}%`,
        left: `${80}%`, 
    },
    {
        name: "Mender (Mist Warden)",
        outpost: "Mist Warden (Finished T2)",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 2 + 25),
        initialMin: 60 * 0 + 37,
        initialMax: -(60 * 0 + 37),
        respawnCooldown: ref(60 * 8 + 55), 
        respawnMin: 60 * 0 + 36,
        respawnMax: -(60 * 0 + 43),
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
        info: 'It is both an escort and champ. At the end, it will spawn 3 Mistborn chests. For Olmakhan, it can spawn at T2+. For the others, it spawns at T3.',
        waypointName: "Melandru's Lost Domain Waypoint",
        waypointLink: "[&BNILAAA=]",
        top: `${85}%`,
        left: `${105}%`, 
    },
    /*
     * INDEPENDENT EVENTS
     */
    {
        name: "Bridge (N)",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 18 + 40),
        initialMin: 60 * 2 + 28,
        initialMax: -(60 * 1 + 33),
        respawnCooldown: ref(60 * 13 + 45), 
        respawnMin: 60 * 1 + 2,
        respawnMax: -(60 * 0 + 44),
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
        info: 'When the meta resets, the map starts with all 4 bridges with the salvage event. After you complete it, start the timer for its initial spawn time. Then, for repeats, it will go into its respawn cooldown.',
        waypointName: "Pact Command Waypoint",
        waypointLink: "[&BN4LAAA=]",
        top: `${15}%`,
        left: `${67}%`,
    },
    {
        name: "Bridge (E)",
        outpost: "",
        singleCooldown: ref(false),
        initialCooldown: ref(60 * 18 + 40),
        initialMin: 60 * 2 + 28,
        initialMax: -(60 * 1 + 33),
        respawnCooldown: ref(60 * 13 + 45), 
        respawnMin: 60 * 1 + 2,
        respawnMax: -(60 * 0 + 44),
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
        info: 'When the meta resets, the map starts with all 4 bridges with the salvage event. After you complete it, start the timer for its initial spawn time. Then, for repeats, it will go into its respawn cooldown.',
        waypointName: "Melandru's Lost Domain Waypoint",
        waypointLink: "[&BNILAAA=]",
        top: `${47}%`,
        left: `${100}%`,
    },
    {
        name: "Bridge (S)",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 18 + 40),
        initialMin: 60 * 2 + 28,
        initialMax: -(60 * 1 + 33),
        respawnCooldown: ref(60 * 13 + 45), 
        respawnMin: 60 * 1 + 2,
        respawnMax: -(60 * 0 + 44),
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
        info: 'When the meta resets, the map starts with all 4 bridges with the salvage event. After you complete it, start the timer for its initial spawn time. Then, for repeats, it will go into its respawn cooldown.',
        waypointName: "Melandru's Lost Domain Waypoint",
        waypointLink: "[&BNILAAA=]",
        top: `${80}%`,
        left: `${60}%`,
    },
    {
        name: "Bridge (W)",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 18 + 40),
        initialMin: 60 * 2 + 28,
        initialMax: -(60 * 1 + 33),
        respawnCooldown: ref(60 * 13 + 45), 
        respawnMin: 60 * 1 + 2,
        respawnMax: -(60 * 0 + 44),
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
        info: 'When the meta resets, the map starts with all 4 bridges with the salvage event. After you complete it, start the timer for its initial spawn time. Then, for repeats, it will go into its respawn cooldown.',
        waypointName: "Burning Forest Waypoint",
        waypointLink: "[&BOYLAAA=]",
        top: `${40}%`,
        left: `${15}%`,
    },
];

</script>