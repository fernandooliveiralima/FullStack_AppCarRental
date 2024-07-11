<script setup>
    const props = defineProps({
        card_title:{ type: String }
    });
</script>

<template>

    <!-- Start Search Card -->
    <div class="card">
        <div class="card-header">{{ props.card_title }}</div>

        <div class="card-body">
            <slot name="content"></slot>
        </div>

        <slot name="footer"></slot>
    </div>
    <!-- End Search Card -->

</template>

<style scoped></style>