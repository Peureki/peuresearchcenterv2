export function formatValue(value){
    const finalFormat = ``,
        goldFormat = ``,
        silverFormat = ``,
        copperFormat = ``;

    //console.log(value);

    if (value >= 10000){
        console.log(value/10000);
    }

    finalFormat = goldFormat + silverFormat + copperFormat; 

    return finalFormat; 
}