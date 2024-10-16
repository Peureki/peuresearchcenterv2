<template>
    <div class="gathering-input-container">
        <div class="input">
            <p>{{ itemQty }}</p>
            <input type="text" placeholder="Item" v-model="item">
            <input type="button" value="+5" @click="itemQty += 5">
            <input type="button" value="+4" @click="itemQty += 4">
            <input type="button" value="+3" @click="itemQty += 3">
            <input type="button" value="+2" @click="itemQty += 2">
            <input type="button" value="+1" @click="itemQty += 1">
        </div>
        
        <div class="input">
            <p>{{ trashQty }}</p>
            <input type="text" placeholder="Trash" v-model="trash">
            <input type="button" value="+2" @click="trashQty += 2">
            <input type="button" value="+1" @click="trashQty += 1">
        </div>
        
    </div>
</template>

<script setup>
import { ref } from 'vue'

const item = ref(null),
    itemQty = ref(null),
    trash = ref(null),
    trashQty = ref(null);

</script>

<style scoped>
.content-section{
    display: flex;
    flex-direction: column;
    gap: var(--gap-general);
}
.gathering-input-container{
    display: flex;
    align-items: center;
    gap: var(--gap-content);
}
.input{
    display: flex;
    gap: var(--gap-general);
}
</style>