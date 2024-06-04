<template>
    <section>
        <div>
            <slot name="loading1"></slot>
            <slot name="table1"></slot>

            <slot name="content1"></slot>
        </div>
        
        <div>
            <slot name="loading2"></slot>
            <slot name="table2"></slot>

            <slot name="content2"></slot>
        </div>
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
div {
    border-right: var(--border-general);
}

</style>