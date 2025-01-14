<template>
    <CurrencyPage
        page-name="Ash Legion Commendation"
        target-currency="Ash Legion Commendation"
        :currency-icon="Currency"
    />

    <section class="main">
        <div class="content-section">

        </div>
    </section>





</template>

<script setup>
import Header from '@/js/vue/components/general/Header.vue'
import Nav from '@/js/vue/components/general/Nav.vue'
import CurrencyPage from '@/js/vue/components/general/CurrencyPage.vue'

import Currency from '@/imgs/icons/Ash_Legion_Commendation.png'

import { onMounted } from 'vue';
import { getAuthUser } from '@/js/vue/composables/Authentication';
import { user } from '@/js/vue/composables/Global';

onMounted(async () => {
    await getAuthUser(); 

    if (user.value){
        console.log('USER FOUND: ', user.value);
    }
})





</script>