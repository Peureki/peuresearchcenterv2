<template>
    <main>
        <Header :page-name="mapName"/>

        <section class="content-container">
            <!--
                *
                * MAP CONTAINER
                *
            -->
            <slot name="nodeTrackerModal"></slot>


            <div class="map-container">
                <img :src="map" :alt="alt" :title="alt">
                <div v-for="(event, index) in events" :key="index">
                    <div
                        class="map-timer" 
                        :style="{top: event.top, left: event.left}"
                        v-show="event.toggleCheckbox.value" 
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
            <!--
                *
                * INFO CONTAINER
                *
            -->
            <div class="info-container">
                <div class="legend">
                    <h3>Legend</h3>
                    <span class="legend-item">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10V0H10V10H0Z" fill="#76E9E1"/>
                        </svg>
                        <p>Meta</p>
                    </span>

                    <span class="legend-item">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10V0H10V10H0Z" fill="#EC004D"/>
                        </svg>
                        <p>Event Overdue (beyond appox. maximum spawn time)</p>
                    </span>

                    <span class="legend-item">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10V0H10V10H0Z" fill="#5ED625"/>
                        </svg>
                        <p>Event Up (within avg spawn time until max)</p>
                    </span>

                    <span class="legend-item">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10V0H10V10H0Z" fill="#FFB64A"/>
                        </svg>
                        <p>Event Upcoming (within appox. minimum spawn time)</p>
                    </span>

                    <span class="legend-item">
                        <img src="@/imgs/icons/Active_Arrow.png" alt="Active arrow" title="Meta event that's currently active">
                        <p>Current Active Map Status</p>
                    </span>

                    <span class="legend-item">
                        <img src="@/imgs/icons/Event_Boss.png" alt="Event boss" title="Champ or boss">
                        <p>Champ or Boss</p>
                    </span>

                    <span class="legend-item">
                        <img src="@/imgs/icons/Event_Swords.png" alt="Event swords" title="Skirmish">
                        <p>Skirmish</p>
                    </span>

                    <span class="legend-item">
                        <img src="@/imgs/icons/Event_Shield.png" alt="Event shield" title="Escort or Defense">
                        <p>Escort or Defense</p>
                    </span>

                    <span class="legend-item">
                        <img src="@/imgs/icons/Event_Rally.png" alt="Event rally" title="Rally">
                        <p>Rally</p>
                    </span>

                    <span class="legend-item">
                        <svg width="10" height="13" viewBox="0 0 10 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0V13L10 6.5L0 0Z" fill="#FFD12C"/>
                        </svg>
                        <p>Start Timer</p>
                    </span>

                    <span class="legend-item">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 10V0H10V10H0Z" fill="#FFD12C"/>
                        </svg>
                        <p>Stop Timer</p>
                    </span>

                    <span class="legend-item">
                        <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.25 15.5C12.7334 15.5 14.1834 15.0601 15.4168 14.236C16.6501 13.4119 17.6114 12.2406 18.1791 10.8701C18.7468 9.49968 18.8953 7.99168 18.6059 6.53683C18.3165 5.08197 17.6022 3.7456 16.5533 2.6967C15.5044 1.64781 14.168 0.933503 12.7132 0.644114C11.2583 0.354725 9.75032 0.50325 8.37987 1.07091C7.00943 1.63856 5.83809 2.59986 5.01398 3.83323C4.18987 5.0666 3.75 6.51664 3.75 8V11.875L1.5 9.625L0.625 10.5L4.375 14.25L8.125 10.5L7.25 9.625L5 11.875V8C5 6.76387 5.36656 5.5555 6.05331 4.52769C6.74007 3.49988 7.71619 2.6988 8.85823 2.22576C10.0003 1.75271 11.2569 1.62894 12.4693 1.8701C13.6817 2.11125 14.7953 2.70651 15.6694 3.58059C16.5435 4.45466 17.1388 5.56831 17.3799 6.78069C17.6211 7.99307 17.4973 9.24974 17.0242 10.3918C16.5512 11.5338 15.7501 12.5099 14.7223 13.1967C13.6945 13.8834 12.4861 14.25 11.25 14.25V15.5Z" fill="#FFD12C"/>
                        </svg>
                        <p>Restart Timer</p>
                    </span>

                    <span class="legend-item">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.16675 13.1665H9.83341V8.1665H8.16675V13.1665ZM9.00008 6.49984C9.23619 6.49984 9.43425 6.41984 9.59425 6.25984C9.75425 6.09984 9.83397 5.90206 9.83341 5.6665C9.83341 5.43039 9.75341 5.23234 9.59341 5.07234C9.43341 4.91234 9.23564 4.83261 9.00008 4.83317C8.76397 4.83317 8.56591 4.91317 8.40591 5.07317C8.24591 5.23317 8.16619 5.43095 8.16675 5.6665C8.16675 5.90262 8.24675 6.10067 8.40675 6.26067C8.56675 6.42067 8.76453 6.50039 9.00008 6.49984ZM9.00008 17.3332C7.8473 17.3332 6.76397 17.1143 5.75008 16.6765C4.73619 16.2387 3.85425 15.6451 3.10425 14.8957C2.35425 14.1457 1.76064 13.2637 1.32341 12.2498C0.886193 11.2359 0.667304 10.1526 0.666748 8.99984C0.666748 7.84706 0.885637 6.76373 1.32341 5.74984C1.76119 4.73595 2.3548 3.854 3.10425 3.104C3.85425 2.354 4.73619 1.76039 5.75008 1.32317C6.76397 0.885948 7.8473 0.667059 9.00008 0.666504C10.1529 0.666504 11.2362 0.885393 12.2501 1.32317C13.264 1.76095 14.1459 2.35456 14.8959 3.104C15.6459 3.854 16.2398 4.73595 16.6776 5.74984C17.1154 6.76373 17.334 7.84706 17.3334 8.99984C17.3334 10.1526 17.1145 11.2359 16.6767 12.2498C16.239 13.2637 15.6454 14.1457 14.8959 14.8957C14.1459 15.6457 13.264 16.2396 12.2501 16.6773C11.2362 17.1151 10.1529 17.3337 9.00008 17.3332ZM9.00008 15.6665C10.8612 15.6665 12.4376 15.0207 13.7292 13.729C15.0209 12.4373 15.6667 10.8609 15.6667 8.99984C15.6667 7.13873 15.0209 5.56234 13.7292 4.27067C12.4376 2.979 10.8612 2.33317 9.00008 2.33317C7.13897 2.33317 5.56258 2.979 4.27091 4.27067C2.97925 5.56234 2.33341 7.13873 2.33341 8.99984C2.33341 10.8609 2.97925 12.4373 4.27091 13.729C5.56258 15.0207 7.13897 15.6665 9.00008 15.6665Z" fill="#FFD12C"/>
                        </svg>
                        <p>Event Info</p>
                    </span> 
                </div>

                <div class="info">
                    <h3>How This Works</h3>
                    <slot name="info"></slot>
                </div>
            </div>
        </section>
    </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'

import Header from '@/js/vue/components/general/Header.vue'

import TimerFunctions from '@/js/vue/components/timers/TimerFunctions.vue'
import { colorTimers } from '@/js/vue/composables/TimerFunctions';

const props = defineProps({
    mapName: String,
    map: String,
    alt: String,
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
    let eventContainers = timerContainer.querySelectorAll('.map-timer'),
        eventNames = timerContainer.querySelectorAll('.event-name'),
        eventTimes = timerContainer.querySelectorAll('.event-time');

    colorTimers(props.events, eventContainers, eventNames, eventTimes);
})

</script>

<style scoped>

.map-timer{
    position: absolute;
    background-color: var(--color-bkg);
    border: var(--border-general);
    transition: all 0.2s ease;
}
.map-timer article h6{
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
}
.icons img{
    width: 20px;
    height: 20px;
}
.map-container .hidden-timer{
    display: none;
}

.info-container{
    display: grid;
    grid-template-columns: 1fr 2fr;
}
.info, 
.legend{
    display: flex;
    flex-direction: column;
    gap: 5px;
    padding: var(--padding-general-10px);
    border-right: var(--border-general);
}
.legend svg{
    width: 15px;
    height: 15px;
}
.legend img{
    width: 20px;
    height: 20px;
}
.legend-item{
    display: flex;
    align-items: center;
    gap: 5px;
}
.legend-item p {
    white-space: nowrap;
}
.info :deep(.info-content){
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.info :deep(span){
    display: inline-block;
    padding: var(--padding-p-inline);
}
.info :deep(p span img){
    width: 20px;
    height: 20px;
    vertical-align: middle;
}
</style>