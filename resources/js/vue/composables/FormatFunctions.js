import Gold from '@/imgs/icons/Gold.png'
import Silver from '@/imgs/icons/Silver.png'
import Copper from '@/imgs/icons/Copper.png'
import { add } from 'lodash';
// FORMAT VALUES
// *
// *
// This is specifically for currencies and values that deal with gold
// Example: 12345 -> 1g 23s 45c (in images)
// *
// Returned as an array to easily use v-for 
export function formatValue(value){
    let formatArray = [],
        isNegative = false,
        isGold = false, // Conditions for silver 
        isSilver = false, // Conditions for copper
        silverIsZero = false; // Condition if, after handling gold, the leading numbers are 00 (ex: 10000)

    let addNegative = '', 
        addLeadingZero = '';

    if (value < 0){
        isNegative = true;
        value *= -1;
    }
    
    // Over 1g
    if (value >= 10000){
        isNegative ? addNegative = '-' : addNegative = '';

        formatArray.push({
            value: `${addNegative}${Math.floor(value/10000)}`,
            src: Gold,
            alt: "Gold",
        })
        isNegative = false;
        isGold = true;
        // Reduce value to only silver/copper (4 digits)
        value %= 10000;
        if (value < 100)
            silverIsZero = true;
    }
    // < 1g, > 99c, Silver
    if (value < 10000 && value >= 100 || silverIsZero == true){
        isNegative ? addNegative = '-' : addNegative = '';
        // Check if the silver is 3 digits (less than 10)
        if (isGold && value.toString().length == 3 || silverIsZero == true){ addLeadingZero = `0` }

        formatArray.push({
            value: `${addNegative}${addLeadingZero}${Math.floor(value/100)}`,
            src: Silver,
            alt: "Silver",
        })
        // Reset
        isNegative = false;
        addLeadingZero = '';
        isSilver = true;
        value %= 100;
    }
    // Copper
    if (value < 100){
        isNegative ? addNegative = '-' : addNegative = '';
        
        if (isSilver && value < 10){ addLeadingZero = `0` }

        formatArray.push({
            value: `${addNegative}${addLeadingZero}${Math.floor(value)}`,
            src: Copper,
            alt: "Copper",
        })
    }
    return formatArray; 
}