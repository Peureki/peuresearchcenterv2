<template>
    <table class="currency-table">
        <thead>
            <tr>
                <th colspan="100%"><h4>Best Value</h4></th>
            </tr>
            <tr>
                <!-- 
                    * TABLE HEADERS 
                    * 
                    * @click 
                    * -> toggle active columns that are being sorted
                    * -> toggle the order of sort (descending by default)
                    * -> sort this table
                    *
                    * @mouseover, @mouseout 
                    * -> set the headerIndex to be true when hovering -> highlights header column's borders to show if its sortable
                -->
                <!-- 
                    *
                    * NAME HEADER
                    *
                -->
                <th 
                    @click="
                        toggleActive(0, sortActive);
                        toggleSortOrder(0, sortOrder);
                        sortTable('currency-table', 0, 'string', sortOrder);
                    "
                >
                    <span class="sortable-column">
                        <h5>Name</h5>
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[0] = el" 
                            :style="{transform: sortOrder[0] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </span> 
                </th>
                <!-- 
                    *
                    * PROFIT/BAG HEADER
                    *
                -->
                <th 
                    @click="
                        toggleActive(1, sortActive);
                        toggleSortOrder(1, sortOrder);
                        sortTable('currency-table', 1, 'gold', sortOrder);
                    "
                >
                    <span class="sortable-column">
                        <h5>Profit/Bag</h5>
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[1] = el" 
                            :style="{transform: sortOrder[1] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </span> 
                </th>
                <!-- 
                    *
                    * CURRENCY HEADER
                    *
                -->
                <th 
                    @click="
                        toggleActive(2, sortActive);
                        toggleSortOrder(2, sortOrder);
                        sortTable('currency-table', 2, 'gold', sortOrder);
                    "
                >
                    <span class="sortable-column">
                        <img :src="currencyIcon" :alt="alt" :title="alt">
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[2] = el" 
                            :style="{transform: sortOrder[2] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </span> 
                </th>
                <!-- 
                    *
                    * OTHER CURRENCY HEADER
                    * Apply only if it exists
                -->
                <th 
                    v-if="otherCurrencyIcon"
                    @click="
                        toggleActive(3, sortActive);
                        toggleSortOrder(3, sortOrder);
                        sortTable('currency-table', 3, 'gold', sortOrder);
                    "
                >
                    <span class="sortable-column">
                        <img :src="otherCurrencyIcon" :alt="otherAlt" :title="otherAlt">
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[3] = el" 
                            :style="{transform: sortOrder[3] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </span> 
                </th>
                <!-- 
                    *
                    * INFO HEADER
                    *
                -->
                <th>
                    <svg viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.16675 13.1665H9.83341V8.1665H8.16675V13.1665ZM9.00008 6.49984C9.23619 6.49984 9.43425 6.41984 9.59425 6.25984C9.75425 6.09984 9.83397 5.90206 9.83341 5.6665C9.83341 5.43039 9.75341 5.23234 9.59341 5.07234C9.43341 4.91234 9.23564 4.83261 9.00008 4.83317C8.76397 4.83317 8.56591 4.91317 8.40591 5.07317C8.24591 5.23317 8.16619 5.43095 8.16675 5.6665C8.16675 5.90262 8.24675 6.10067 8.40675 6.26067C8.56675 6.42067 8.76453 6.50039 9.00008 6.49984ZM9.00008 17.3332C7.8473 17.3332 6.76397 17.1143 5.75008 16.6765C4.73619 16.2387 3.85425 15.6451 3.10425 14.8957C2.35425 14.1457 1.76064 13.2637 1.32341 12.2498C0.886193 11.2359 0.667304 10.1526 0.666748 8.99984C0.666748 7.84706 0.885637 6.76373 1.32341 5.74984C1.76119 4.73595 2.3548 3.854 3.10425 3.104C3.85425 2.354 4.73619 1.76039 5.75008 1.32317C6.76397 0.885948 7.8473 0.667059 9.00008 0.666504C10.1529 0.666504 11.2362 0.885393 12.2501 1.32317C13.264 1.76095 14.1459 2.35456 14.8959 3.104C15.6459 3.854 16.2398 4.73595 16.6776 5.74984C17.1154 6.76373 17.334 7.84706 17.3334 8.99984C17.3334 10.1526 17.1145 11.2359 16.6767 12.2498C16.239 13.2637 15.6454 14.1457 14.8959 14.8957C14.1459 15.6457 13.264 16.2396 12.2501 16.6773C11.2362 17.1151 10.1529 17.3337 9.00008 17.3332ZM9.00008 15.6665C10.8612 15.6665 12.4376 15.0207 13.7292 13.729C15.0209 12.4373 15.6667 10.8609 15.6667 8.99984C15.6667 7.13873 15.0209 5.56234 13.7292 4.27067C12.4376 2.979 10.8612 2.33317 9.00008 2.33317C7.13897 2.33317 5.56258 2.979 4.27091 4.27067C2.97925 5.56234 2.33341 7.13873 2.33341 8.99984C2.33341 10.8609 2.97925 12.4373 4.27091 13.729C5.56258 15.0207 7.13897 15.6665 9.00008 15.6665Z" fill="var(--color-text)"/>
                    </svg>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(bag, index) in bags">
                <!-- Bag Name -->
                <td><img :src="bag.icon" :alt="bag.name" :title="bag.name"> {{ bag.name }}</td>
                <!-- Profits/Bag -->
                <td class="gold">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(bag.profitPerBag)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                    
                </td>
                <!-- Currency Value -->
                <td class="gold">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(bag.currencyValue)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
                <!-- Other Currency Value -->
                <td 
                    v-if="otherCurrencyIcon"
                    class="gold"
                >
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(bag.otherCurrencyValue)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
                <!-- CTA to open details table -->
                <td 
                    class="cta" 
                    @click="
                        $emit('detailsToggle');
                        $emit('getPopulateBagDetails', bag);
                        rotate90(index, 'cta-arrow', ctaDetails);
                    "
                >
                    <span>
                        <svg 
                            class="cta-arrow"
                            :ref="el => ctaDetails[index] = el" 
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                            <title>Details</title>
                        </svg>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { ref, onMounted } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import { rotate90 } from '@/js/vue/composables/AnimateFunctions.js'
import { sortTable, setHoverBorder, toggleSortOrder, toggleActive } from '@/js/vue/composables/TableFunctions.js'


const props = defineProps({
    bags: Object, 
    currencyIcon: String,
    alt: String,
    otherCurrencyIcon: String,
    otherAlt: String,
})

const ctaDetails = ref([]);

const sortActive = ref([]), 
    sortOrder = ref([]);


onMounted(() => {
    if (props.bags){
        toggleActive(2, sortActive.value);
        sortOrder.value[2] = 'descending';
        sortTable('currency-table', 2, 'gold', sortOrder.value);
    }
})

</script>