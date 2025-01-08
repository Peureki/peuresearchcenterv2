<template>
    <Transition name="fade">
        <p class="small-subtitle" :style="{color: textColor}">{{ message }}</p>
    </Transition>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';

const props = defineProps({
    message: String,
    color: String,
    duration: Number,
    fade: {
        type: Boolean,
        default: false, 
    },
})


const textColor = computed(() => {
    switch (props.color){
        case 'Red':
        case 'Error':
            return `var(--color-down)`

        default: `var(--color-text-fade)`;
    }
})

</script>