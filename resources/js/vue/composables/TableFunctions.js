import { nextTick, ref } from "vue";

// If user is hovering a specific header column, match the index to show the border effect
export function setHoverBorder(index, isHovering){
    return isHovering ? index : null;
}

export function sortTable(tableName, column, setting, orderChoice){
    let rows, switching, i, x, y, shouldSwitch; 
    let xSpan, ySpan; 
    let xNum, yNum;
    let order; 

    // IF statement for the case when there's a 'details' table in addition to a main table that needs to be sorted for every new data set of the same componet
    // Example: Unbound/Volatile magic tables -> details table for each container
    // 
    // If that's the case, then the sort parameter will be orderChoice == 'something' rather than sortArray[0]
    if (orderChoice == 'descending' || orderChoice == 'ascending'){
        order = orderChoice;
    } else {
        order = orderChoice[column];
    }

    let table = document.querySelector(`.${tableName}`);
    switching = true; 

    while(switching){
        switching = false; 
        // Removes rows that are "row-offset" from being counted. Example: totals/cost rows so they don't accidently get sorted
        rows = Array.from(table.rows).filter((row) => !row.classList.contains('row-offset'));

        for (i = 2; i < rows.length - 1; i++){
            shouldSwitch = false; 

            x = rows[i].getElementsByTagName('td')[column];
            y = rows[i + 1].getElementsByTagName('td')[column];

            // * FOR STRINGS
            // *
            // * Words, letters, alphabets, etc. This factors out an <img> if appliciable
            if (setting == 'string'){
                if (order == 'descending'){
                    if (x.textContent.toLowerCase() > y.textContent.toLowerCase()){
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (x.textContent.toLowerCase() < y.textContent.toLowerCase()){
                        shouldSwitch = true;
                        break;
                    }
                }
                
            }
            // * FOR NUMBERS
            // *
            // * 
            if (setting == 'number'){
                if (order == 'descending'){
                    if (parseInt(x.textContent) < parseInt(y.textContent)){
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (parseInt(x.textContent) > parseInt(y.textContent)){
                        shouldSwitch = true;
                        break;
                    }
                }
            }

            // * FOR GOLD
            // *
            // * Anything that deals with Gold (gold, silver, copper)
            if (setting == 'gold'){
                // Make sure to zero out xNum, yNum otherwise the += will keep adding onto the exisiting numbers from the prev iteration
                xNum = 0;
                yNum = 0;
                // 1. Since gold is displayed in <span> tags with the imgs, get the span
                // 2. For each span, get the num (the only thing in text form) from the span
                // 3. From there, concat each num and parse to form the numerical gold amount
                try {
                    xSpan = x.querySelectorAll('.gold-label');
                    ySpan = y.querySelectorAll('.gold-label');
                } catch (error){}
                
                xSpan.forEach((span) => {
                    xNum += span.textContent.toString(); 
                });
                
                ySpan.forEach((span) => {
                    yNum += span.textContent.toString(); 
                });
                
                // Have to use replace because there's a leading 0 in all the strings
                // It also makes negative number work
                xNum = parseInt(xNum.replace(/^0+/, ""));
                yNum = parseInt(yNum.replace(/^0+/, ""));

                // When the xNum or yNum (string) is 00, parsing and using the fancy tricks makes it NaN
                // This makes it 0 if NaN
                if (isNaN(xNum))
                    xNum = 0;
                if (isNaN(yNum))
                    yNum = 0;     
                
                if (order == 'descending'){
                    if (xNum < yNum){
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (xNum > yNum){
                        shouldSwitch = true;
                        break;
                    }
                }
                
            }   
        }
        if (shouldSwitch){
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

// Send a request to get VM
// use the localStorage priceSetting and taxSetting as params 
export async function populateMainTable(url, ref){
    try {
        const response = await fetch(url);
        const responseData = await response.json(); 
        ref.value = responseData;
        
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
export async function populateCurrencyDetails(bag, refBag, sortDetails) {
    try{
        let response = await fetch(`../api/bags/${bag.dbName}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`);
        let responseData = await response.json(); 
        refBag.value = responseData; 

        await nextTick(() => {
            sortDetails();
        })
    
    } catch (error){
        console.log("Error fetching data: ", error);
    }
}

export async function fetchSpiritShards(refRecipes){
    try{
        let response = await fetch(`../api/currencies/spirit-shards/${localStorage.buyOrderSetting}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`);
        let responseData = await response.json();

        let index = 0;
        for (let key in responseData){
            if (responseData.hasOwnProperty(key)){
                refRecipes[index].recipes.value = responseData[key];
                index++;
            }
        }

    } catch (error){
        console.log("Error fetching data: ", error);
    }
}
// Check what table is currently being sorted
// colIndex => current active column
// refEl => the element or arrow that represents/highlights the current active column
export function toggleActive(colIndex, refEl){
    refEl.forEach((el => {
        el.classList.remove('active');
    }))
    refEl[colIndex].classList.add('active'); 
}
// Check what order the table is being sorted
// In the main sortTable func, one of the param is either 'descending' or 'ascending'
// This func allows the current table col to switch between the two if clicked again 
export function toggleSortOrder(colIndex, refEl){
    if (refEl[colIndex] == undefined){
        refEl[colIndex] = 'descending';
    } else {
        refEl[colIndex] = refEl[colIndex] == 'descending' ? 'ascending' : 'descending';
    }
}

export async function getPage(url, dataArray){
    try{
        console.log('get page: ', dataArray);
        const response = await fetch(url);
        const responseData = await response.json(); 
        dataArray.value = responseData;

    } catch (error) {
        console.log("Error fetching next page: ", error);
    }
}


