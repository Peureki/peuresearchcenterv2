<template>
    <button 
        v-for="(filter, index) in toggleOptions" :key="index"
        :class="index === activeIndex ? 'active-button' : 'inactive-button'"
        @click="chooseActiveFilter(index)"
    > 
        {{ filter }}
    </button>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { filters } from '@/js/vue/composables/Global'
import axios from 'axios';

const props = defineProps({
    toggleOptions: Object, 
    filterProperty: String,
    filterPropertyName: String,
})

// Whatever number gets in this ref, that index becomes an active button
// Ex: activeIndex.value = 1
// toggleOptions = ['Merp', 'Derp'] => 'Derp' will be active
const activeIndex = ref(null); 

const chooseActiveFilter = (index) => {
    activeIndex.value = index; 
}
// Check if filters has desired property
// Ex: showGlyphs
const checkFilters = () => {
    try {
        if (props.filterProperty){
            // Set active index to show which filter option is active
            activeIndex.value = props.toggleOptions.indexOf(props.filterProperty);
        }
    } catch (error){
        console.log('Cannot find filter property', error);
    }
}

// SET NEW FILTER
const setFilters = (propertyName, filter) => {
    if (filters.value[propertyName]){
        // Set new filter and update filters
        filters.value = {
            ...filters.value,
            [propertyName]: filter
        }
        saveFilters(); 
    }
}

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

onMounted(() => {
    checkFilters();
})

watch(activeIndex, (newActiveIndex) => {
    // Explictly !== null and undefined because index 0 is considered false
    if (newActiveIndex !== null && newActiveIndex !== undefined){
        setFilters(
            props.filterPropertyName,
            props.toggleOptions[newActiveIndex]
        ); 
    }
})


</script>