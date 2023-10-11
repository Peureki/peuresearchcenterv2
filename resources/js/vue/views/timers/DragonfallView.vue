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
        <template v-slot:info>
            <h4>How This Works</h4>
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

import Nav from '@/js/vue/components/Nav.vue'

import NavTimers from '@/js/vue/components/timers/NavTimers.vue'
import MainTimers from '@/js/vue/components/timers/MainTimers.vue'

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
        name: "Crystal Bloom (T2)",
        status: ref(true),
    },
    {
        name: "Olmakhan (Captured)",
        status: ref(true),
    },
    {
        name: "Olmakhan (T1)",
        status: ref(true),
    },
    {
        name: "Mist Warden (Captured)",
        status: ref(true),
    },
    {
        name: "Mist Warden (T2)",
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
        toggle: ref(true),
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
        outpost: "Crystal Bloom (T2)",
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
        outpost: "Olmakhan (T1)",
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
        outpost: "Mist Warden (T2)",
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