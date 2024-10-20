// This page is to keep track global variable states
import { ref, watch } from 'vue'
import { getAuthUser } from './Authentication';


export const nodeTrackerModalToggle = ref(false);

// USER AUTH
export const user = ref(null);
export const loginToggle = ref(null);
export const isAuthenticating = ref(true);

export const theme = ref(null); 

// TYRIAN AND CANTHAN TIME PEROIDS
// Used for the navigation and Fishing benchmarks
export const tyrianCurrentPeriod = ref(null);
export const tyrianTimeTilNext = ref(null); 
export const canthanCurrentPeriod = ref(null);
export const canthanTimeTilNext = ref(null);
// CHECK IF SCREEN IS MOBILE
export const isMobile = ref(window.innerWidth < 786);
export const mainNavToggle = ref(isMobile ? false : true);
export const mobileHamburger = ref(isMobile ? true : false);

// SHORTCUT TOGGLES
export const settingsToggle = ref(false),
    filtersToggle = ref(false),
    bookmarksToggle = ref(false),
    apiKeyToggle = ref(false);

// SETTINGS
// DEFAULTS
// These settings will be these settings every page refresh unless: user is logged in and has saved settings
export const buyOrder = ref('buy_price');
export const sellOrder = ref('sell_price');
export const tax = ref(0.85);
export const includes = ref([]);
export const favorites = ref([]);
export const checklist = ref([]);
export const filterResearchNotes = ref(["Crafting","TP","Armorsmith","Artificer","Chef","Huntsman","Jeweler","Leatherworker","Scribe","Tailor","Weaponsmith","Consumable","Armor","Weapon","Back","Trinket"]);
export const filters = ref({
    showGlyph: 'All', 
    toggleGlyphLevels: ['All', '1-15', '16-40', '41-55', '56-70', '71-80'],
    toggleGlyphTypes: ['Ore', 'Log', 'Plant'],
    toggleNodeTypes: ['Ore', 'Log', 'Plant'],
})
// MAKE THIS 'TRUE' IN FUNCTIONS THAT ALTER THE SETTINGS TO TRIGGER A REFRESH OF DATA ON PAGES
export const refreshSettings = ref(false);
export const refreshFavorites = ref(false); 

// // UPDATE settings when user has logged on or off
// watch(user, (userData) => {
//     if (userData){
//         buyOrder.value = userData.settings_buy_order;
//         sellOrder.value = userData.settings_sell_order;
//         tax.value = userData.settings_tax; 
//         includes.value = userData.includes;
//         filterResearchNotes.value = userData.filter_research_notes;
//         filters.value = userData.filters; 

//         console.log('when does this happen')
//         // APPLY DEFAULT FILTERS if property doesn't exist in the user's database
//         // This should only be the case for new users or people who do not have any filter settings filled yet
//         // if (!userData.filters){
//         //     userData.filters = filters.value; 
//         // }
//     }
    
// })