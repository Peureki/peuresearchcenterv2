// export function toggleTooltip(e, div, text){
//     div.value.style.left = `${e.clientX}px`;
//     div.value.style.top = `${e.clientY}px`;
//     div.value.querySelector('p').innerHTML = text; 
// }

export function toggleTooltip(status){
    status.value = !status.value; 
    setTimeout(() => {
        status.value = !status.value;
    }, 300);
}