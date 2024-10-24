<template>
    <div class="guide-container">
        <h3>Route</h3>

        <button @click="(e) => {copyWaypoint(copyAllWaypoints(guides)); showTooltip(e)}">Copy all waypoints</button>

        <GuideItem
            v-for="(guide, index) in guides"
            :index="index + 1"
            :instruction="guide.instruction"
            :waypoint-name="guide.waypointName"
            :waypoint-link="guide.waypointLink"
            :img="guide.img"
            :alt="guide.alt"
            @handle-show-tooltip="showTooltip"
        />       
    </div>

    <Transition name="fade">
        <CursorTooltip v-if="tooltipToggle" message="Copied!" :mouseX="mouseX" :mouseY="mouseY" />
    </Transition>
</template>

<script setup>
import { ref } from 'vue'
import { copyWaypoint, copyAllWaypoints } from '@/js/vue/composables/BasicFunctions';
import { handleCursorTooltip } from '@/js/vue/composables/MouseFunctions'

// Cursor tooltip
import CursorTooltip from '@/js/vue/components/general/CursorTooltip.vue';
import GuideItem from '@/js/vue/components/guides/nodes/GuideItem.vue';

// Picture guides
import Brisband from '@/imgs/guides/nodes/Rich_Nodes_Brisband_Wildlands.webp'
import Kessex from '@/imgs/guides/nodes/Rich_Nodes_Kessex_Hills.webp'
import Harathi from '@/imgs/guides/nodes/Rich_Nodes_Harathi_Hinterlands.webp'
import Gendarren from '@/imgs/guides/nodes/Rich_Nodes_Gendarran_Fields.webp'
import Lornars from '@/imgs/guides/nodes/Rich_Nodes_Lornars_Pass.webp'
import Snowden from '@/imgs/guides/nodes/Rich_Nodes_Snowden_Drifts.webp'
import Diessa from '@/imgs/guides/nodes/Rich_Nodes_Diessa_Plateau.webp'
import Fireheart from '@/imgs/guides/nodes/Rich_Nodes_Fireheart_Rise.webp'
import IronMarches from '@/imgs/guides/nodes/Rich_Nodes_Iron_Marches.webp'
import Blazeridge from '@/imgs/guides/nodes/Rich_Nodes_Blazeridge_Steppes.webp'
import Fields from '@/imgs/guides/nodes/Rich_Nodes_Fields_of_Ruin.webp'
import Dredgehaunt from '@/imgs/guides/nodes/Rich_Nodes_Dredgehaunt_Cliffs.webp'
import Bloodtide from '@/imgs/guides/nodes/Rich_Nodes_Bloodtide_Coast.webp'
import Sparkfly from '@/imgs/guides/nodes/Rich_Nodes_Sparkfly_Fen.webp'
import Timberline from '@/imgs/guides/nodes/Rich_Nodes_Timberline_Falls.webp'
import MountMaelstrom from '@/imgs/guides/nodes/Rich_Nodes_Mount_Maelstrom.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "Near the waypoint, head down. There will also be lots of other ore nodes below or above the canyon",
        waypointName: "Gallowfields Waypoint",
        waypointLink: "[&BGMAAAA=]",
        img: Brisband,
        alt: "Brisband Wildlands"
    },
    {
        instruction: "There are Rich Irons that could be a Rich Silver instead. Only TWO out of the 3 rich nodes can be Iron. The west-most and the southeast-most waypoints. If you notice that the west is Silver, then you know the other two are Irons",
        waypointName: "Overlords's Waypoint",
        waypointLink: "[&BAQAAAA=]",
        img: Kessex,
        alt: "Kessex Hills"
    },
    {
        instruction: "One of these may be a Silver. If you know the west ore was Iron and the ore directly below the waypoint (hover your minimap) is Iron, then you know the last ore is Silver. If the ore not directly below the waypoint is Iron, then you need to drop down a hole near the waypoint to get to the other node.",
        waypointName: "Cereboth Waypoint",
        waypointLink: "[&BBIAAAA=]",
        img: Kessex,
        alt: "Kessex Hills"
    },
    {
        instruction: "One of these may be a Silver. If you know the west ore was Iron and the ore directly below the waypoint (hover your minimap) is Iron, then you know the last ore is Silver. If the ore not directly below the waypoint is Iron, then you need to drop down a hole near the waypoint to get to the other node.",
        waypointName: "Cereboth Waypoint",
        waypointLink: "[&BBIAAAA=]",
        img: Kessex,
        alt: "Kessex Hills"
    },
    {
        instruction: "Head north into a cave/temple thingy. You'll turn directly left, then right, then right again but at the last enterence.",
        waypointName: "Demetra Waypoint",
        waypointLink: "[&BKsAAAA=]",
        img: Harathi,
        alt: "Harathi Hinterlands"
    },
    {
        instruction: "There will be a cave slightly northwest of the waypoint. Take a left at the fork.",
        waypointName: "Icegate Waypoint",
        waypointLink: "[&BKsAAAA=]",
        img: Gendarren,
        alt: "Gendarran Fields"
    },
    {
        instruction: "Head north depper into the cave. Near the end, there will be large cracks on the left. From there, the node will be at the top.",
        waypointName: "Icedevil's Waypoint",
        waypointLink: "[&BFEGAAA=]",
        img: Lornars,
        alt: "Lornar's Pass"
    },
    {
        instruction: "Head south into a cave. Left once you get inside the cave.",
        waypointName: "Snowhawk Waypoint",
        waypointLink: "[&BL8AAAA=]",
        img: Snowden,
        alt: "Snowden Drifts"
    },
    {
        instruction: "Head west from the waypoint to a small enterence with Charr. The node will be on the left and the back.",
        waypointName: "Oldgate Waypoint",
        waypointLink: "[&BF4BAAA=]",
        img: Diessa,
        alt: "Diessa Plateau"
    },
    {
        instruction: "From the west-most waypoint, head north into a cave. At the end of the cave will be the node.",
        waypointName: "Rustbowl Waypoint",
        waypointLink: "[&BB4CAAA=]",
        img: Fireheart,
        alt: "Fireheart Rise"
    },
    {
        instruction: "From the east-most waypoint, head up and you'll see the node in the center of the canyon. There may be extra rich nodes if you keep going east.",
        waypointName: "Breaktooth's Waypoint",
        waypointLink: "[&BBoCAAA=]",
        img: Fireheart,
        alt: "Fireheart Rise"
    },
    {
        instruction: "From the east-most waypoint, jump across the cliffs to reach the node.",
        waypointName: "Gladefall Waypoint",
        waypointLink: "[&BO4BAAA=]",
        img: IronMarches,
        alt: "Iron Marches"
    },
    {
        instruction: "From the west-most waypoint, head north. The node will be the northeast-most corner.",
        waypointName: "Grostogg's Waypoint",
        waypointLink: "[&BO8BAAA=]",
        img: IronMarches,
        alt: "Iron Marches"
    },
    {
        instruction: "From the waypoint, head east into a small cave. When you get into the cave and there's a big opening, fall down into the water. The node will be on the ground at surface level.",
        waypointName: "Behem Waypoint",
        waypointLink: "[&BP0BAAA=]",
        img: Blazeridge,
        alt: "Blazeridge Steppes"
    },
    {
        instruction: "The node will be directly above the waypoint",
        waypointName: "Helliot Mine Waypoint",
        waypointLink: "[&BEsBAAA=]",
        img: Fields,
        alt: "Fields of Ruin"
    },
    {
        instruction: "There will be a cave to the east. There may be another Rich Iron on the way. If not, keep heading east and you'll see the Rich Node at the bottom.",
        waypointName: "Wyrmblood Waypoint",
        waypointLink: "[&BGUCAAA=]",
        img: Dredgehaunt,
        alt: "Dredgehaunt Cliffs"
    },
    {
        instruction: "Directly north will be a large cave. Once you get to the middle of the cave, there will be a large pipe. Fly up and the rich platinum will be on the left.",
        waypointName: "Mournful Waypoint",
        waypointLink: "[&BK0BAAA=]",
        img: Bloodtide,
        alt: "Bloodtide Coast"
    },
    {
        instruction: "At the west waypoint, head directly west. There may be one or two more Rich Nodes along the way. The permanent node will be where the Vista is.",
        waypointName: "Ocean's Gullet Waypoint",
        waypointLink: "[&BMkBAAA=]",
        img: Sparkfly,
        alt: "Sparkfly Fen"
    },
    // {
    //     instruction: "[OPTIONAL]. From the east waypoint, you can head south and into a cave. There will be a champ spider guarding it. If you're quick or have invis, you should be fine. There may be another rich node along this path.",
    //     waypointName: "Saltflood Waypoint",
    //     waypointLink: "[&BMcBAAA=]",
    //     img: Sparkfly,
    //     alt: "Sparkfly Fen"
    // },
    {
        instruction: "Lots of nodes along the way. Head southwest, underwater",
        waypointName: "Gentle River Waypoint",
        waypointLink: "[&BFACAAA=]",
        img: Timberline,
        alt: "Timberline Falls"
    },
    {
        instruction: "From the west waypoint, fly west and the rich node will be on the edge of the cliff. There may be another rich node south.",
        waypointName: "Criterion Waypoint",
        waypointLink: "[&BMkCAAA=]",
        img: MountMaelstrom,
        alt: "Mount Maelstrom"
    },
    {
        instruction: "From the east waypoint, head directly north. There may be another rich node past the boss platform. Otherwise the pernmanet rich node is underwater.",
        waypointName: "Old Sledge Site Waypoint",
        waypointLink: "[&BNQCAAA=]",
        img: MountMaelstrom,
        alt: "Mount Maelstrom"
    },
])

</script>