<template>
    <div class="pie-container" v-if="data.length > 0">
        <Pie
            class="pie"
            :options="chartOptions"
            :data="chartData"
        />

        <div class="stats-container">
            <span v-for="(array, index) in data" :key="index" class="stats">
                <p :style="{color: showRarityColor(array.rarity)}">{{ array.rarity }}</p>
                <p>{{ formatPercentage(array.dropRate) }}</p>
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


const setData = (drops, labels) => {
    const dataArray = labels.map(label => ({
        hexColor: rarityColors.value[label],
        rarity: label,
        dropRate: 0, 
    }));
    const percentArray = [];
    let totalPercent = 0;
    // Match the labels and add up the total % drop rates for each rarity
    drops.forEach(item => {
        const index = labels.indexOf(item.rarity); 
        if (index !== -1){
            dataArray[index].dropRate += +item.drop_rate; 
        }
    })

    // Add the total % because some drop rates go above 100%
    dataArray.forEach(data => {
        totalPercent += data.dropRate; 
    }) 

    // Take the total % and take the amount of data and => data / totalPercent to get the actual % as if it was divided by 100
    dataArray.forEach((data, index) => {
        dataArray[index].dropRate = data.dropRate / totalPercent;
    })


    // Return and sort by highest % to lowest
    return dataArray.sort((a, b) => b.dropRate - a.dropRate); 
}

uniqueRarities.value = setLabels(props.dropRates);
data.value = setData(props.dropRates, uniqueRarities.value);



chartData.datasets[0].backgroundColor = data.value.map(item => item.hexColor);
chartData.datasets[0].data = data.value.map(item => item.dropRate);



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