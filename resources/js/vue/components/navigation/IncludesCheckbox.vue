<template>
    <div 
        class="checkbox" 
    >
        <input 
            v-model="checkboxToggle"
            @change="$emit('setIncludes')" 
            type="checkbox" 
            :name="label"
        >
        <label :for="label">{{ name }}</label>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    label: String, 
    name: String, 
})

const checkboxToggle = ref(null); 

const setIncludes = (name, toggle) => {
    console.log('toggle: ', toggle);
    // Get the includes into a workable array
    let includes = JSON.parse(localStorage.getItem('includes'));
    // If checkbox is true
    if (toggle){
        // Check if there's already a Includes name
        if (!includes.includes(name)){
            includes.push(name);
        }
    } else {
        console.log('includes name: ', name);
        // Remove Includes name
        includes = includes.filter(setting => setting !== name); 
    }
    // Update localStorage
    localStorage.setItem('includes', JSON.stringify(includes));
}

</script>