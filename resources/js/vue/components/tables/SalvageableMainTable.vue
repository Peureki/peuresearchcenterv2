<template>
    <table class="salvageable-table">
        <thead>
            <tr>
                <th colspan="100%"><h4>Best Value</h4></th>
            </tr>
            <tr>
                <!-- 
                    *
                    * NAME HEADER
                    *
                -->
                <th>
                    <span class="sortable-column">
                        <h5>Name</h5>
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[0] = el" 
                            :style="{transform: sortOrder[0] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </span> 
                </th>
                <!-- 
                    *
                    * COPPER-FED HEADER
                    *
                -->
                <th>
                    <span class="sortable-column">
                        <h5>Copper-Fed</h5>
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[1] = el" 
                            :style="{transform: sortOrder[1] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </span> 
                </th>
                <!-- 
                    *
                    * RUNECRAFTER'S HEADER
                    *
                -->
                <th>
                    <span class="sortable-column">
                        <h5>Runecrafter's</h5>
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[2] = el" 
                            :style="{transform: sortOrder[2] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </span> 
                </th>
                <!-- 
                    *
                    * SILVER-FED HEADER
                    *
                -->
                <th>
                    <span class="sortable-column">
                        <h5>Silver-Fed</h5>
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[3] = el" 
                            :style="{transform: sortOrder[3] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </span> 
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- 
                *
                * SALVAGEABLE CONTENT
                *
            -->
            <tr v-for="(salvageable, index) in salvageables">
                <!-- 
                    *
                    * NAME
                    *
                -->
                <td class="item-name-container">
                    <span class="item-name">
                        <img :src="salvageable.icon" :alt="salvageable.name" :title="salvageable.name">
                        {{ salvageable.name }}
                    </span>
                    
                </td>
                <!-- 
                    *
                    * COPPER-FED VALUE
                    *
                -->
                <td 
                    class="gold"
                    :style="{borderRight: colorBkg(salvageable.copperFedValue)}"
                >
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(salvageable.copperFedValue)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
                <!-- 
                    *
                    * RUNECRAFTER'S VALUE
                    *
                -->
                <td 
                    class="gold"
                    :style="{borderRight: colorBkg(salvageable.runecraftersValue)}"
                >
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(salvageable.runecraftersValue)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
                <!-- 
                    *
                    * SILVER-FED VALUE
                    *
                -->
                <td 
                    class="gold"
                    :style="{borderRight: colorBkg(salvageable.silverFedValue)}"
                >
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(salvageable.silverFedValue)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { ref } from 'vue'
import { formatValue } from '@/js/vue/composables/FormatFunctions.js'

const props = defineProps({
    salvageables: Object, 
})

const detailsActive = ref([]),
    sortActive = ref([]), 
    sortOrder = ref([]);

const colorBkg = (value) => {
    return value > 0 ? `var(--border-positive)` : `var(--border-negative)`;
}


</script>

<style scoped>
.item-name-container{
    cursor: pointer;
}
.item-name{
    display: flex;
    gap: 5px;
    align-items: center;
}

</style>