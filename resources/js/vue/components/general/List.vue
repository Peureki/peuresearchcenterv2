<template>
    <div v-if="data">
        <div 
            v-for="(item, index) in data"
            class="todo-item"
        >
            <input type="checkbox" :name="item.id">
            <label :for="item.id">{{ item.name }}</label>
        </div>
    </div>

</template>

<script setup>

const props = defineProps({
    data: Object,
})

console.log('List: ', props.data);

</script>