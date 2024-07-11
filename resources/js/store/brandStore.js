import { defineStore } from 'pinia';
import { reactive } from 'vue';

export const useBrandStore = defineStore('brand', () => {
    const state = reactive({
        item: {}
    });

    
    const setItem = (itemInstance) => {
        state.item = itemInstance;
    };


    const transactionState = reactive({
        transaction:{status:'', message:'', errorDataMessage:''}
    });

    return { state, transactionState, setItem };
});
