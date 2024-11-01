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
        map-name="Lake Doric Timers"
        :map="Map"
        alt="Lake Doric"
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
import PetrifiedWood from '@/imgs/icons/Petrified_Wood.png'
import Mithril from '@/imgs/icons/Mithril_Ore.png'
import Orichalcum from '@/imgs/icons/Orichalcum_Ore.png'
import Flax from '@/imgs/icons/Pile_of_Flax_Seeds.png'
import JunglePlant from '@/imgs/icons/Maguuma_Lily.png'
import Mussel from '@/imgs/icons/Mussel.png'
import SawgillMushroom from '@/imgs/icons/Sawgill_Mushroom.png'
import Lotus from '@/imgs/icons/Lotus_Root.png'
import Passiflora from '@/imgs/icons/Passion_Fruit.png'
import BloomingPassiflora from '@/imgs/icons/Passion_Flower.png'


import EventSwords from '@/imgs/icons/Event_Swords.png'
import EventBoss from '@/imgs/icons/Event_Boss.png'
import EventShield from '@/imgs/icons/Event_Shield.png'
import EventRally from '@/imgs/icons/Event_Rally.png'
import EventCollect from '@/imgs/icons/Event_Collect.png'
import EventCog from '@/imgs/icons/Event_Cog.png'

import Map from '@/imgs/maps/Lake_Doric.jpg'

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
        name: "Jade Cannon",
        toggle: ref(true),
    },
    {
        name: "Skrimish",
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
        name: "Petrified Wood",
        quantity: ref(0),
        src: PetrifiedWood,
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
        name: "Lotus",
        quantity: ref(0),
        src: Lotus,
    },
    {
        name: "Passiflora",
        quantity: ref(0),
        src: Passiflora,
    },
    {
        name: "Blooming Passiflora",
        quantity: ref(0),
        src: BloomingPassiflora,
    },
]

let events = [
    {
        name: "Jade Cannon @Doric Lumberyard",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 9 + 35),
        initialMin: 60 * 0 + 7,
        initialMax: -(60 * 0 + 11),
        respawnCooldown: ref(60 * 9 + 35), 
        respawnMin: 60 * 0 + 7,
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
                img: EventCog,
            },
        ],
        info: 'Every 25% health, must CC to continue doing damage. Every 25% will also produce waves of enemies',
        waypointName: "Red Leaf Retreat Waypoint",
        waypointLink: "[&BK8JAAA=]",
        top: `${23}%`,
        left: `${60}%`,
    },
    {
        name: "Jade Cannon @Fort Evennia",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 9 + 35),
        initialMin: 60 * 0 + 7,
        initialMax: -(60 * 0 + 11),
        respawnCooldown: ref(60 * 9 + 35), 
        respawnMin: 60 * 0 + 7,
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
                img: EventCog,
            },
        ],
        info: 'Every 25% health, must CC to continue doing damage. Every 25% will also produce waves of enemies',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${42}%`,
        left: `${95}%`,
    },
    {
        name: "Jade Cannon @Lakeside Bazaar",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 9 + 35),
        initialMin: 60 * 0 + 7,
        initialMax: -(60 * 0 + 11),
        respawnCooldown: ref(60 * 9 + 35), 
        respawnMin: 60 * 0 + 7,
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
                img: EventCog,
            },
        ],
        info: 'Every 25% health, must CC to continue doing damage. Every 25% will also produce waves of enemies',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${56}%`,
        left: `${66}%`,
    },
    {
        name: "Jade Cannon @New Loamhurst",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 9 + 35),
        initialMin: 60 * 0 + 7,
        initialMax: -(60 * 0 + 11),
        respawnCooldown: ref(60 * 9 + 35), 
        respawnMin: 60 * 0 + 7,
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
                img: EventCog,
            },
        ],
        info: 'Every 25% health, must CC to continue doing damage. Every 25% will also produce waves of enemies',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${83}%`,
        left: `${60}%`,
    },
    {
        name: "Skirmish @Harvest Cascades",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 22 + 5),
        initialMin: 60 * 2 + 11,
        initialMax: -(60 * 1 + 46),
        respawnCooldown: ref(60 * 22 + 5), 
        respawnMin: 60 * 2 + 11,
        respawnMax: -(60 * 1 + 46),
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
        info: 'Waves of White Mantle',
        waypointName: "Red Leaf Retreat Waypoint",
        waypointLink: "[&BK8JAAA=]",
        top: `${15}%`,
        left: `${42}%`,
    },
    {
        name: "Skirmish @Mantle's Breach",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 22 + 5),
        initialMin: 60 * 2 + 11,
        initialMax: -(60 * 1 + 46),
        respawnCooldown: ref(60 * 22 + 5), 
        respawnMin: 60 * 2 + 11,
        respawnMax: -(60 * 1 + 46),
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
        info: 'Waves of White Mantle',
        waypointName: "Doric's Landing Waypoint",
        waypointLink: "[&BK0JAAA=]",
        top: `${35}%`,
        left: `${30}%`,
    },
    {
        name: "Skirmish @Fort Evennia",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 22 + 5),
        initialMin: 60 * 2 + 11,
        initialMax: -(60 * 1 + 46),
        respawnCooldown: ref(60 * 22 + 5), 
        respawnMin: 60 * 2 + 11,
        respawnMax: -(60 * 1 + 46),
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
        info: 'Waves of White Mantle',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${35}%`,
        left: `${75}%`,
    },
    {
        name: "Skirmish @East Hunting Grounds",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 22 + 5),
        initialMin: 60 * 2 + 11,
        initialMax: -(60 * 1 + 46),
        respawnCooldown: ref(60 * 22 + 5), 
        respawnMin: 60 * 2 + 11,
        respawnMax: -(60 * 1 + 46),
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
        info: 'Waves of White Mantle',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${50}%`,
        left: `${80}%`,
    },
    {
        name: "Skirmish @Saidra's Haven",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 22 + 5),
        initialMin: 60 * 2 + 11,
        initialMax: -(60 * 1 + 46),
        respawnCooldown: ref(60 * 22 + 5), 
        respawnMin: 60 * 2 + 11,
        respawnMax: -(60 * 1 + 46),
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
        info: 'Waves of White Mantle',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${58}%`,
        left: `${48}%`,
    },
    {
        name: "Skirmish @Lakeside Bazaar",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 22 + 5),
        initialMin: 60 * 2 + 11,
        initialMax: -(60 * 1 + 46),
        respawnCooldown: ref(60 * 22 + 5), 
        respawnMin: 60 * 2 + 11,
        respawnMax: -(60 * 1 + 46),
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
        info: 'Waves of White Mantle',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${61}%`,
        left: `${75}%`,
    },
    {
        name: "Skirmish @New Loamhurst",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 22 + 5),
        initialMin: 60 * 2 + 11,
        initialMax: -(60 * 1 + 46),
        respawnCooldown: ref(60 * 22 + 5), 
        respawnMin: 60 * 2 + 11,
        respawnMax: -(60 * 1 + 46),
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
        info: 'Waves of White Mantle',
        waypointName: "Doric's Landing Waypoint",
        waypointLink: "[&BK0JAAA=]",
        top: `${75}%`,
        left: `${40}%`,
    },
    {
        name: "Skirmish @Melandru's Refuge",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 22 + 5),
        initialMin: 60 * 2 + 11,
        initialMax: -(60 * 1 + 46),
        respawnCooldown: ref(60 * 22 + 5), 
        respawnMin: 60 * 2 + 11,
        respawnMax: -(60 * 1 + 46),
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
        info: 'Waves of White Mantle',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${86}%`,
        left: `${72}%`,
    },
    {
        name: "Bloodstone Champ @Doric's Landing",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 18 + 30),
        initialMin: 60 * 1 + 39,
        initialMax: -(60 * 2 + 42),
        respawnCooldown: ref(60 * 18 + 30), 
        respawnMin: 60 * 1 + 39,
        respawnMax: -(60 * 2 + 42),
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
        info: 'Bloodstone Elemental Champ. Keep running to avoid the little guys from exploding on ya',
        waypointName: "Doric's Landing Waypoint",
        waypointLink: "[&BK0JAAA=]",
        top: `${65}%`,
        left: `${20}%`,
    },
    {
        name: "Bloodstone Champ @Lakeside Bazaar",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 18 + 30),
        initialMin: 60 * 1 + 39,
        initialMax: -(60 * 2 + 42),
        respawnCooldown: ref(60 * 18 + 30), 
        respawnMin: 60 * 1 + 39,
        respawnMax: -(60 * 2 + 42),
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
        info: 'Bloodstone Elemental Champ. Keep running to avoid the little guys from exploding on ya',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${54}%`,
        left: `${96}%`,
    },
    {
        name: "Jade Construct @Doric Lumberyard",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 18 + 30),
        initialMin: 60 * 1 + 39,
        initialMax: -(60 * 2 + 42),
        respawnCooldown: ref(60 * 18 + 30), 
        respawnMin: 60 * 1 + 39,
        respawnMax: -(60 * 2 + 42),
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
        info: 'Could be a Jade Armor or Jade Bow champ. Kill it quick before it kills the Watchknight',
        waypointName: "Red Leaf Retreat Waypoint",
        waypointLink: "[&BK8JAAA=]",
        top: `${20}%`,
        left: `${65}%`,
    },
    {
        name: "Jade Construct @Fort Evennia",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 18 + 30),
        initialMin: 60 * 1 + 39,
        initialMax: -(60 * 2 + 42),
        respawnCooldown: ref(60 * 18 + 30), 
        respawnMin: 60 * 1 + 39,
        respawnMax: -(60 * 2 + 42),
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
        info: 'Could be a Jade Armor or Jade Bow champ. Kill it quick before it kills the Watchknight',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${26}%`,
        left: `${80}%`,
    },
    {
        name: "Jade Construct @Eastern Hunting Grounds",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 18 + 30),
        initialMin: 60 * 1 + 39,
        initialMax: -(60 * 2 + 42),
        respawnCooldown: ref(60 * 18 + 30), 
        respawnMin: 60 * 1 + 39,
        respawnMax: -(60 * 2 + 42),
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
        info: 'Could be a Jade Armor or Jade Bow champ. Kill it quick before it kills the Watchknight',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${47}%`,
        left: `${95}%`,
    },
    {
        name: "Jade Construct @Lakeside Bazaar",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 18 + 30),
        initialMin: 60 * 1 + 39,
        initialMax: -(60 * 2 + 42),
        respawnCooldown: ref(60 * 18 + 30), 
        respawnMin: 60 * 1 + 39,
        respawnMax: -(60 * 2 + 42),
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
        info: 'Could be a Jade Armor or Jade Bow champ. Kill it quick before it kills the Watchknight',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${69}%`,
        left: `${75}%`,
    },
    {
        name: "Priest",
        outpost: "",
        singleCooldown: ref(true),
        initialCooldown: ref(60 * 14 + 55),
        initialMin: 60 * 0 + 1,
        initialMax: -(60 * 1 + 0),
        respawnCooldown: ref(60 * 14 + 55), 
        respawnMin: 60 * 0 + 1,
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
                type: 'Defense',
                img: EventShield,
            },
        ],
        info: '1) Escort an NPC with 3 spots, 2 waves of White Mantle each. 2) Then a defense event',
        waypointName: "Lakeside Bazaar Waypoint",
        waypointLink: "[&BLQJAAA=]",
        top: `${64}%`,
        left: `${95}%`,
    },
    
];

</script>