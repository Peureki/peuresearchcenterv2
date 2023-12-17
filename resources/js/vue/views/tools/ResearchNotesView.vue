<template>
    <Nav/>
    <main>
        <Header page-name="Research Notes"/>

        <ResearchNotesTable/>
    </main>
</template>

<script setup>

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import ResearchNotesTable from '@/js/vue/components/tables/ResearchNotesTable.vue'

</script>