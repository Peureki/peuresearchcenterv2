import { user, isAuthenticating } from "@/js/vue/composables/Global";

// *
// * AUTHENTICATE USER
// * When auth, fill user.value
export const getAuthUser = async () => {
    try {
        isAuthenticating.value = true; 

        const response = await fetch('../api/user');
        if (!response.ok){
            throw new Error('Failed to fetch user data');
        }
        user.value = await response.json(); 
    } catch (error){
        console.log('Unable to retrieve user: ', error); 
    } finally {
        isAuthenticating.value = false; 
    }
}