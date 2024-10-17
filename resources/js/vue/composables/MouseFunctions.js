// export function toggleTooltip(e, div, text){
//     div.value.style.left = `${e.clientX}px`;
//     div.value.style.top = `${e.clientY}px`;
//     div.value.querySelector('p').innerHTML = text; 
// }
import { ref } from 'vue'

export function toggleTooltip(status){
    status.value = !status.value; 
    setTimeout(() => {
        status.value = !status.value;
    }, 300);
}

// Show the cursor tooltip by proving the x, y coords and a toggle
// To make this work, @click needs to have a (e) callback (if multiple funcs in the @click)
// Ex: @click="(e) => {copyWaypoint(`${link}`); showTooltip(e)}">{{ link }}</span>
// 
// COPY BELOW 
// 
// import CursorTooltip from '@/js/vue/components/general/CursorTooltip.vue';
// // Initilize tooltip vars
// const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 
export const handleCursorTooltip = () => {
    const mouseX  = ref(0),
        mouseY = ref(0),
        tooltipToggle = ref(false); 

    const showTooltip = (e) => {
        mouseX.value = e.clientX - 50;
        mouseY.value = e.clientY - 50;

        tooltipToggle.value = true; 
        setTimeout(() => {
            tooltipToggle.value = false; 
        }, 500)
    }

    return {
        mouseX, mouseY, tooltipToggle, showTooltip,
    }

}