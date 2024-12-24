<!--
    *
    * ITEM VALUE TABLE
    *
    * This table is specifically for showing an item's value
    *
    * Example
    * For fishing:
    * Chunk of Ancient Ambergris
    * Fish Jerky
    *
-->
<template>

    <div class="overflow-x">
        <table class="exchange-container">
            <thead>
                <tr>
                    <th class="table-header" colspan="100%"><h4>{{ title }}</h4></th>
                </tr>
                <tr>
                    <th><h4>Item</h4></th>
                    <th><h4>Buy</h4></th>
                    <th><h4>Sell</h4></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items">
                    <td>
                        <div class="img-and-label" id="result">
                            <img :src="item.icon" :alt="item.name" :title="item.name">
                            <p>{{ item.name }}</p>
                        </div>
                    </td>
                    <td>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label"
                                v-for="gold in formatValue(item.buy_price)"
                            >
                                <p>{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label"
                                v-for="gold in formatValue(item.sell_price)"
                            >
                                <p>{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
                            </span>
                        </span>
                    </td>
                </tr>  
            </tbody>
        </table>
    </div>
    

</template>

<script setup>

import { formatValue, positiveOrNegative } from '@/js/vue/composables/FormatFunctions.js'

const props = defineProps({
    title: String, 
    items: Array, 
})

</script>