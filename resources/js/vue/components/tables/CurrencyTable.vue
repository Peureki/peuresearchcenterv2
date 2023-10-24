<template>
    <table 
        class="currency-details-table"
        v-if="tableToggle"   
    >
        <thead>
            <tr>
                <th colspan="100%"><h4>{{ bag.name }} Details</h4></th>
            </tr>
            <tr>
                <th @click="sortTable('currency-details-table', 0, 'string')"><h5>Name</h5></th>
                <th @click="sortTable('currency-details-table', 1, 'number')"><h5>Drop Rate</h5></th>
                <th @click="sortTable('currency-details-table', 2, 'gold')"><h5>Value</h5></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="mat in bagContent">
                <td><img :src="mat.icon" :alt="mat.name" :title="mat.name"> {{ mat.name }}</td>
                <td>{{ mat.dropRate }}</td>
                <td class="gold">
                    <span class="gold-label" v-for="gold in formatValue(mat.value)">
                        {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                    </span>
                </td>
            </tr>
            <tr class="row-offset">
                <td class="total" colspan="100%">
                    <span>Subtotal: </span>
                    <span class="float-right">
                        <span v-for="gold in formatValue(bag.bagSubValue)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>
            <tr class="row-offset">
                <td class="cost" colspan="100%">
                    <span>Cost per bag:</span>
                    <span class="float-right">
                        -<span v-for="gold in formatValue(bag.costPerBag)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>
            <tr class="row-offset">
                <td class="total" colspan="100%">
                    <span>Total per bag:</span>
                    <span class="float-right">
                        <span v-for="gold in formatValue(bag.bagValue)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>
            <tr class="row-offset">
                <td class="cost" colspan="100%">
                    <span>{{ currencyName }} per bag:</span>
                    <span class="float-right">
                        -{{ bag.currencyPerBag }}<img src="@/imgs/icons/Volatile_Magic.png" alt="Volatile Magic" title="Volatile Magic">
                    </span> 
                </td>
            </tr>
            <tr class="row-offset">
                <td class="total" colspan="100%">
                    <span>
                        Total per {{ currencyName }}
                        <img src="@/imgs/icons/Volatile_Magic.png" alt="Volatile Magic" title="Volatile Magic">:
                    </span>
                    <span class="float-right">
                        <span v-for="gold in formatValue(bag.currencyValue)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { ref, onMounted } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import { sortTable } from '@/js/vue/composables/SortFunctions.js'

const props = defineProps({
    tableName: Object,
    tableToggle: Boolean,
    currencyName: String,
    bag: Object,
    bagContent: Object,
})

const currencyDetails = ref(null);

</script>