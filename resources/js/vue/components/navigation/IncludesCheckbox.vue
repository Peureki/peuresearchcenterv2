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

const props = defineProps({
    label: String, 
    icon: String,
    name: String, 
})

const checkboxToggle = ref(null); 

// * SET INCLUDES
// * This is for more Include checkboxes in the Settings tab
// * When a user checks/unchecks an Include, add/remove that setting in the localStorage Includes array
// * ie Salvageables
// * ie Ley Line Crystal
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

const checkIncludes = (name, includesArray) => {
    const isIncluded = includesArray.some(array => array.includes(name));
    if (isIncluded){
        checkboxToggle.value = true; 
    }
}

onMounted(() => {
    checkIncludes(props.name, JSON.parse(localStorage.getItem('includes'))); 
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