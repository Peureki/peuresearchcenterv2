<template>
    <div 
        class="modal"
        v-if="nodeTrackerModalToggle"    
    >
        <h3>Node Tracker</h3>
        <div 
            class="node"
            v-for="node in nodes" :key="node.name"
        >
            <span class="node-name">
                <img :src="node.src" :alt="node.name" :title="node.name">
                <p>{{ node.name }}</p>
            </span>
            <span class="node-quantity">
                <p>{{ node.quantity }}</p>
                <button @click="addSingleQuantity(node.quantity)">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0002 6.83317H7.00016V11.8332H5.3335V6.83317H0.333496V5.1665H5.3335V0.166504H7.00016V5.1665H12.0002V6.83317Z" fill="#FFD12C"/>
                    </svg>
                </button>
            </span>
            
        </div>
    </div>
</template>

<script setup>
import { inject } from 'vue'

import { nodeTrackerModalToggle } from '@/js/vue/composables/Global'

import { addSingleQuantity } from '@/js/vue/composables/BasicFunctions.js'

const props = defineProps({
    nodes: Object,
})

</script>

<style scoped>

.modal{
    position: absolute;
    background-color: var(--color-bkg);
    border: var(--border-general);
    z-index: 100000;
}
.modal h3{
    padding: var(--padding-general-10px);
}
.modal img{
    width: 25px;
    height: 25px;
}
.node{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    padding: var(--padding-general-10px);
}
.node-name{
    display: flex;
    align-items: center;
    gap: 10px;
}
.node-quantity{
    display: flex;
    align-items: center;
    gap: 10px;
}
.node-quantity button{
    background-color: var(--color-bkg);
    border: var(--border-button-link);
    padding: var(--padding-button);
    cursor: pointer;
    transition: var(--transition-all-03s-ease);
}
.node-quantity button:hover{
    background-color: var(--color-link);
}
.node-quantity button:hover svg path{
    fill: var(--color-black);
}
.node-quantity button svg{
    width: 16px;
    height: 16px;
    vertical-align: middle;
}


</style>