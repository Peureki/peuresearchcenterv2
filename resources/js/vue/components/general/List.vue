<template>
    <!-- 
        * PRIMARY ITEM 
        * Display only on the first iteration, before any recursion so it can display at the top
    -->


    <div 
        v-if="recursionLevel == 0"
        class="primary-item"
    >
        <div class="checkbox">
            <input 
                type="checkbox" 
                :name="entry.name" 
                v-model="entry.checked"
                @change="checkSubBoxes(entry, entry.checked)">
                
            <label :for="entry.name">
                <img v-if="entry.icon" :src="entry.icon" :alt="entry.name" :title="entry.name">
                <p :class="checkFade(entry.checked)">{{ entry.count }} {{ entry.name }}</p>
            </label> 
        </div>
        

        <svg 
            class="expand" 
            :class="rotate"
            @click="expandOrShrink"
            width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg"
        >
            <path d="M8.81372 0.397634C8.6944 0.280464 8.5326 0.214642 8.36389 0.214642C8.19519 0.214642 8.03339 0.280464 7.91407 0.397634L4.76468 3.49138L1.61529 0.397634C1.49529 0.283785 1.33457 0.220788 1.16775 0.222212C1.00093 0.223636 0.841356 0.289367 0.723392 0.405247C0.605428 0.521127 0.538516 0.677885 0.537066 0.841758C0.535617 1.00563 0.599746 1.16351 0.715642 1.28138L4.31486 4.81701C4.43417 4.93418 4.59597 5 4.76468 5C4.93339 5 5.09519 4.93418 5.2145 4.81701L8.81372 1.28138C8.93299 1.16418 9 1.00524 9 0.839509C9 0.673781 8.93299 0.514838 8.81372 0.397634Z" fill="#FFD12C"/>
        </svg>

        <!--
            *
            * ADD SUB-CUSTOM ENTRY
            * Only show for custom entries, not recipe entries
        -->
        <svg 
            class="plus" 
            @click="subEntryToggle = !subEntryToggle"
            width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
        >
            <path d="M14 7.99805H8V13.998H6V7.99805H0V5.99805H6V-0.00195312H8V5.99805H14V7.99805Z" fill="#FFD12C"/>
        </svg>
        <!-- <form v-if="subEntryToggle" @submit.prevent="addCustomEntry(subEntryNumber, subEntryInput)">
            <input
                class="small-number-field"
                type="number"
                min="0"
                v-model="subEntryNumber"
            >
            <input
                type="text"
                placeholder="Ingredient"
                v-model="subEntryInput"
            >
            <button class="submit" type="submit">Add Ingredient</button>
        </form> -->
        <!--
            *
            * POP ENTRY
            *
        -->
        <svg 
            class="close" 
            @click="$emit('popEntry', entryIndex)"
            width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
        >
            <path d="M13 1L1 13M1 1L13 13" stroke="#FFD12C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <SearchItem
        v-if="subEntryToggle"
        @handle-item-search="handleItemSearch"
    />

    <!--
        *
        * INGREDIENTS
        *
    -->
    <div 
        v-if="ingredientsToggle"
        v-for="(item, itemIndex) in entry.ingredients"
        class="item-container"
    >
        <div class="item">
            <div class="checkbox">
                <input 
                    type="checkbox" 
                    v-model="item.checked"
                    @change="checkSubBoxes(item, item.checked)"
                >
                
                <label :for="item.name">
                    <img v-if="item.icon" :src="item.icon" :alt="item.name" :title="item.name">
                    <p :class="checkFade(item.checked)">{{ item.count }} {{ item.name }}</p>
                </label>
            </div>

            <!--
                *
                * ADD SUB-CUSTOM INGREDIENT
                * Only show for custom entries, not recipe entries
            -->
            <svg 
                class="plus" 
                @click="item.toggle = !item.toggle"
                width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M14 7.99805H8V13.998H6V7.99805H0V5.99805H6V-0.00195312H8V5.99805H14V7.99805Z" fill="#FFD12C"/>
            </svg>

            <!--
                *
                * WIKI
                * Directly links to the wiki for this particular item
                * Ex: wiki.guildwars2.com/wiki/Shard_of_Endeavor
            -->

            <svg @click="wiki(item.name)" class="wiki" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 0C11.2311 0 8.52431 0.821086 6.22202 2.35943C3.91973 3.89777 2.12532 6.08427 1.06569 8.64243C0.00606596 11.2006 -0.271181 14.0155 0.269012 16.7313C0.809205 19.447 2.14258 21.9416 4.10051 23.8995C6.05845 25.8574 8.55301 27.1908 11.2687 27.731C13.9845 28.2712 16.7994 27.9939 19.3576 26.9343C21.9157 25.8747 24.1022 24.0803 25.6406 21.778C27.1789 19.4757 28 16.7689 28 14C28 10.287 26.525 6.72601 23.8995 4.1005C21.274 1.475 17.713 0 14 0ZM26 13H20C19.8833 9.31709 18.9291 5.70915 17.21 2.45C19.5786 3.0979 21.6914 4.45684 23.2632 6.34342C24.8351 8.23 25.7903 10.5534 26 13ZM14 26C13.7769 26.015 13.5531 26.015 13.33 26C11.2583 22.6962 10.1085 18.8981 10 15H18C17.9005 18.8953 16.7612 22.6932 14.7 26C14.467 26.0164 14.2331 26.0164 14 26ZM10 13C10.0995 9.10468 11.2388 5.30682 13.3 2C13.7453 1.94997 14.1947 1.94997 14.64 2C16.7223 5.3008 17.8825 9.09906 18 13H10ZM10.76 2.45C9.0513 5.71164 8.10746 9.31945 8.00001 13H2.00001C2.20971 10.5534 3.16495 8.23 4.7368 6.34342C6.30865 4.45684 8.42144 3.0979 10.79 2.45H10.76ZM2.05001 15H8.05001C8.15437 18.6798 9.09478 22.2875 10.8 25.55C8.43887 24.8951 6.33478 23.5332 4.77056 21.6472C3.20634 19.7612 2.25695 17.4415 2.05001 15ZM17.21 25.55C18.9291 22.2908 19.8833 18.6829 20 15H26C25.7903 17.4466 24.8351 19.77 23.2632 21.6566C21.6914 23.5432 19.5786 24.9021 17.21 25.55Z" fill="#FFD12C"/>
                <title>Wiki</title>
            </svg>

            <!-- <form v-if="item.toggle" @submit.prevent="addCustomIngredient(item, subIngredientNumber, subIngredientInput)">
                <input
                    class="small-number-field"
                    type="number"
                    min="0"
                    v-model="subIngredientNumber"
                >

                <input
                    type="text"
                    placeholder="Ingredient"
                    v-model="subIngredientInput"
                >
                <button class="submit" type="submit">Add Ingredient</button>
            </form> -->

            <!--
                *
                * POP ITEM
                *
            -->
            <svg 
                class="close" 
                @click="popItem(itemIndex)"
                width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M13 1L1 13M1 1L13 13" stroke="#FFD12C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <SearchItem
            v-if="item.toggle"
            @handle-item-search="(searchQuery) => handleIngredientSearch(item, searchQuery)"
        />

        <!--
            * IF the item contains more 'ingredients', start recursion
        -->
        <List
            v-if="item.ingredients"
            :entry="item"
            :entryIndex="entryIndex"
            :recursion-level="recursionLevel + 1"
        />
    </div>

    
</template>

<script setup>
import { computed, ref } from 'vue'
import { wiki } from '@/js/vue/composables/BasicFunctions'
import SearchItem from '@/js/vue/components/general/SearchItem.vue'
import Expand from '@/imgs/svgs/expand.svg'

const props = defineProps({
    quantity: Number,
    entry: Object,
    entryIndex: Number,
    recursionLevel: {
        type: Number,
        default: 0,
    },
})
const emit = defineEmits(['popEntry', 'addCustomIngredient']);

const subEntryToggle = ref(false),
    subEntryInput = ref(null),
    subEntryNumber = ref(1),
    subIngredientInput = ref(null),
    subIngredientNumber = ref(1);

const ingredientsToggle = ref(props.recursionLevel == 0 ? false : true);

const handleCustomIngredient = () => {
    emit('addCustomIngredient', subEntryInput.value, props.entryIndex);
    ingredientsToggle.value = true; 
}

const handleItemSearch = (searchQuery) => {
    if (!props.entry.ingredients){
        props.entry.ingredients = [];
    }
    props.entry.ingredients.push(searchQuery);
    ingredientsToggle.value = true;
}
const handleIngredientSearch = (item, searchQuery) => {
    if (!item.ingredients){
        item.ingredients = [];
    }
    item.ingredients.push(searchQuery);
}

const addCustomEntry = (count, entry) => {
    if (!props.entry.ingredients){
        props.entry.ingredients = [];
    }

    props.entry.ingredients.push({
        count: count != 0 ? count : null,
        name: entry
    })

    ingredientsToggle.value = true;
}

const addCustomIngredient = (item, count, ingredients) => {
    if (!item.ingredients){
        item.ingredients = [];
    }

    item.ingredients.push({
        count: count != 0 ? count : null,
        name: ingredients
    });
}

const popItem = (itemIndex) => {
    props.entry.ingredients.splice(itemIndex, 1);
}


const expandOrShrink = () => {
    ingredientsToggle.value = !ingredientsToggle.value; 
}

const checkSubBoxes = (data, isChecked) => {
    //console.log('checked data: ', data, isChecked);
    data.checked = isChecked;
    if (data.ingredients){
        data.ingredients.forEach(subItem => {
            //console.log('subItems: ', subItem);
            subItem.checked = isChecked;
            checkSubBoxes(subItem, isChecked);
        });
        //console.log('data ingredients: ', data.ingredients);
    }
}


/*
    *
    * DYNAMIC CLASSES
    * 
*/
const rotate = computed(() => {
    return ingredientsToggle.value == true ? '' : 'rotate';
})
const checkFade = (checkStatus) => {
    return checkStatus === true ? 'strikethrough' : '';
}

</script>

<style scoped>
.checkbox label {
    cursor: unset;
}

.item-container{
    padding: 0px 5px 0px 30px;
    border-left: var(--border-general);
}
.primary-item{
    display: flex;
    align-items: center;
    gap: var(--gap-general);
    padding-bottom: var(--gap-general);
}
.item{
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 5px;
}
.primary-item img,
.item img{
    width: var(--img-material-w);
}
.rotate {
    transform: rotate(180deg);
}

</style>