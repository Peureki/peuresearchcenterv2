<template>
    <button 
        v-if="toggleOption"
        @click="toggle = !toggle; setRegularToggleFilter(filterPropertyName, toggleOption)"
        :class="toggle ? 'active-button' : 'inactive-button'"
    > 
        {{ toggleOption }}
    </button>

    <button 
        v-if="toggleOptions" v-for="(filter, index) in toggleOptions" :key="index"
        :class="index === activeIndex ? 'active-button' : 'inactive-button'"
        @click="chooseActiveFilter(index); setRegularToggleFilter(filterPropertyName, filter)"
    >
        {{ filter }}
    </button>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { user, filters } from '@/js/vue/composables/Global'
import axios from 'axios';

const props = defineProps({
    // toggleOption w/o being plural means this component is for individual toggles
    toggleOption: String, 
    // w/ being plural means this component is for RADIO toggles (one at a time)
    toggleOptions: Object,
    filterPropertyName: String,
    // True => Radio toggles
    // False => Regular toggles
    radio: {
        type: Boolean,
        default: false,
    },
})

const toggle = ref(null); 

const activeIndex = ref(null);


// *
// * REGULAR TOGGLE FILTER FUNCTIONS
// *
// * These are for toggles that users can choose as little/many as they want
// * 

// * SET NEW REGULAR TOGGLE FILTER
const setRegularToggleFilter = (propertyName, filter) => {
    if (filters.value[propertyName]){
        // filterArray will be the replacement array 
        let filterArray = filters.value[propertyName];
        // Check if filter is in the array
        const index = filterArray.indexOf(filter); 
        
        switch (props.radio){
            case true: 
                // If filter exists, don't do anything
                if (index > -1){
                    return;
                // If filter does not exist => empty filter settings and add the new one
                } else {
                    filterArray = []; 
                    filterArray.push(filter);
                }
                break;

            default: 
                // If filter exists, remove filter from array
                if (index > -1){
                    filterArray.splice(index, 1); 
                // Otherwise add filter
                } else {
                    filterArray.push(filter);
                }
                break;
        }
        
        // Set new filter and update filters
        filters.value = {
            ...filters.value,
            [propertyName]: filterArray,
        }
        // Apply settings to user db
        if (user.value){     
            saveRegularToggleFilter(); 
        }
    }
}
// *
// * SAVE REGULAR TOGGLE FILTERS TO USER DATABASE
// * 
const saveRegularToggleFilter = async () => {
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
// *
const checkRegularToggleFilters = (option) => {
    try {
        // Check if the property exist in filter
        if (filters.value[props.filterPropertyName]){
            // True/false if the toggle option is already included or not
            const isIncluded = filters.value[props.filterPropertyName].some(array => array.includes(option));

            //console.log('Filters: ', filters.value, filters.value[props.filterPropertyName])

            if (isIncluded){
                //console.log('is included: ', isIncluded);
                toggle.value = true; 
            }
        }
    } catch (error){
        console.log(`Cannot find ${option} in Filters array. This might be due to not having a user auth`, error);
    }
}

// *
// * RADIO TOGGLE FILTER FUNCTIONS
// *
// * These are for toggles that users can only choose one at at time
// *
// * Conditions: props.radio == true
// *

// * 
// * CHECK RADIO FILTERS
// * Check user.filter properties to see if the filter has been already set
// * If yes => highlight the active index
// *
const checkRadioToggleFilters = () => {
    if (filters.value[props.filterPropertyName]){
        activeIndex.value = props.toggleOptions.indexOf(filters.value[props.filterPropertyName][0]);
    }
}
// * When users click on a different radio button, that button will be active instead of the others
const chooseActiveFilter = (index) => {
    activeIndex.value = index; 
}

onMounted(() => {
    if (props.toggleOption){
        checkRegularToggleFilters(props.toggleOption);
    }
    else if (props.toggleOptions){
        console.log('merp');
        checkRadioToggleFilters();
    }
    
})

</script>