<template>
    <button 
        @click="toggle = !toggle; setIncludes(toggleOption, toggle)"
        :class="toggle ? 'active-button' : 'inactive-button'"
    >
        {{ toggleOption }}
    </button>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { user, includes, filterResearchNotes } from '@/js/vue/composables/Global'
import { getAuthUser } from '@/js/vue/composables/Authentication'

const props = defineProps({
    toggleOption: String, 
})

const toggle = ref(null);

// SET INCLUDES
// If the checked checkbox is in the Includes array and is true, then add it
// Otherwise remove it
const setIncludes = (name, toggle) => {
    // If includes != null
    if (filterResearchNotes.value){
        const index = filterResearchNotes.value.indexOf(name); 
        // If the name is in includes array
        if (index > -1){
            if (!toggle){
                filterResearchNotes.value.splice(index, 1); 
            }
        } 
        // If the name is not in the includes array
        else {
            if (toggle){
                filterResearchNotes.value.push(name); 
            }
        }
    } 
    // If filterResearchNotes.value == null
    else {
        // Add name 
        if (toggle){
            filterResearchNotes.value = [];
            filterResearchNotes.value.push(name)
        }
    }
    console.log(filterResearchNotes.value);
    
}

const checkFilters = (option) => {
    try {
        if (filterResearchNotes.value){
            const isIncluded = filterResearchNotes.value.some(array => array.includes(option));

            if (isIncluded){
                toggle.value = true; 
            }
        }
    } catch (error){
        console.log(`Cannot find ${option} in Filters array. This might be due to not having a user auth`, error);
    }
}

onMounted(() => {
    checkFilters(props.toggleOption);
})

</script>