<template>
    <div 
        class="nav-section-container"
    >
        <h4 class="nav-section-header">{{ header }}</h4>
        <svg 
            class="expand"
            :class="{rotate180: toggle}" 
            width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg"
        >
            <path d="M8.81372 0.397634C8.6944 0.280464 8.5326 0.214642 8.36389 0.214642C8.19519 0.214642 8.03339 0.280464 7.91407 0.397634L4.76468 3.49138L1.61529 0.397634C1.49529 0.283785 1.33457 0.220788 1.16775 0.222212C1.00093 0.223636 0.841356 0.289367 0.723392 0.405247C0.605428 0.521127 0.538516 0.677885 0.537066 0.841758C0.535617 1.00563 0.599746 1.16351 0.715642 1.28138L4.31486 4.81701C4.43417 4.93418 4.59597 5 4.76468 5C4.93339 5 5.09519 4.93418 5.2145 4.81701L8.81372 1.28138C8.93299 1.16418 9 1.00524 9 0.839509C9 0.673781 8.93299 0.514838 8.81372 0.397634Z" fill="var(--color-link)"/>
        </svg>
    </div>

</template>

<script setup>

const props = defineProps({
    toggle: Boolean, 
    header: String, 
})

</script>

<style scoped>
.nav-section-header{
    text-align: center;
    padding-block: var(--gap-content);
    color: var(--color-subheader);
}
.nav-section-container {
    position: relative;
    cursor: pointer;
    border-bottom: var(--border-bottom);
}
.nav-section-container h5{
    color: var(--color-subheader);
}
.nav-section-container svg{
    position: absolute;
    bottom: 0%;
    left: 50%;
    transform: translate(-0%, -50%);
    width: 10px;
    height: 10px;
    transition: var(--transition-all-03s-ease);
}
.nav-section-container:hover svg{
    bottom: -5%;
    transform: translate(5%, -50%);
}
@media (max-width: 768px){
    .nav-section-header{
        font-size: var(--font-size-h3);
    }
}

</style>