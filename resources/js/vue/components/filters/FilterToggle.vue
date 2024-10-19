<template>
    <button 
        @click="toggle = !toggle; setFilter(filterPropertyName, toggleOption)"
        :class="toggle ? 'active-button' : 'inactive-button'"
    > 
        {{ toggleOption }}
    </button>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { user, filters } from '@/js/vue/composables/Global'
import axios from 'axios';

const props = defineProps({
    toggleOption: String, 
    filterPropertyName: String,
})

const toggle = ref(null); 

// SET NEW FILTER
const setFilter = (propertyName, filter) => {
    if (filters.value[propertyName]){
        // filterArray will be the replacement array 
        const filterArray = filters.value[propertyName];
        // Check if filter is in the array
        const index = filterArray.indexOf(filter); 

        // If filter exists, remove filter from array
        if (index > -1){
            filterArray.splice(index, 1); 
        // Otherwise add filter
        } else {
            filterArray.push(filter);
        }
        // Set new filter and update filters
        filters.value = {
            ...filters.value,
            [propertyName]: filterArray,
        }
        // Apply settings to user db
        if (user.value){     
            saveFilters(); 
        }
    }
}
// *
// * SAVE FILTERS TO USER DATABASE
// * 
const saveFilters = async () => {
    try {
        const response = await axios.post('../api/user/saveFilters', {
            filters: filters.value
        })

        if (response){
            console.log('Saved filters');
        }
    } catch (error){
        console.log('Could not save Filters: ', error);
    }
}
// *
// * CHECK FILTERS IF EXISTS
// * If exists => apply toggle 
const checkFilters = (option) => {
    try {
        // Check if the property exist in filter
        if (filters.value[props.filterPropertyName]){
            // True/false if the toggle option is already included or not
            const isIncluded = filters.value[props.filterPropertyName].some(array => array.includes(option));

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