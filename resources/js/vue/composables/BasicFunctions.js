export function addSingleQuantity(num){
    return num.value += 1;
}

export function refreshPage(){
    location.reload();
}

export function convertToPercent(num){
    let percent = 0;
    if (num < 1){
        percent = `${parseFloat(((1 - num) * 100).toFixed(2))}%`;
    } else {
        percent = `${parseFloat((num * 100).toFixed(2))}%`;
    }
    
    console.log((1 - num))
    return percent; 
}
