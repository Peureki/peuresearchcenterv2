export function addSingleQuantity(num){
    return num.value += 1;
}

export function refreshPage(){
    location.reload();
}

export function convertTaxToPercent(num){
    let percent = 0;
    if (num < 1){
        percent = `${parseFloat(((1 - num) * 100).toFixed(2))}%`;
    } else if (num == 1) {
        percent = `${0}%`;
    } else {
        percent = `${Math.abs(parseFloat(((1 - num) * 100).toFixed(2)))}%`;
    }
    return percent; 
}
