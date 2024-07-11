<script setup>

</script>

<template>
    <div>

        <nav aria-label="Page navigation example">
            <ul class="pagination cursor-link">
                <slot></slot>
            </ul>
        </nav>

    </div>
</template>

<style scoped>
    .cursor-link{
        cursor: pointer;
    }
</style>