<template>
 <v-card class="pa-2">
      <v-card-title>
        {{ edit ? 'Edit' : 'Tambah' }} Data Work Order Progress 
        <v-spacer></v-spacer>
        <v-btn color="pink" dark class="mr-2" @click="back">
          Back
        </v-btn>
        <v-btn color="blue" dark @click="save">
          Simpan
        </v-btn>
      </v-card-title>
  
      <v-card-title>
        <v-row>
          <v-col cols="8">

            <v-text-field
              label="Number"
              v-model="NumberWO"
              readonly disabled
              persistent-hint
              hint="Number Akan Muncul Otomatis"
            ></v-text-field>
            <v-text-field
              label="Name Produk"
              v-model="NameProduct"
              readonly disabled
            ></v-text-field>
            <v-select
    :items="status"
              label="Status"
              item-value="id"
              item-text="name"
              v-model="selectedSatus"
            ></v-select>
            <v-text-field
              label="Jumlah" type="number"
              v-model="qty"
            ></v-text-field>
            <v-textarea
          v-model="Note"
          label="Notes" v-show="selectedSatus == 'Progress'"
        ></v-textarea>
         </v-col>
         </v-row>
         </v-card-title>
         </v-card>
</template>

<script>
import Vuex from 'vuex'
export default {
  data() {
    return {
      menu:false,
      Status: [
      { "name": 'Pending', "id": 'Pending' },
      { "name": 'IProgress', "id": 'In Progress' },
      { "name": 'Completed', "id": 'Completed' },
      { "name": 'Cancelled', "id": 'Cancelled' }
    ],
    };
  },
  computed: {
    ...Vuex.mapState({
      edit: (s) => s.edit,
      NumberWO: (s) => s.NumberWO,
      NameProduct: (s) => s.NameProduct,
      WOid: (s) => s.WOid,
      status: (s) => s.status,
      currentStatus: (s) => s.currentStatus,
    }),
    __s() {
      return this.$store.state; 
    },
   
    dialog: {
      get() {
        return this.__s.dialog;
      },
      set(v) {
        this.__c("dialog", v);
      },
    },
   
    selectedSatus: {
      get() {
        return this.__s.selectedSatus;
      },
      set(v) {
        this.__c("selectedSatus", v);
      },
    },

    Note: {
      get() {
        return this.__s.Note;
      },
      set(v) {
        this.__c("Note", v);
      },
    },
    qty: {
      get() {
        return this.__s.qty;
      },
      set(v) {
        this.__c("qty", v);
      },
    },
 


   
  },
  methods: {
    __c(a, b) {
      return this.$store.commit("SET_OBJECT", [a, b]);
    },
    back(){
      this.__c("dialog",false);
      this.__c("Progress",false);
    },
    save(){
      this.__c("dialog",false);
      this.__c("Progress",false);
      this.$store.dispatch('updateStatus');
      this.$store.dispatch('SearchWorkOrder');
    },
  },
  mounted() {
  },
};
</script>
