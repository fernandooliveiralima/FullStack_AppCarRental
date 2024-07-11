<script setup>
/* Vue Imports */


/* App Imports */

/* Variables */


/* Computed Properties */

/* Methods */

/* Vue Methods */


const props = defineProps({
    modal_id: { type: String },
    modal_title: { type: String }
});
</script>

<template>
    <div class="modal fade" :id="props.modal_id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ props.modal_title }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <slot name="alerts"></slot>
                    <slot name="modal-content"></slot>
                </div>
                <div class="modal-footer">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>