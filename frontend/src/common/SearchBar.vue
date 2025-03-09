<template>
    <v-sheet>
        <v-text-field
            :label="'Search'"
            color="secondary"
v-model="search"
            hide-details
        outlined
        dense
        >
        <template v-slot:append>
            <v-btn
                    class="mt-n2"
                    elevation="1"
                    fab icon
                    small
                    @click="search"
                >
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
        </template>
            <template v-slot:append-outer v-if="role.role_name !== 'Operator'">
             
                <v-btn
                    class="mt-n2 ml-2"
                    elevation="1"
                    fab
                    small
                    dark
                    @click="add"
                    color="blue"
                >
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
            </template>
        </v-text-field>
    </v-sheet>
</template>

<script>
export default {
    data() {
        return {
        };
    },
    computed : {
        __s() {
      return this.$store.state; 
    },
    role(){
      return this.__s.role;
    },
    userdata(){
      return this.__s.userdata;
    },
    search: {
        get() {
          return this.__s.search;
        },
        set(v) {
          this.__c("search", v);
        },
      },
    },
    methods: {
        __c(a, b) {
        return this.$store.commit("SET_OBJECT", [a, b]);
      },
        add() {
            this.__c("dialog", true);
            this.__c("NumberWO", "");
            this.__c("NameProduct", "");
            this.__c("qty", "");
            this.__c("duedate", "");
            this.__c("selectedSatus", "");
            this.__c("selectedOperator", "");
            this.__c("WOid", 0);
        }
    }
}
</script>
