<script setup>
/* Vue Imports */
import { computed } from 'vue';

/* Props */
const props = defineProps({
    type_alert: {
        type: String
    },
    alert_title: {
        type: String
    },
    alert_details: {
        type: Object,
        default: () => ({})
    }
});

/* computed */
const alertStyle = computed(() => `alert alert-${props.type_alert}`);
const alertErrors = computed(() => props.alert_details.errorDataMessage);
const alertSuccess = computed(() => props.alert_details.message);

</script>

<template>
    <div :class="alertStyle" role="alert">
        
        <span>{{ props.alert_title }}</span>

        <hr>

        <p> <strong>{{ alertSuccess }}</strong></p>

        <ul v-if="alertErrors">
            <li v-for="(iterator, index) in alertErrors" :key="index">{{ iterator[0] }}</li>
        </ul>
       
    </div>
</template>

<style lang="scss" scoped></style>