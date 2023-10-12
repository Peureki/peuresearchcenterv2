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
        map-name="Skywatch Archipelago Timers"
        :map="Map"
        alt="Skywatch Archipelago"
        :events="events"
    >
        <template v-slot:info>
            <h4>How This Works</h4>
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

import Nav from '@/js/vue/components/Nav.vue'

import NavTimers from '@/js/vue/components/timers/NavTimers.vue'
import MainTimers from '@/js/vue/components/timers/MainTimers.vue'

import EventSwords from '@/imgs/icons/Event_Swords.png'
import EventBoss from '@/imgs/icons/Event_Boss.png'
import EventShield from '@/imgs/icons/Event_Shield.png'
import EventRally from '@/imgs/icons/Event_Rally.png'
import EventCollect from '@/imgs/icons/Event_Collect.png'
import EventDialogue from '@/imgs/icons/Event_Dialogue.png'

import Map from '@/imgs/maps/Skywatch_Archipelago.jpg'

// INPUT META AND PRE-META TIMES
// name: [name of the event]
// starts: [[hour, min]] 
// If hour is odd UTC, do 3. If even, do 2
let meta = [
    {
        name: "Wizard's Tower",
        starts: [3, 0],
        repeats: 2,
        cooldown: ref(0),
        progress: ref(0),
        status: ref(false),
    },
    {
        name: "Break",
        starts: [3, 25],
        repeats: 2,
        cooldown: ref(0),
        progress: ref(0),
        status: ref(false),
    },
]
// APPLY ONLY if the map has outposts or events that have start collectively when a certain area is completed
let outposts = [

]
// GROUPS of checkboxes
// When applying true or false, the event's toggle also needs to match
let checkboxes = [
    {
        name: "Droknar's Light",
        toggle: ref(true),
    },
    {
        name: "Skyward Marches",
        toggle: ref(true),
    },
    {
        name: "Primal Maguuma",
        toggle: ref(true),
    },
    {
        name: "Rata Novus",
        toggle: ref(true),
    },
    {
        name: "Garanhoff",
        toggle: ref(true),
    },
    {
        name: "Jade Mech",
        toggle: ref(true),
    },
]

let events = [
    /*
     * DROKNAR'S LIGHT
     */
    {
        name: "Recruits",
        outpost: "Droknar's Light",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 10),
        initialMin: 60 * 0 + 13,
        initialMax: -(60 * 0 + 13),
        respawnCooldown: ref(60 * 6 + 10), 
        respawnMin: 60 * 0 + 13,
        respawnMax: -(60 * 0 + 13),
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
        info: '1) Small group of veteran dwarves. 2) Champ similar to the Forged skateboarder dude',
        waypointName: "Droknar's Light Waypoint",
        waypointLink: "[&BL4NAAA=]",
        top: `${32}%`,
        left: `${33}%`, 
    },
    {
        name: "Stone Summit",
        outpost: "Droknar's Light",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 50),
        initialMin: 60 * 0 + 12,
        initialMax: -(60 * 0 + 12),
        respawnCooldown: ref(60 * 6 + 50), 
        respawnMin: 60 * 0 + 12,
        respawnMax: -(60 * 0 + 12),
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
                type: 'Skirmish',
                img: EventSwords,
            },
        ],
        info: '1) Find debris and kill enemies 2) 3 Kryptis rifts',
        waypointName: "Droknar's Light Waypoint",
        waypointLink: "[&BL4NAAA=]",
        top: `${35}%`,
        left: `${10}%`, 
    },
    {
        name: "Angry Dwarves",
        outpost: "Droknar's Light",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 11 + 55),
        initialMin: 60 * 0 + 39,
        initialMax: -(60 * 1 + 5),
        respawnCooldown: ref(60 * 11 + 55), 
        respawnMin: 60 * 0 + 39,
        respawnMax: -(60 * 1 + 5),
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
        info: 'Both a skirmish of Dwarves and a kryptis boss',
        waypointName: "Droknar's Light Waypoint",
        waypointLink: "[&BL4NAAA=]",
        top: `${50}%`,
        left: `${25}%`, 
    },
    // {
    //     name: "Ice Elemental",
    //     outpost: "Droknar's Light",
    //     singleCooldown: ref(true),
    //     initialCooldown: ref(60 * 19 + 10),
    //     initialMin: 60 * 7 + 40,
    //     initialMax: -(60 * 6 + 52),
    //     respawnCooldown: ref(60 * 19 + 10), 
    //     respawnMin: 60 * 7 + 40,
    //     respawnMax: -(60 * 6 + 52),
    //     active: ref(false),
    //     respawnActive: ref(false),
    //     toggleCheckbox: ref(true),
    //     togglePlay: ref(true),
    //     toggleInfo: ref(false),
    //     toggleTooltip: ref(false),
    //     chain: [
    //         {
    //             type: 'Boss',
    //             img: EventBoss,
    //         },
    //     ],
    //     info: 'More an ice storm than an elemental',
    //     waypointName: "Droknar's Light Waypoint",
    //     waypointLink: "[&BL4NAAA=]",
    //     top: `${45}%`,
    //     left: `${7}%`, 
    // },
    {
        name: "Tiraeus",
        outpost: "Droknar's Light",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 7 + 5),
        initialMin: 60 * 0 + 16,
        initialMax: -(60 * 0 + 23),
        respawnCooldown: ref(60 * 7 + 5), 
        respawnMin: 60 * 0 + 16,
        respawnMax: -(60 * 0 + 23),
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
        info: 'Champ kryptis gluttony. Moves to different platforms',
        waypointName: "Droknar's Light Waypoint",
        waypointLink: "[&BL4NAAA=]",
        top: `${60}%`,
        left: `${5}%`, 
    },
    {
        name: "Elrik",
        outpost: "Droknar's Light",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 11 + 40),
        initialMin: 60 * 3 + 25,
        initialMax: -(60 * 3 + 25),
        respawnCooldown: ref(60 * 11 + 40), 
        respawnMin: 60 * 3 + 25,
        respawnMax: -(60 * 3 + 25),
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
                type: 'Collect',
                img: EventCollect,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
            
        ],
        info: '1) Escort to different locations with lots of mobs spawning. 2) Gather event 3) Quick dwarven boss',
        waypointName: "Droknar's Light Waypoint",
        waypointLink: "[&BL4NAAA=]",
        top: `${23}%`,
        left: `${15}%`, 
    },
    /*
     * Skyward Marches
     */
     {
        name: "Zaishen",
        outpost: "Skyward Marches",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 4 + 40),
        initialMin: 60 * 0 + 27,
        initialMax: -(60 * 0 + 25),
        respawnCooldown: ref(60 * 4 + 40), 
        respawnMin: 60 * 0 + 27,
        respawnMax: -(60 * 0 + 25),
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
                type: 'Dialogue',
                img: EventDialogue,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: '1) Hoards of Forged enemies. 2) Speak to NPCs to progress the event (or get mobbed on) 3) Champ Regret',
        waypointName: "Astral Ward Encampment Waypoint",
        waypointLink: "[&BA4OAAA=]",
        top: `${82}%`,
        left: `${65}%`, 
    },
     {
        name: "Champ Cannonade",
        outpost: "Skyward Marches",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 4 + 15),
        initialMin: 60 * 0 + 6,
        initialMax: -(60 * 0 + 6),
        respawnCooldown: ref(60 * 4 + 15), 
        respawnMin: 60 * 0 + 6,
        respawnMax: -(60 * 0 + 6),
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
        info: 'Champ Forged Cannonder. Can spawn lots of mobs with a lot of people',
        waypointName: "Astral Ward Encampment Waypoint",
        waypointLink: "[&BA4OAAA=]",
        top: `${76}%`,
        left: `${45}%`, 
    },
    /*
     * Primal Maguuma
     */
     {
        name: "Grubs",
        outpost: "Primal Maguuma",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 30),
        initialMin: 60 * 0 + 15,
        initialMax: -(60 * 0 + 24),
        respawnCooldown: ref(60 * 6 + 30), 
        respawnMin: 60 * 0 + 15,
        respawnMax: -(60 * 0 + 24),
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
        info: '1) Use Skyscale fireballs to kill grubs. 2) Grub boss',
        waypointName: "Droknar's Light Waypoint",
        waypointLink: "[&BL4NAAA=]",
        top: `${27}%`,
        left: `${65}%`, 
    },
    {
        name: "Wyvern",
        outpost: "Primal Maguuma",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 7 + 15),
        initialMin: 60 * 0 + 43,
        initialMax: -(60 * 0 + 27),
        respawnCooldown: ref(60 * 7 + 15), 
        respawnMin: 60 * 0 + 43,
        respawnMax: -(60 * 0 + 27),
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
        info: 'Champ Fire Wyvern',
        waypointName: "Droknar's Light Waypoint",
        waypointLink: "[&BL4NAAA=]",
        top: `${23}%`,
        left: `${50}%`, 
    },
    {
        name: "Stonehead",
        outpost: "Primal Maguuma",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 50),
        initialMin: 60 * 0 + 5,
        initialMax: -(60 * 0 + 4),
        respawnCooldown: ref(60 * 6 + 50), 
        respawnMin: 60 * 0 + 5,
        respawnMax: -(60 * 0 + 4),
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
        info: 'Champ Stonehead',
        waypointName: "Droknar's Light Waypoint",
        waypointLink: "[&BL4NAAA=]",
        top: `${8}%`,
        left: `${50}%`, 
    },
    /*
     * Rata Novus
     */
    {
        name: "Brull",
        outpost: "Rata Novus",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 40),
        initialMin: 60 * 0 + 30,
        initialMax: -(60 * 0 + 30),
        respawnCooldown: ref(60 * 6 + 40), 
        respawnMin: 60 * 0 + 30,
        respawnMax: -(60 * 0 + 30),
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
        info: '1) Escort. Near the end, gather stuff. 2) Champ Kryptis',
        waypointName: "Rata Novus Promenade Waypoint",
        waypointLink: "[&BOANAAA=]",
        top: `${11}%`,
        left: `${95}%`, 
    },
    {
        name: "Power Sentry",
        outpost: "Rata Novus",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 8 + 50),
        initialMin: 60 * 1 + 10,
        initialMax: -(60 * 0 + 42),
        respawnCooldown: ref(60 * 8 + 50), 
        respawnMin: 60 * 1 + 10,
        respawnMax: -(60 * 0 + 42),
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
        info: 'Smash ley line energy caps and throw them to the downed sentry',
        waypointName: "Rata Novus Promenade Waypoint",
        waypointLink: "[&BOANAAA=]",
        top: `${20}%`,
        left: `${110}%`, 
    },
    {
        name: "Chak Eggs",
        outpost: "Rata Novus",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 7 + 5),
        initialMin: 60 * 1 + 7,
        initialMax: -(60 * 0 + 46),
        respawnCooldown: ref(60 * 7 + 5), 
        respawnMin: 60 * 1 + 7,
        respawnMax: -(60 * 0 + 46),
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
        ],
        info: '1) Smash chak eggs. 2) Kill chak',
        waypointName: "Rata Novus Promenade Waypoint",
        waypointLink: "[&BOANAAA=]",
        top: `${30}%`,
        left: `${113}%`, 
    },
    /*
     * GARANHOFF
     */
    {
        name: "Briella",
        outpost: "Garanhoff",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 5 + 50),
        initialMin: 60 * 0 + 13,
        initialMax: -(60 * 0 + 13),
        respawnCooldown: ref(60 * 5 + 50), 
        respawnMin: 60 * 0 + 13,
        respawnMax: -(60 * 0 + 13),
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
        info: '1) Become a chef and follow directions on what to collect from the NPC. 2) Short escort to Garanhoof waypoint. 3) Champ Kryptis',
        waypointName: "Beacon of Ages Waypoint",
        waypointLink: "[&BCsOAAA=]",
        top: `${80}%`,
        left: `${120}%`, 
    },
    {
        name: "Lucretia",
        outpost: "Garanhoff",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 6 + 15),
        initialMin: 60 * 0 + 19,
        initialMax: -(60 * 0 + 19),
        respawnCooldown: ref(60 * 6 + 15), 
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
                type: 'Escort',
                img: EventShield,
            },
            {
                type: 'Defense',
                img: EventShield,
            },
            {
                type: 'Boss',
                img: EventBoss,
            },
        ],
        info: '1) Escort NPC. 2) For 3 mins, kill lots of elementals. 3) Champ human NPC',
        waypointName: "Garenhoff Refugee Camp Waypoint",
        waypointLink: "[&BBUOAAA=]",
        top: `${58}%`,
        left: `${115}%`, 
    },
    {
        name: "Champ Elemental",
        outpost: "Garanhoff",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 9 + 10),
        initialMin: 60 * 0 + 16,
        initialMax: -(60 * 0 + 11),
        respawnCooldown: ref(60 * 9 + 10), 
        respawnMin: 60 * 0 + 16,
        respawnMax: -(60 * 0 + 11),
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
        info: 'Champ Earth Elemental',
        waypointName: "Garenhoff Refugee Camp Waypoint",
        waypointLink: "[&BBUOAAA=]",
        top: `${45}%`,
        left: `${100}%`, 
    },
    /*
     * Jade Mech
     */
     {
        name: "Naga",
        outpost: "Jade Mech",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 29 + 35),
        initialMin: 60 * 2 + 11,
        initialMax: -(60 * 3 + 46),
        respawnCooldown: ref(60 * 29 + 35), 
        respawnMin: 60 * 2 + 11,
        respawnMax: -(60 * 3 + 45),
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
        info: 'Both a defense event and a champ Naga boss',
        waypointName: "Kestrel's Vow Waypoint",
        waypointLink: "[&BD8OAAA=]",
        top: `${50}%`,
        left: `${55}%`, 
    },
];

</script>