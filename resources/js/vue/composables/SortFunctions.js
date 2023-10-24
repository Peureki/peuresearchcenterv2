export function sortTable(tableName, column, setting){
    let rows, switching, i, x, y, shouldSwitch; 
    let xSpan, ySpan; 
    let xNum, yNum;
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
                if (x.textContent.toLowerCase() > y.textContent.toLowerCase()){
                    shouldSwitch = true;
                    break;
                }
            }
            // * FOR NUMBERS
            // *
            // * 
            if (setting == 'number'){
                if (parseInt(x.textContent) < parseInt(y.textContent)){
                    shouldSwitch = true;
                    break;
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
                
                if (xNum < yNum){
                    shouldSwitch = true;
                    break;
                }
            }
            
            
        }
        if (shouldSwitch){
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}