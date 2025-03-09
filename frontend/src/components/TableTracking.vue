<template>
    <v-card class="pa-2">
     <v-card-title>
       <v-row>
           <v-col cols="7">
               Work Order Progress 
           </v-col>
       </v-row>
       </v-card-title>
       <v-data-table
   :headers="headers"
   :items="ProgressWorkOrders"
   class="elevation-1"
 >

 </v-data-table>
   </v-card>
</template>

<script>
 export default {
   components:{
   },
   data () {
     return {
       doDel: false,
       headers: [
         { text: 'Number', value: 'work_number',sortable: false },
         { text: 'Name', value: 'work_name',sortable: false },
         { text: 'Status', value: 'status',sortable: false },
         { text: 'Quantity', value: 'quantity',sortable: false },
         { text: 'Note', value: 'notes',sortable: false },
         { text: 'Timestamp', value: 'created_at',sortable: false },
       ],
       search: '',
     }
   },
   computed: {
   __s() {
     return this.$store.state; 
   },
   role() {
     return this.$store.state.role; 
   },
   ProgressWorkOrders() {
     return this.$store.state.ProgressWorkOrders; 
   },

 },

   methods: {
       __c(a, b) {
     return this.$store.commit("SET_OBJECT", [a, b]);
   },
     
   },
   mounted() {
        this.$store.dispatch('searchProgress');
   },
 }
</script>