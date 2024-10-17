import Gold from '@/imgs/icons/Gold.png'
import Silver from '@/imgs/icons/Silver.png'
import Copper from '@/imgs/icons/Copper.png'

import { favorites } from '@/js/vue/composables/Global'
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
    // Round values to remove long decimals
    // This also helps with the value.toString().length check properly
    value = Math.round(value);

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

export function formatPercentage(value){
    return `${parseFloat(value * 100).toFixed(2)}%`;
}

export function formatToMinutes(num){
    const minutes = Math.floor(num),
        decimal = num - minutes,
        seconds = Math.round(decimal * 60); 

    return `${minutes}m ${seconds}s`;
}

export function showRarityColor(rarity) {
    switch (rarity){
        case 'Junk': return `var(--color-rarity-junk)`;
        case 'Fine': return `var(--color-rarity-fine)`;
        case 'Masterwork': return `var(--color-rarity-masterwork)`;
        case 'Rare': return `var(--color-rarity-rare)`;
        case 'Exotic': return `var(--color-rarity-exotic)`;
        case 'Ascended': return `var(--color-rarity-ascended)`;
        case 'Legendary': return `var(--color-rarity-legendary)`;
    }
}
// *
// * CHECK LOCALSTORAGE FOR SPECIFIC ARRAY
// *
// * Use this function for ex: filters to find a specific filter in an array that is saved on the localStorage
export function checkLocalStorageArray(array, key) {
    const targetArray = JSON.parse(localStorage.getItem(array)); 
    if (targetArray.includes(key)){
        return true;
    } else {
        return false;
    }
}

export function getCSSVariable(variable){
    return getComputedStyle(document.documentElement).getPropertyValue(variable).trim(); 
}

// Format time from seconds
// Example 1hr, 30mins, 25seconds would be 01:30:25
export function formatTime (seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const secs = seconds % 60;

    // Remove hours if it's less than 60minutes
    if (hours > 0){
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    } else {
        return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }
};

export function formatStringToTime(decimalHours) {
    // Get the whole number of hours
    const hours = Math.floor(decimalHours);
    
    // Get the decimal part and convert it to minutes
    const decimalMinutes = (decimalHours - hours) * 60;
    const minutes = Math.floor(decimalMinutes);
    
    // Get the remaining decimal part and convert it to seconds
    const decimalSeconds = (decimalMinutes - minutes) * 60;
    const seconds = Math.floor(decimalSeconds);
  
    // Format as 0:00:00 (hours:minutes:seconds)
    return `${hours}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

export function formatToDecimal(number){
    return Math.round(number * 100) / 100;
}
// 
// CHECK IF FAVORITE
// Current for research notes, but will be adjusted later
// Checks any item matches the favorite's list
// 
// By default, .favorite is false
// If yes => .favorite = true
export const checkIfFavorite = (researchNotes) => {
    console.log(researchNotes);

    researchNotes.forEach(item => item.favorite = false);

    if (favorites.value){
        favorites.value.researchNotes.forEach(favorite => {
            // Match the ID from favorites to the focused array
            const matchedItem = researchNotes.find(item => item.id == favorite);
            if (matchedItem){
                matchedItem.favorite = true; 
            }
        })
    }
}
  