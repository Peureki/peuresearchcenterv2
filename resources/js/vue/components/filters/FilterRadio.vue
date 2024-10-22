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
import { ref, onMounted, watch, nextTick } from 'vue'
import { filters, user } from '@/js/vue/composables/Global'
import axios from 'axios';
import { getAuthUser } from '@/js/vue/composables/Authentication';

const props = defineProps({
    toggleOptions: Object, 
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
    if (filters.value[props.filterPropertyName]){
        activeIndex.value = props.toggleOptions.indexOf(filters.value[props.filterPropertyName]);
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
        if (user.value){
            saveFilters(); 
        }
        
    }
}

const saveFilters = async () => {
    try {
        const response = await axios.post('../api/user/saveFilters', {
            filters: filters.value
        })

        if (response){
            console.log('Saved filters', filters.value);
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