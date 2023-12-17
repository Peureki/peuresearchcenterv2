<template>
    <table>
        <thead>
            <tr>
                <th colspan="100%"><h4>Research Notes</h4></th>
            </tr>
            <tr>
                <th><h5>Name</h5></th>
                <th><h5>Cost</h5></th>
                <th><h5>Profit/Note</h5></th>
                <th><h5>Recipe Tree</h5></th>
            </tr>
        </thead>
        <tbody>
            <tr>

            </tr>
        </tbody>
    </table>

    <p>{{ researchNotes }}</p>
</template>

<script setup>
import { onMounted, ref } from 'vue'

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