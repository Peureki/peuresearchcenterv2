// Use to rotate individual svgs that are created dynamically
// Needs: 
// 1. Class name of the cta
// 2. Initialize a ref 
// 3. Dynamically create the ref within the cta. ex: :ref="el => ctaDetails[index] = el" 
export function rotate90(index, targetClassName, refVar){
    const cta = document.querySelectorAll(`.${targetClassName}`);
    cta.forEach((button) => { 
        button.classList.remove('rotate-90'); 
    });
    refVar[index].classList.add('rotate-90');
}