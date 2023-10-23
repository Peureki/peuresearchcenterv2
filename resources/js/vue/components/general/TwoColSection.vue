<template>
    <section>
        <article>
            <slot name="table1"></slot>
        </article>
        
        <article>
            <slot name="table2"></slot>
        </article>
    </section>
</template>

<script setup>

</script>

<style scoped>
section {
    display: grid;
    grid-template-columns: auto 1fr;
    border-bottom: var(--border-general);
}
article{
    padding: var(--padding-article);
    border-right: var(--border-general);
}

</style>