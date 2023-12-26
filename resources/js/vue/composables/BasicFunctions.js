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

// Use for determining which values to use, TP or crafting
// Ex: Research notes, which is better choice
export function compareBuyOrderAndCraftingValues(item){
    // If no TP prices or could be sold to the TP
    if ((item.buy_price == 0 && item.sell_price == 0) || (item.buy_price == null || item.sell_price == null)){
        return item.crafting_value;
    // Buy order settings
    } else if (localStorage.buyOrderSetting == "buy_price"){
        if (item.buy_price < item.crafting_value && item.buy_price != 0){
            return item.buy_price; 
        } else {
            return item.crafting_value;
        }
    } else {
        if (item.sell_price < item.crafting_value && item.sell_price != 0){
            return item.sell_price;
        } else {
            return item.crafting_value; 
        }
    }
}