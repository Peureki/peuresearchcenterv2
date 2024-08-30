<template>
    <!-- 
        * PRIMARY ITEM 
        * Display only on the first iteration, before any recursion so it can display at the top
    -->


    <div 
        v-if="recursionLevel == 0"
        class="primary-item"
    >
        <input 
            type="checkbox" 
            :name="entry.name" 
            v-model="entry.checked"
            @change="checkSubBoxes(checklist, entry.checked)">
        <img v-if="entry.icon" :src="entry.icon" :alt="entry.name" :title="entry.name">
        <p>{{ quantity }}</p>

        <label :for="entry.name">{{ entry.name }}</label>

        <!-- Expand/Hide ingredients -->
        <button @click="expandOrShrink">
            <img 
                :src="Expand" :alt="`Expand ${entry.name}`" :title="`Expand ${entry.name}`"
                :class="`expand ${rotate}`"
            >
        </button>

        <svg 
            v-if="!entry.id"
            class="plus" 
            width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
        >
            <path d="M14 7.99805H8V13.998H6V7.99805H0V5.99805H6V-0.00195312H8V5.99805H14V7.99805Z" fill="#FFD12C"/>
        </svg>

        <svg 
            class="close" 
            @click="$emit('popEntry', entryIndex)"
            width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
        >
            <path d="M13 1L1 13M1 1L13 13" stroke="#FFD12C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <div 
        v-if="ingredientsToggle"
        v-for="(item, index) in entry.ingredients"
        class="todo-item"
    >
        <div class="item">
            <input 
                type="checkbox" 
                v-model="item.checked"
                @change="checkSubBoxes(item, item.checked)"
            >
            <img :src="item.icon" :alt="item.name" :title="item.name">
            <p>{{ item.count }}</p>
            
            <label :for="item.name">{{ item.name }}</label>
        </div>

        <!--
            * IF the item contains more 'ingredients', start recursion
        -->
        <List
            v-if="item.ingredients"
            :entry="item"
            :recursionLevel="recursionLevel + 1"
        />
    </div>
</template>

<script setup>
import { computed, ref } from 'vue'
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

const emit = defineEmits(['popEntry']);


console.log('list data: ', props.entry);

const ingredientsToggle = ref(props.recursionLevel == 0 ? false : true);

const expandOrShrink = () => {
    ingredientsToggle.value = !ingredientsToggle.value; 
}

const checkSubBoxes = (data, isChecked) => {
    //console.log('checked data: ', data, isChecked);
    data.checked = isChecked;
    if (data.ingredients){
        data.ingredients.forEach(subItem => {
            console.log('subItems: ', subItem);
            subItem.checked = isChecked;
            checkSubBoxes(subItem, isChecked);
        });
        console.log('data ingredients: ', data.ingredients);
    }
}



const rotate = computed(() => {
    return ingredientsToggle.value == true ? '' : 'rotate';
})

</script>

<style scoped>

.todo-item{
    padding: 5px 5px 5px 50px;
    border-left: var(--border-general);
}
.primary-item{
    display: flex;
    align-items: center;
    gap: var(--gap-general);
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
button {
    background-color: unset;
}
.primary-item .expand{
    width: var(--svg-expand);
    transition: var(--transition-all-03s-ease);
    cursor: pointer;
}
.rotate {
    transform: rotate(180deg);
}

</style>