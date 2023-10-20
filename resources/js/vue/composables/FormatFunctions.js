import Gold from '@/imgs/icons/Gold.png'
import Silver from '@/imgs/icons/Silver.png'
import Copper from '@/imgs/icons/Copper.png'
// FORMAT VALUES
// *
// *
// This is specifically for currencies and values that deal with gold
// Example: 12345 -> 1g 23s 45c (in images)
// *
// Returned as an array to easily use v-for 
export function formatValue(value){
    let formatArray = [];
    // Over 1g
    if (value >= 10000){
        formatArray.push({
            value: Math.floor(value/10000),
            src: Gold,
            alt: "Gold",
        })
        // Reduce value to only silver/copper (4 digits)
        value %= 10000;
    }
    // < 1g, > 99c, Silver
    if (value < 10000 && value >= 100){
        formatArray.push({
            value: Math.floor(value/100),
            src: Silver,
            alt: "Silver",
        })
        value %= 100;
    }
    // Copper
    if (value < 100){
        formatArray.push({
            value: Math.floor(value),
            src: Copper,
            alt: "Copper",
        })
    }
    return formatArray; 
}