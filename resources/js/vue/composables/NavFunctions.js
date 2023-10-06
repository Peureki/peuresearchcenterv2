// SCROLL TO SPECIFIC ID
// 
// Use cases: 
// 1) Hamburger to navigation on timer pages
// 2) Timer page info boxes
export const scrollTo = (id) => {
    const section = document.getElementById(id);
    if (section){
        section.scrollIntoView({behavior: 'smooth'});
    }
}