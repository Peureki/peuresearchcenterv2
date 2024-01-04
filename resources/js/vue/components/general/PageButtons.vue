<template>
    <!-- 
        *
        * PAGINATION BUTTON CONTAINER
        *
    -->
    <div class="page-button-container">
        <!-- 
            *
            * PAGE LIST BUTTONS
            * 
            * V-IFs to make highlighted page to move if the page number is at the start or at the end
            * This keeps the space and number of buttons the same so when you click the arrow keys, they don't move
        --> 

        <div class="page-button-list">
            <button 
                class="page-button-prev"
                @click="getPage(dataArray.value.prev_page_url, dataArray, loadingRef)"
            > 
                <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                </svg>
            </button>

            <button @click="getPage(dataArray.value.first_page_url, dataArray, loadingRef)"> First </button>

            <button class="page-button-current">{{ dataArray.value.current_page }}</button>
        </div>

        <span> / </span>
        <button @click="getPage(dataArray.value.last_page_url, dataArray, loadingRef)">{{ dataArray.value.last_page }}</button>
        <button @click="getPage(dataArray.value.last_page_url, dataArray, loadingRef)"> Last </button>
        <button @click="getPage(dataArray.value.next_page_url, dataArray, loadingRef)" class="page-button-next"> 
            <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
            </svg>
        </button>

        
        
        <!--
            *
            * INPUT SPECIFIC PAGE NUMBER
            *
        -->
        <input 
            class="specific-page"
            type="number" 
            placeholder="#"
            v-model="specificPageNum"
        >
        <!-- Get specific page via v-model -->
        <button @click="getPage(`${dataArray.value.path}?page=${specificPageNum}`, dataArray, loadingRef)">Go</button>

        <Loading v-if="loadingToggle" :width="25" :height="25"/>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { getPage } from '@/js/vue/composables/TableFunctions.js'

import Loading from '@/js/vue/components/general/Loading.vue'

const props = defineProps({
    dataArray: Object, 
})

// Loading choya initialization
const loadingToggle = ref(false),
    loadingRef = computed(() => loadingToggle); 
// Specific page v-model
const specificPageNum = ref(null);

</script>