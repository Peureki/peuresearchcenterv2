<template>
    <div class="password-reset-container">
        <img :src="PeuChoya" alt="Peu Research Center" title="Peu Research Center">

        <h1>Password Reset</h1>
        <form @submit.prevent="handleForgotPassword(confirmPassword)">
            <input type="password" name="password" id="password" placeholder="New Password" v-model="password">

            <input type="password" name="confirmPassword" placeholder="Confirm Password" id="confirmPassword" v-model="confirmPassword">

            <p v-if="password" class="error-message">{{ requiredCountMessage }}</p>

            <p v-if="password != confirmPassword && confirmPassword" class="error-message">{{ passwordMessage }}</p>

            <button type="submit">Reset Password</button>
        </form>

        <p v-if="success">{{ responseMessage }}</p>
        <router-link to="/">Return Home</router-link>
    </div>
    
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router';
import PeuChoya from '@/imgs/choyas/Peu_Choya.png'
import axios from 'axios';

const password = ref(null),
    confirmPassword = ref(null);

const success = ref(null),
    responseMessage = ref(null);

const requiredCountMessage = computed(() => {
    if (password.value.length < 7){
        return 'Password need to be at least 8 characters'
    }
})

const passwordMessage = computed(() => {
    if (password.value != confirmPassword.value && confirmPassword.value){
        return 'Password does not match'
    }
})

// GET TOKEN & EMAIL FROM ROUTE
// Token, Email is from user's email when they click "reset password"
const route = useRoute();
const token = route.params.token,
    email = route.query.email; 

const handleForgotPassword = async () => {
    try {
        const response = await axios.post(`/reset-password/${token}`, {
            token: token,
            email: email,
            password: password.value,
            password_confirmation: confirmPassword.value,
        }); 

        if (response){
            success.value = true; 
            responseMessage.value = response.data.message; 
        }
    } catch (error){
        console.log('Could not verify email: ', error); 
    }
}

</script>

<style scoped>
.password-reset-container{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: var(--gap-content);
    height: 100vh;
}
form{
    display: flex;
    flex-direction: column;
    gap: var(--gap-general);
}
img {
    width: var(--w-homepage-icon);
}
</style>