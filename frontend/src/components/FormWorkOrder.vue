<template>
    <v-card class="pa-2">
      <v-card-title>
        {{ edit ? 'Edit' : 'Tambah' }} Data Work Order 
        <v-spacer></v-spacer>
        <v-btn color="pink" dark class="mr-2" @click="cancel">
          Back
        </v-btn>
        <v-btn color="blue" dark @click="saveWorkOrder">
          Simpan
        </v-btn>
      </v-card-title>
  
      <v-card-title>
        <v-row>
          <v-col cols="8">
            <v-text-field
              label="Number"
              v-model="NumberWO"
              readonly
              :disabled="edit"
              persistent-hint
              hint="Number Akan Muncul Otomatis"
            ></v-text-field>
            <v-text-field
              label="Name Produk"
              v-model="NameProduct"
              :disabled="edit"
            ></v-text-field>
            <v-menu
        ref="menu"
        v-model="menu"
        :close-on-content-click="false"
        :return-value.sync="duedate"
        transition="scale-transition"
        offset-y
        min-width="auto"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            v-model="duedate"
            label="Tanggal"
            :disabled="edit"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker
          v-model="duedate"
          no-title
          scrollable
        >
          <v-spacer></v-spacer>
          <v-btn
            text
            color="primary"
            @click="menu = false"
          >
            Cancel
          </v-btn>
          <v-btn
            text
            color="primary"
            @click="$refs.menu.save(duedate)"
          >
            OK
          </v-btn>
        </v-date-picker>
      </v-menu>
            <v-text-field
              label="Jumlah"
              v-model="qty"
            ></v-text-field>
            <v-select
              :items="Status"
              label="Status"
              item-value="id"
              item-text="name"
              v-model="selectedSatus"
            ></v-select>
            <v-autocomplete
              :items="operators"
              label="Operator"
              item-text="username"
              item-value="id"
              v-model="selectedOperator"
              v-show="role.role_id == 1"
            ></v-autocomplete>
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
        menu:false
      };
    },
    computed: {
      ...Vuex.mapState({
        edit: (s) => s.edit,
        Status: (s) => s.Status,
        operators: (s) => s.operators,
        NumberWO: (s) => s.NumberWO,
        WOid: (s) => s.WOid,
        role: (s) => s.role,
      }),
      __s() {
        return this.$store.state; 
      },
      NameProduct: {
        get() {
          return this.__s.NameProduct;
        },
        set(v) {
          this.__c("NameProduct", v);
        },
      },
      duedate: {
        get() {
          return this.__s.duedate;
        },
        set(v) {
          this.__c("duedate", v);
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
      selectedSatus: {
        get() {
          return this.__s.selectedSatus;
        },
        set(v) {
          this.__c("selectedSatus", v);
        },
      },
      selectedOperator: {
        get() {
          return this.__s.selectedOperator;
        },
        set(v) {
          this.__c("selectedOperator", v);
        },
      },
      dialog: {
        get() {
          return this.__s.dialog;
        },
        set(v) {
          this.__c("dialog", v);
        },
      },
    },
    methods: {
      __c(a, b) {
        return this.$store.commit("SET_OBJECT", [a, b]);
      },
      cancel() {
        this.dialog = false;
        this.__c("edit",false);
      },
      saveWorkOrder() {
          this.$store.dispatch('addWorkOrder').then(()=>{
            this.dialog = false;
          });
          
      },
    },
    mounted() {
    },
  };
  </script>
  