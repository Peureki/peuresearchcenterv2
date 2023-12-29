<template>
    <!-- 
        *
        * PAGINATION BUTTON CONTAINER
        *
    -->
    <div class="page-button-container">
        <button @click="getPage(dataArray.value.first_page_url, dataArray)"> First </button>
        <button @click="getPage(dataArray.value.prev_page_url, dataArray)" class="page-button-prev"> 
            <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
            </svg>
        </button>

        <!-- 
            *
            * PAGE LIST BUTTONS
            * 
            * V-IFs to make highlighted page to move if the page number is at the start or at the end
            * This keeps the space and number of buttons the same so when you click the arrow keys, they don't move
        --> 

        <div 
            class="page-button-list"
            v-if="dataArray.value.current_page == 1"
        >
            <button class="page-button-current">{{ dataArray.value.current_page }}</button>
            <button @click="getPage(dataArray.value.next_page_url, dataArray)">{{ dataArray.value.current_page + 1 }}</button>
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page + 2].url, dataArray)">{{ dataArray.value.current_page + 2 }}</button>
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page + 3].url, dataArray)">{{ dataArray.value.current_page + 3 }}</button>
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page + 4].url, dataArray)">{{ dataArray.value.current_page + 4 }}</button>
        </div>

        <div 
            class="page-button-list"
            v-if="dataArray.value.current_page == 2"
        >
            <button @click="getPage(dataArray.value.prev_page_url, dataArray)">{{ dataArray.value.current_page - 1 }}</button>
            <button class="page-button-current">{{ dataArray.value.current_page }}</button>
            <button @click="getPage(dataArray.value.next_page_url, dataArray)">{{ dataArray.value.current_page + 1 }}</button>
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page + 2].url, dataArray)">{{ dataArray.value.current_page + 2 }}</button>
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page + 3].url, dataArray)">{{ dataArray.value.current_page + 3 }}</button>
        </div>

        <div 
            class="page-button-list"
            v-if="dataArray.value.current_page > 2 && dataArray.value.current_page < dataArray.value.last_page - 2"
        >
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page - 2].url, dataArray)">{{ dataArray.value.current_page - 2 }}</button>
            <button @click="getPage(dataArray.value.prev_page_url, dataArray)">{{ dataArray.value.current_page - 1 }}</button>
            <button class="page-button-current">{{ dataArray.value.current_page }}</button>
            <button @click="getPage(dataArray.value.next_page_url, dataArray)">{{ dataArray.value.current_page + 1 }}</button>
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page + 2].url, dataArray)">{{ dataArray.value.current_page + 2 }}</button>
        </div>

        <div 
            class="page-button-list"
            v-if="dataArray.value.current_page == dataArray.value.last_page - 2"
        >
        
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page - 2].url, dataArray)">{{ dataArray.value.current_page - 2 }}</button>
            <button @click="getPage(dataArray.value.prev_page_url, dataArray)">{{ dataArray.value.current_page - 1 }}</button>
            <button class="page-button-current">{{ dataArray.value.current_page }}</button>
            <button @click="getPage(dataArray.value.next_page_url, dataArray)">{{ dataArray.value.current_page + 1 }}</button>
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page + 2].url, dataArray)">{{ dataArray.value.current_page + 2 }}</button>
        </div>

        <div 
            class="page-button-list"
            v-if="dataArray.value.current_page == dataArray.value.last_page - 1"
        >
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page - 3].url, dataArray)">{{ dataArray.value.current_page - 3 }}</button>
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page - 2].url, dataArray)">{{ dataArray.value.current_page - 2 }}</button>
            <button @click="getPage(dataArray.value.prev_page_url, dataArray)">{{ dataArray.value.current_page - 1 }}</button>
            <button class="page-button-current">{{ dataArray.value.current_page }}</button>
            <button @click="getPage(dataArray.value.next_page_url, dataArray)">{{ dataArray.value.current_page + 1 }}</button>
        </div>

        <div 
            class="page-button-list"
            v-if="dataArray.value.current_page == dataArray.value.last_page"
        >
        <button @click="getPage(dataArray.value.links[dataArray.value.current_page - 4].url)">{{ dataArray.value.current_page - 4 }}</button>
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page - 3].url, dataArray)">{{ dataArray.value.current_page - 3 }}</button>
            <button @click="getPage(dataArray.value.links[dataArray.value.current_page - 2].url, dataArray)">{{ dataArray.value.current_page - 2 }}</button>
            <button @click="getPage(dataArray.value.prev_page_url, dataArray)">{{ dataArray.value.current_page - 1 }}</button>
            <button class="page-button-current">{{ dataArray.value.current_page }}</button>
        </div>

        <span> ... </span>
        <button @click="getPage(dataArray.value.last_page_url, dataArray)">{{ dataArray.value.last_page }}</button>

        <button @click="getPage(dataArray.value.next_page_url, dataArray)" class="page-button-next"> 
            <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
            </svg>
        </button>
        <button @click="$emit('getLastPage', dataArray.value.last_page_url, dataArray)"> Last </button>
    </div>
</template>

<script setup>
import { getPage } from '@/js/vue/composables/TableFunctions.js'

defineEmits(['getLastPage'])

const props = defineProps({
    dataArray: Object, 
})

console.log('data array: ', props.dataArray);

</script>