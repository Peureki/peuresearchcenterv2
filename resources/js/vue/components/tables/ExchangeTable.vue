<template>
    <div class="table-container">
        <table class="exchange-container">
            <thead>
                <tr>
                    <th class="table-header" colspan="100%"><h4>{{ title }}</h4></th>
                </tr>
                <tr>
                    <th><h4>Result</h4></th>
                    <th>
                        <svg class="icon" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-text)"/>
                        </svg>
                    </th>
                    <th><h4>Exchangeable</h4></th>
                    <th><h4>Value</h4></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="exchange in exchanges">
                    <td>
                        <div class="img-and-label" id="result">
                            <img :src="exchange.resultIcon" :alt="exchange.resultName" :title="exchange.resultName">
                            <p>{{ exchange.resultQty }}  {{ exchange.resultName }}</p>
                        </div>
                    </td>
                    <td>
                        <svg class="icon" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-text)"/>
                        </svg>
                    </td>
                    <td>
                        <div class="img-and-label" id="exchangeable">
                            <img :src="exchange.exchangeableIcon" :alt="exchange.exchangeableName" :title="exchange.exchangeableName">
                            <p>{{ exchange.exchangeableQty }} {{ exchange.exchangeableName }}</p>
                        </div>
                    </td>
                    <td>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label"
                                v-for="gold in formatValue(exchange.exchangeValue)"
                            >
                                <p :style="{color: positiveOrNegative(exchange.exchangeValue)}">{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
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
    exchanges: Array, 
})

</script>
