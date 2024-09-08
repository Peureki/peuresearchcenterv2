<template>
    <div class="pie-container" v-if="colorsData.length > 0">
        <Pie
            class="pie"
            :options="chartOptions"
            :data="chartData"
        />

        <div class="stats-container">
            <span v-for="(rarities, index) in uniqueRarities" :key="index" class="stats">
                <p :style="{color: showRarityColor(rarities)}">{{ rarities }}</p>
                <p>{{ formatPercentage(data[index]) }}</p>
            </span>
        </div>
    </div>
    
</template>

<script setup>
import { ref, watch } from 'vue'
import { Pie } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js'
import { formatPercentage, showRarityColor } from '@/js/vue/composables/FormatFunctions.js'

import { getCSSVariable } from '@/js/vue/composables/FormatFunctions';

ChartJS.register(Title, Tooltip, Legend, ArcElement, Legend);

const props = defineProps({
    dropRates: Object, 
})


const uniqueRarities = ref([]);
const colorsData = ref([]);
const rarityColors = ref({
    "Junk": getCSSVariable('--color-rarity-junk'),
    "Basic": getCSSVariable('--color-rarity-basic'),
    "Fine": getCSSVariable('--color-rarity-fine'),
    "Masterwork": getCSSVariable('--color-rarity-masterwork'),
    "Rare": getCSSVariable('--color-rarity-rare'),
    "Exotic": getCSSVariable('--color-rarity-exotic'),
    "Ascended": getCSSVariable('--color-rarity-ascended'),
    "Legendary": getCSSVariable('--color-rarity-legendary')
});
const data = ref([]);
const chartData = {
    datasets: [
        { 
            backgroundColor: ref([]),
            data: ref([])
        }
    ],
}
const chartOptions = ref({
    responsive: true
})

const setLabels = (drops) => {
    const set = new Set(); 
    drops.forEach(item => {
        if (item.rarity){
            set.add(item.rarity); 
        }
    })
    return Array.from(set); 
}

const setColors = (rarities, colorMap) => {
    return rarities.map(rarity => colorMap[rarity] || '#000'); // Default to black if color is not found
};

const setData = (drops, labels) => {
    const dataArray = new Array(labels.length).fill(0); 
    const percentArray = [];
    let totalPercent = 0;
    // Match the labels and add up the total % drop rates for each rarity
    drops.forEach(item => {
        const index = labels.indexOf(item.rarity); 
        dataArray[index] += +item.drop_rate; 
    })
    // Add the total % because some drop rates go above 100%
    dataArray.forEach(data => {
        totalPercent += data; 
    }) 
    // Take the total % and take the amount of data and => data / totalPercent to get the actual % as if it was divided by 100
    dataArray.forEach((data, index) => {
        percentArray[index] = data / totalPercent;
        console.log('percent: ', data/totalPercent);
    })

    return percentArray; 
}

uniqueRarities.value = setLabels(props.dropRates);
colorsData.value = setColors(uniqueRarities.value, rarityColors.value);
data.value = setData(props.dropRates, uniqueRarities.value);

chartData.datasets[0].backgroundColor = colorsData.value;
chartData.datasets[0].data = data.value;

console.log('chart  data: ', colorsData.value);

</script>

<style scoped>
.pie-container{
    display: flex;
    flex-direction: column;
}
.pie{
    max-width: 300px;
}
.stats-container{
    display: flex;
    flex-direction: column;
}
.stats {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

</style>