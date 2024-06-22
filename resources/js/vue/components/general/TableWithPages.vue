<template>
    <article>
        <slot class="page-list" name="page-list-top"></slot>
        <slot name="table"></slot>
        <slot class="page-list" name="page-list-bottom"></slot>
    </article>
</template>

<style scoped>
article{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: fit-content;
}

</style>