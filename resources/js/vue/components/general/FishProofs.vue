<template>
    <div class="proof-container">
        <div class="proof-box">
            <span class="proof">
                <p>Value per catch: </p>
                <span class="gold-label-container">
                    <span class="gold-label" v-for="gold in formatValue(fishingHole.catchValue)">
                        {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                    </span>
                </span>
            </span>

            <span class="proof">
                <p>Average fishing holes in route: </p>
                <p>{{ Number(fishingHole.avgHoles) }}</p>
            </span>

            <span class="proof">
                <p>Average time to cycle route: </p>
                <p>{{ formatToMinutes(fishingHole.timeVariable) }}</p>
            </span>
        </div>
    
        <span class="written-calculations">
            <p>Estimated gold per hour:</p>
            <p>((catchValue * avgHoles) * 3) * (60 / avgTime)</p>
            <p>or</p>
            <p>(({{ fishingHole.catchValue }} * {{ Number(fishingHole.avgHoles) }} ) * 3) * (60 / {{ fishingHole.timeVariable }})</p>
        </span>
        
        
    </div>
</template>

<script setup>
import { formatValue, formatPercentage, showRarityColor, formatToMinutes } from '@/js/vue/composables/FormatFunctions.js'

const props = defineProps({
    fishingHole: Object,
})

console.log('fishing hole: ', props.fishingHole);

</script>

<style scoped>



</style>