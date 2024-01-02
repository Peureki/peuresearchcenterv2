export function addSingleQuantity(num){
    return num.value += 1;
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
        return {
            value: item.crafting_value,
            preference: "Crafting",
        };
    // Buy order settings
    } else if (localStorage.buyOrderSetting == "buy_price"){
        if (item.buy_price < item.crafting_value && item.buy_price != 0){
            return {
                value: item.buy_price,
                preference: "TP",
            };
        } else {
            return {
                value: item.crafting_value,
                preference: "Crafting",
            };
        }
    } else {
        if (item.sell_price < item.crafting_value && item.sell_price != 0){
            return {
                value: item.sell_price,
                preference: "TP",
            };
        } else {
            return {
                value: item.crafting_value,
                preference: "Crafting",
            };
        }
    }
}

// * 
// * REFRESH PAGE
// * 
// * Refresh without reloading
export function pageRefresh(router, route) {
    const currentPath = route.path; 
    router.replace({path: '/'}).then(() => {
        router.replace({path: currentPath});
    })
}