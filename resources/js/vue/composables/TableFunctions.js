import { nextTick, ref } from "vue";

// Send a request to get VM
// use the localStorage priceSetting and taxSetting as params 
export async function populateMainTable(url, ref, sortFunction){
    try {
        const response = await fetch(url);
        const responseData = await response.json(); 
        ref.value = responseData;
        
        await nextTick(() => {
            sortFunction(); 
        });
        
    } catch (error) {
        console.log('Error fetching data: ', error);
    }
}

// * IF this function is called within the HTML, you need to call it from a function within that component
// For example: 
// @click="getPopulateDetails(shipment.name); 
// 
// Then in <script setup> 
// const getPopulateDetails = (name) => {
//     populateDetails(name, bags, detailsName, detailsTotal, sortDetails); 
// }
// 
// This is because the ref variables aren't reactive when called from within the HTML??
export async function populateCurrencyDetails(bag, refBag, sortFunction) {
    try{
        let response = await fetch(`../api/bags/${bag.dbName}/${localStorage.priceSetting}/${localStorage.taxSetting}`);
        let responseData = await response.json(); 
        refBag.value = responseData; 

        // // Get total
        // refBags.value.forEach((item) => {
        //     refTotal.value += item.value; 
        // })
        // // Return cost per bag 
        // refTotal.value -= bag.costPerBag; 
        // // retrun currency value per bag
        // refCurrency.value = bag.currencyValue; 
        
        await nextTick(() => {
            sortFunction();
        })

    } catch (error){
        console.log("Error fetching data: ", error);
    }
}
