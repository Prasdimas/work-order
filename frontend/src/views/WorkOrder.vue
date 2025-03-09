<template>
    <v-row>
        <v-col cols="12">
            <TableWorkOrder v-if="!dialog"></TableWorkOrder>
            <FormWorkOrder v-if="dialog && !Progress"></FormWorkOrder>
            <FormWorkProgress v-if="dialog && Progress"></FormWorkProgress>
        </v-col>
    </v-row>
</template>
<script>
import FormWorkOrder from '../components/FormWorkOrder.vue';
import FormWorkProgress from '../components/FormWorkProgress.vue';
import TableWorkOrder from '../components/TableWorkOrder.vue';

export default {
    components: {
        TableWorkOrder: TableWorkOrder,FormWorkOrder, FormWorkProgress
        },
    computed:{
        dialog() {
        return this.$store.state.dialog; 
    },
        Progress() {
        return this.$store.state.Progress; 
    },
    }
    }
</script>