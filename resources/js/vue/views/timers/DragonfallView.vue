<template>
    <Nav>
        <template v-slot:timer>
            <NavTimers
                :outposts="outposts"
                :events="events"
                :meta="meta"
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

import Nav from '../../components/Nav.vue'

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
        chain: [
            {
                type: 'Skrimish',
                img: EventSwords,
            },
        ],
        info: 'Small bunch of regular mobs + veteran',
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
        chain: [
            {
                type: 'Skrimish',
                img: EventSwords,
            },
        ],
        info: 'Small bunch of regular mobs + veteran',
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
        chain: [
            {
                type: 'Skrimish',
                img: EventSwords,
            },
        ],
        info: 'Small bunch of regular mobs + veteran',
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
        chain: [
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'Champ',
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
        chain: [
            {
                type: 'Skrimish',
                img: EventSwords,
            },
        ],
        info: 'Bunch of mobs and a tanky brandstorm',
        top: `${17}%`,
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
        chain: [
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'Veteran vinetooth. Depending on the squad size, will need to manage dps',
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
        chain: [
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'Veteran vinetooth. Depending on the squad size, will need to manage dps',
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
        chain: [
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'Veteran vinetooth. Depending on the squad size, will need to manage dps',
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
        chain: [
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'Veteran vinetooth. Depending on the squad size, will need to manage dps',
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
        chain: [
            {
                type: 'Escort',
                img: EventShield,
            },
        ],
        info: 'Small escort with a rally defense at the end',
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
        chain: [
            {
                type: 'Escort',
                img: EventShield,
            },
        ],
        info: 'Small escort with a rally defense at the end. This specific escort can spawn either south or north where the TM spawns',
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
        chain: [
            {
                type: 'Escort',
                img: EventShield,
            },
        ],
        info: 'Small escort with a rally defense at the end',
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
        chain: [
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: 'Daily TM rewards guranteed rare, spirit shard once per day. But, can still be counted for map bonus rewards after.',
        top: `${60}%`,
        left: `${100}%`,
    },
];

</script>