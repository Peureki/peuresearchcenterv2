<template>
    <table>
        <thead>
            <tr>
                <th colspan="100%"><h4>Research Notes</h4></th>
            </tr>
            <tr>
                <th><h5>Name</h5></th>
                <th><h5>Total Cost</h5></th>
                <th><h5>Cost/Note</h5></th>
                <th><h5>Avg Output</h5></th>
                <th><h5>Recipe Tree</h5></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="notes in researchNotes">
                <td>{{ notes.name }}</td>
                <td class="gold">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(notes.crafting_value)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
                <td class="gold">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(notes.crafting_value/notes.avg_output)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
                <td>{{ notes.avg_output }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { onMounted, ref } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'

const researchNotes = ref(null); 

const getResearchNotes = async () => {
    try {
        const response = await fetch(`../api/currencies/research-note`);
        const responseData = await response.json();
        researchNotes.value = responseData;
    } catch (error){
        console.log('Error fetching data: ', error);
    }
}

onMounted(() => {
    getResearchNotes();
})



</script>