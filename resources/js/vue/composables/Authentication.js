import { user, isAuthenticating } from "@/js/vue/composables/Global";
6
// *
// * AUTHENTICATE USER
// * When auth, fill user.value
export const getAuthUser = async () => {
    try {
        isAuthenticating.value = true; 

        const response = await fetch('/api/user', {
            withCredentials: true,
        });

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
// * REGISTER USER
// * Assuming a completed form with username, password => login into a new session 
// * Refresh page if successful
export const register = async (name, email, password) => {
    console.log('registering as: ', name, email, password);
    try {
          const response = await fetch('/register', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              },
              body: JSON.stringify({
                  name: name,
                  email: email,
                  password: password,
              }),
          });
  
        if (response.ok) {
            console.log('Registered!', response);
            window.location.reload(); 
        } else {
            return response; 
        }

    // Redirect or handle success as needed
    } catch (error) {
        console.error('Registration error:', error);
        return response; 
        // Handle error (e.g., show error message)
    }
};
// *
// * LOGIN
// * Assuming a completed form with username, password => login into a new session 
// * Refresh page if successful
// export const login = (name, email, password, remember) => {
//     // Get unique CSRF cookie first
//     axios.get('/sanctum/csrf-cookie')
//         .then(() => {
//             // Send POST request to login
//             return axios.post('/login', {
//                 name: name,
//                 email: email,
//                 password: password,
//                 remember: remember,
//             }, {
//                 headers: {
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//                 }
//             });
//         })
//         .then(response => {
//             // If login is successful, refresh the page
//             if (response) {
//                 console.log("Login successful!", response);
//                 //window.location.reload();
//             } else {
//                 console.log('Login failed merp')
//             }
//         })
//         .catch(error => {
//             // Handle login error
//             console.log('Login error: ', error);
//         });
// };
// *
// * LOGOUT USER
// * user.value => null 
// * refresh the page
export const logout = async () => {
    try {
        const response = await axios.post(`/logout`);

        if (response){
            user.value = null;
            console.log('Logout successful!');
            window.location.reload();
        }
    } catch (error){
        console.log('Logout failed: ', error);
    }
}