<template>
    <!--
        *
        * DISCLAIMER
        *
    -->
    <div class="disclaimer-container">
        <div class="img-and-label">
            <svg class="icon disclaimer" width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 19L11 0L22 19H0ZM3.45 17H18.55L11 4L3.45 17ZM11 16C11.2833 16 11.521 15.904 11.713 15.712C11.905 15.52 12.0007 15.2827 12 15C11.9993 14.7173 11.9033 14.48 11.712 14.288C11.5207 14.096 11.2833 14 11 14C10.7167 14 10.4793 14.096 10.288 14.288C10.0967 14.48 10.0007 14.7173 10 15C9.99933 15.2827 10.0953 15.5203 10.288 15.713C10.4807 15.9057 10.718 16.0013 11 16ZM10 13H12V8H10V13Z" :fill="color"/>
            </svg>

            <p>{{ message }}</p>
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    message: String,
    type: {
        type: String, 
        default: 'warning'
    },
})

const color = computed(() => {
    switch (props.type){
        case 'warning': return 'var(--color-disclaimer-warning)';
        case 'caution': return 'var(--color-disclaimer-caution)';
        default: return 'var(--color-disclaimer-warning)';
    }
})

</script>

<style scoped>
p {
    font-size: var(--font-size-subtext);
}

</style>