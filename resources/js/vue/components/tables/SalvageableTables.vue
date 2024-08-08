<template>
    <section>
        <Loading
            v-if="!salvageables"
            :width="200" :height="200"
        />

        <SalvageableMainTable
            v-if="salvageables"
            :salvageables="salvageables"
        />


    </section>

</template>

<script setup>
import Loading from '@/js/vue/components/general/Loading.vue'
import SalvageableMainTable from '@/js/vue/components/tables/SalvageableMainTable.vue'

const props = defineProps({
    salvageables: Object, 
    dropRates: Object, 
})

</script>

<style scoped>


</style>