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
// *
// * LOGIN
// * Assuming a completed form with username, password => login into a new session 
// * Refresh page if successful
export const login = async (name, email, password, remember) => {
    console.log(name, email);
    try {
        // Get unique cookie? 
        await axios.get('../sanctum/csrf-cookie');
        // Send POST to /login via web.php route: 
        // LoginController.php, authenticate(); 
        // Use the v-model form values to verify registered user
        const response = await axios.post('../login', {
            name: name,
            email: email,
            password: password,
            remember: remember,
        }, {
            divs: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        // If sucessful, page refresh
        if (response){
            console.log("Login successful!");
            window.location.reload();
        } 
    } catch (error) {
        console.log('Login error: ', error);
    }
}
// *
// * LOGOUT USER
// * user.value => null 
// * refresh the page
export const logout = async () => {
    try {
        const response = await axios.post('../logout');

        if (response){
            user.value = null;
            console.log('Logout successful!');
            window.location.reload();
        }
    } catch (error){
        console.log('Logout failed: ', error);
    }
}