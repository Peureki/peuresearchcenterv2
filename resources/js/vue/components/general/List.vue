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