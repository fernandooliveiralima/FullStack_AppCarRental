<script setup>
const props = defineProps({
    id_element: { type: String},
    title_element: { type: String},
    idHelp:{ type: String},
    text_help:{ type: String}
});
</script>

<template>
    <div>
        <form action="">
            <label :for="props.id_element" class="form-label">
                {{ props.title_element }}
            </label>
            <div :id="props.idHelp" class="form-text">{{ props.text_help }}</div>
        </form>
        <slot/>
    </div>
</template>

<style scoped></style>