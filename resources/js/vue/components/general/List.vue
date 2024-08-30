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
            :name="checklist.name" 
            v-model="checklist.checked"
            @change="checkSubBoxes(checklist, checklist.checked)">
        <img :src="checklist.icon" :alt="checklist.name" :title="checklist.name">
        <p>{{ quantity }}</p>

        <label :for="checklist.name">{{ checklist.name }}</label>

        <!-- Expand/Hide ingredients -->
        <button @click="expandOrShrink">
            <img 
                :src="Expand" :alt="`Expand ${checklist.name}`" :title="`Expand ${checklist.name}`"
                :class="`expand ${rotate}`"
            >
        </button>
    </div>

    <div 
        v-if="ingredientsToggle"
        v-for="(item, index) in checklist.ingredients"
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
            :checklist="item"
            :recursionLevel="recursionLevel + 1"
        />
    </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import Expand from '@/imgs/svgs/expand.svg'

const props = defineProps({
    quantity: Number,
    checklist: Object,
    recursionLevel: {
        type: Number,
        default: 0,
    },
})


console.log('list data: ', props.checklist);

const ingredientsToggle = ref(true);

const expandOrShrink = () => {
    // const className = name.split(' ').join('-')
    // const items = document.querySelectorAll(`.todo-item.${className}`);
    // console.log(items);
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
    gap: 10px;
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