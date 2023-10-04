<template>
    <main>
        <header>
            <h1>Tangled Depths Timers</h1>
        </header>

        <section class="content-container">
            <div class="intro">
                <slot name="intro"></slot>
            </div>

            <div class="legend">
                <slot name="legend"></slot>
            </div>

            <div class="map-container">
                <img src="@/imgs/maps/Tangled_Depths.jpg" alt="Tangled Depths map with timers">
                <div v-for="(event, index) in events" :key="index">
                    <div
                        class="timer" 
                        :style="{top: event.top, left: event.left}"
                        v-show="store.toggleEvent[index].status" 
                    >
                        <article>
                            <h6 class="event-name">{{ event.name }}</h6>
                            <div class="icons">
                                <img 
                                    :src="chain.img" :alt="chain.type" :title="chain.type"
                                    v-for="chain in event.chain"
                                >
                            </div>
                        </article>
                        <TimerFunctions
                            :event="event"
                            :index="index"
                        />
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'

import TimerFunctions from '@/js/vue/components/timers/TimerFunctions.vue'
import { colorTimers, store } from '@/js/vue/composables/TimerFunctions';

const props = defineProps({
    events: Object,
})

onMounted(() => {
    let scrollContainer = document.querySelector('.map-container'),
        isScrolling = false,
        startX, scrollLeft;


    scrollContainer.addEventListener('mousedown', (e) => {
        isScrolling = true;
        scrollContainer.style.cursor = 'grabbing';
        startX = e.pageX - scrollContainer.offsetLeft;
        scrollLeft = scrollContainer.scrollLeft;
    });

    scrollContainer.addEventListener('mouseup', () => {
        isScrolling = false;
        scrollContainer.style.cursor = 'grab';
    });

    scrollContainer.addEventListener('mouseleave', () => {
        isScrolling = false;
        scrollContainer.style.cursor = 'grab';
    });

    scrollContainer.addEventListener('mousemove', (e) => {
        if (!isScrolling) return;
        e.preventDefault();
        const x = e.pageX - scrollContainer.offsetLeft;
        const walk = (x - startX) * 1.5; // Adjust the multiplier for faster or slower scrolling
        scrollContainer.scrollLeft = scrollLeft - walk;
    });

    let timerContainer = document.querySelector('.content-container');
    let eventContainers = timerContainer.querySelectorAll('.timer'),
        eventNames = timerContainer.querySelectorAll('.event-name'),
        eventTimes = timerContainer.querySelectorAll('.event-time');

    colorTimers(props.events, eventContainers, eventNames, eventTimes);
})

</script>

<style scoped>

.timer{
    position: absolute;
    background-color: var(--color-bkg);
    border: var(--border-general);
    transition: all 0.2s ease;
}
.timer article h6{
    white-space: nowrap;
}
.map-container{
    position: relative;
    overflow-x: auto;
    overflow-y: hidden;
    cursor: grab;
}
.map-container img{
    width: var(--img-timer-map-w);
}
.map-container article{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    padding: var(--padding-timers);
}
.map-container svg{
    cursor: pointer;
}
.icons{
    display: flex;
    align-items: center;

    gap: 5px;
}
.icons img{
    width: 20px;
    height: 20px;
}
.map-container .hidden-timer{
    display: none;
}
</style>