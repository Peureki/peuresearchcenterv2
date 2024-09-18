<template>
    <div 
        class="checkbox" 
    >
        <input 
            v-model="checkboxToggle"
            @change="setIncludes(name, checkboxToggle)" 
            type="checkbox" 
            :name="label"
        >
        <label :for="label">
            <img v-if="icon" :src="icon" :alt="name" :title="name">
            <p>{{ name }}</p>
        </label>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { user } from '@/js/vue/composables/Global'
import axios from 'axios';

import { includes } from '@/js/vue/composables/Global'

const props = defineProps({
    label: String, 
    icon: String,
    name: String, 
})

const checkboxToggle = ref(null); 

// SET INCLUDES
// If the checked checkbox is in the Includes array and is true, then add it
// Otherwise remove it
const setIncludes = (name, toggle) => {
    // If includes != null
    if (includes.value){
        const index = includes.value.indexOf(name); 
        // If the name is in includes array
        if (index > -1){
            if (!toggle){
                includes.value.splice(index, 1); 
            }
        } 
        // If the name is not in the includes array
        else {
            if (toggle){
                includes.value.push(name); 
            }
        }
    } 
    // If includes.value == null
    else {
        // Add name 
        if (toggle){
            includes.value = [];
            includes.value.push(name)
        }
    }
    
}
// On load, check if the user's Includes array contains any of the checkboxes
// If yes => check them
// * REQUIRES user auth
const checkIncludes = (name) => {
    try {
        if (includes.value){
            const isIncluded = includes.value.some(array => array.includes(name));

            if (isIncluded){
                checkboxToggle.value = true; 
            }
        }
    } catch (error){
        console.log(`Cannot find ${name} in Includes array. This might be due to not having a user auth`, error);
    }
}

onMounted(() => {
    checkIncludes(props.name); 
})

</script>

<style scoped>
.checkbox label{
    cursor: unset;
}
.checkbox label:hover{
    color: var(--color-text);
}

</style>