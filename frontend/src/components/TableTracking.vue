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
 <template v-slot:item.created_at="{ item }">
     {{ formattedTime(item.created_at) }}
    </template>
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
   formattedTime(utcTime) {
    const utcDate = new Date(utcTime);
      // Mengonversi UTC ke WIB (UTC +7)
      const wibDate = new Date(utcDate.getTime() + 7 * 60 * 60 * 1000);
      
      // Menyiapkan bagian tanggal dan waktu
      const year = wibDate.getFullYear();
      const month = (wibDate.getMonth() + 1).toString().padStart(2, '0'); // Menambahkan 1 karena bulan dimulai dari 0
      const day = wibDate.getDate().toString().padStart(2, '0');
      const hours = wibDate.getHours().toString().padStart(2, '0');
      const minutes = wibDate.getMinutes().toString().padStart(2, '0');
      const seconds = wibDate.getSeconds().toString().padStart(2, '0');

      // Format menjadi YYYY-MM-DD HH:MM:SS
      return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    },
   },
   mounted() {
        this.$store.dispatch('searchProgress');
   },
 }
</script>