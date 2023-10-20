export function sortTable(table, column, setting){
    let rows, switching, i, x, y, shouldSwitch; 
    let xSpan, ySpan; 
    let xNum, yNum;

    switching = true; 

    while(switching){
        switching = false; 
        rows = table.rows; 

        for (i = 2; i < rows.length - 1; i++){
            shouldSwitch = false; 

            x = rows[i].getElementsByTagName('td')[column];
            y = rows[i + 1].getElementsByTagName('td')[column];

            if (setting == 'alphabet'){
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()){
                    shouldSwitch = true;
                    break;
                }
            }
            if (setting == 'gold'){
                // Make sure to zero out xNum, yNum otherwise the += will keep adding onto the exisiting numbers from the prev iteration
                xNum = 0;
                yNum = 0;
                // 1. Since gold is displayed in <span> tags with the imgs, get the span
                // 2. For each span, get the num (the only thing in text form) from the span
                // 3. From there, concat each num and parse to form the numerical gold amount
                xSpan = x.querySelectorAll('span');
                xSpan.forEach((span) => {
                    xNum += span.textContent.toString(); 
                });

                ySpan = y.querySelectorAll('span');
                ySpan.forEach((span) => {
                    yNum += span.textContent.toString(); 
                });
                // Have to use replace because there's a leading 0 in all the strings
                // It also makes negative number work
                xNum = parseInt(xNum.replace(/^0+/, ""));
                yNum = parseInt(yNum.replace(/^0+/, ""));
                
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