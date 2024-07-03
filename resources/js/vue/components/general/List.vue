<template>
    <!-- 
        * PRIMARY ITEM 
        * Display only on the first iteration, before any recursion so it can display at the top
    -->
    <div 
        v-if="recursionLevel == 0"
        class="primary-item"
    >
        <input type="checkbox" :name="requestedItem.name">
        <img :src="requestedItem.icon" :alt="requestedItem.name" :title="requestedItem.name">
        <p>{{ quantity }}</p>

        <label :for="requestedItem.name">{{ requestedItem.name }}</label>

        <!-- Expand/Hide ingredients -->
        <button @click="expandOrShrink">
            <img 
                :src="Expand" :alt="`Expand ${requestedItem.name}`" :title="`Expand ${requestedItem.name}`"
                :class="`expand ${rotate}`"
            >
        </button>
        
    </div>

    <div 
        v-if="ingredientsToggle"
        v-for="(item, index) in data.ingredients"
        :class="`todo-item ` + requestedItem.name.split(' ').join('-')"
    >
        <div class="item">
            <input 
                type="checkbox" 
                :name="checkboxName(data.name, item.id)" 
                @change="checkSubBoxes(checkboxName(data.name, item.id))"
            >
            <img :src="item.icon" :alt="item.name" :title="item.name">
            <p>{{ item.count }}</p>
            
            <label :for="checkboxName(data.name, item.id)">{{ item.name }}</label>
        </div>

        <!--
            * IF the item contains more 'ingredients', start recursion
        -->
        <List
            v-if="item.ingredients"
            :data="item"
            :requested-item="requestedItem"
            :recursionLevel="recursionLevel + 1"
        />
        
    </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import Expand from '@/imgs/svgs/expand.svg'

const props = defineProps({
    requestedItem: Object,
    quantity: Number,
    data: Object,
    recursionLevel: {
        type: Number,
        default: 0,
    },
})

const ingredientsToggle = ref(true);

const expandOrShrink = () => {
    // const className = name.split(' ').join('-')
    // const items = document.querySelectorAll(`.todo-item.${className}`);
    // console.log(items);
    ingredientsToggle.value = !ingredientsToggle.value; 
}

const checkSubBoxes = (item) => {
    console.log(item);
    if (item.ingredients){
        item.ingredients.forEach((ingredient) => {
            console.log(ingredient);
        })
    }
}

const checkboxName = (dataName, itemID) => {
    return htmlify(dataName) + '-' + itemID;   
}

const htmlify = (name) => {
    if (name){
        return name.split(' ').join('-');
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