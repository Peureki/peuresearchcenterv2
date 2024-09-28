<template>
    <form @submit.prevent="$emit('addCustomEntry', quantity, entry)">
        <input
            class="small-number-field"
            type="number"
            min="0"
            placeholder="0"
            v-model="quantity"
        >
        <input
            type="text"
            placeholder="Become one with choya"
            v-model="entry"
        >
        <button class="submit" type="submit">Add Custom</button>
    </form>

</template>

<script setup>
import { ref } from 'vue'

const quantity = ref(null),
    entry = ref(null);

</script>