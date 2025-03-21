<template>
  <v-row justify="center">
    <v-snackbar v-model="dialog" :timeout="4000" top color="pink">
			<h4>{{ message }}</h4>
			<template v-slot:action="{ attrs }">
				<v-btn text dark v-bind="attrs" @click="dialog = false">
					Close
				</v-btn>
			</template>
		</v-snackbar>
    <v-col cols="12" sm="10" class="pt-0">
      <v-card class="elevation-6 mt-15" >
        <v-window v-model="step">
          <!-- LOGIN TAB -->
          <v-window-item :value="1">
            <v-row>
              <v-col cols="12" md="6">
                <v-card-text class="mt-12">
                  <h2 class="text-center">Login to Your Account</h2>
                  <h5 class="text-center grey--text mb-2">
                    Log in to your account so you can continue building and editing your onboarding flows
                  </h5>
                  <v-row align="center" justify="center">
                    <v-col cols="12" sm="8">
                      <!-- Email -->
                      <v-text-field
                        v-model="username"
                        label="Username"
                        outlined
                        dense
                        color="blue"
                        autocomplete="false"
                      />
                      <!-- Password -->
                      <v-text-field
                        v-model="password"
                        label="Password"
                        outlined
                        dense
                        color="blue"
                        autocomplete="false"
                        type="password"
                      />
                      <v-row>
                        <v-col cols="12" sm="7">
                          <v-checkbox
                            v-model="rememberMe"
                            label="Remember Me"
                            class="mt-n1"
                            color="blue"
                          />
                        </v-col>
                        <v-col cols="12" sm="5">
                          <span class="caption blue--text">Forgot password</span>
                        </v-col>
                      </v-row>
                      <v-btn @click="login" color="blue" dark block tile>Log in</v-btn>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-col>
              <v-col cols="12" md="6" class="blue rounded-bl-xl">
                <div style="text-align: center; padding: 180px 0;">
                  <v-card-text class="white--text">
                    <h2 class="text-center">Don't Have an Account Yet?</h2>
                    <h5 class="text-center mt-2">
                      Let's get you all set up so you can start creating your first onboarding experience
                    </h5>
                  </v-card-text>
                  <div class="text-center">
                    <v-btn tile outlined dark @click="stepsignup()">SIGN UP</v-btn>
                  </div>
                </div>
              </v-col>
            </v-row>
          </v-window-item>

          <!-- SIGN UP TAB -->
          <v-window-item :value="2">
            <v-row>
              <v-col cols="12" md="6" class="blue rounded-br-xl">
                <div style="text-align: center; padding: 180px 0;">
                  <v-card-text class="white--text">
                    <h2 class="text-center">Already Signed Up?</h2>
                    <h5 class="text-center mb-2">
                      Log in to your account so you can continue building and editing your onboarding flows
                    </h5>
                  </v-card-text>
                  <div class="text-center">
                    <v-btn tile outlined dark @click="steplogin()">Log in</v-btn>
                  </div>
                </div>
              </v-col>

              <v-col cols="12" md="6">
                <v-card-text class="mt-10 mb-2">
                  <h2 class="text-center">Sign Up for an Account</h2>
                  <h5 class="text-center grey--text mb-2 mt-n2">
                    Let's get you all set up so you can start creating your first onboarding experience
                  </h5>
                  <v-row align="center" justify="center">
                    <v-col cols="12" sm="8">
                      <!-- First Name and Last Name -->
                      <v-row>
                        <v-col cols="12" dense>
                          <v-text-field
                            v-model="username"
                            label="User Name"
                            outlined
                            dense
                            color="blue"
                            autocomplete="false"
                          />
                        </v-col>
            
                      </v-row>
                      <!-- Email and Password -->
                      <v-text-field
                        v-model="password"
                        label="Password"
                        outlined
                        dense
                        color="blue"
                        autocomplete="false"
                        type="password"
                      />
                      <v-row>
                        <v-col cols="12" sm="7">
                          <v-checkbox
                            v-model="acceptTerms"
                            label="I Accept"
                            class="mt-n1"
                            color="blue"
                          />
                        </v-col>
                        <v-col cols="12" sm="5">
                          <span class="caption blue--text ml-n4">Terms & Conditions</span>
                        </v-col>
                      </v-row>
                      <v-btn @click="signUp" color="blue" dark block tile>Sign up</v-btn>
                      <h5 class="text-center grey--text mt-4 mb-3">Or Sign up using</h5>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-col>
            </v-row>
          </v-window-item>
        </v-window>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  data() {
    return {
      step: 1,

      acceptTerms: false,
      rememberMe: false,
    };
  },
  computed: {
    __s() {
      return this.$store.state; 
    },
    message() {
      return this.$store.state.message; 
    },

    firstName: {
      get() {
        return this.__s.firstName;
      },
      set(v) {
        this.__c("firstName", v);
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
    lastName: {
      get() {
        return this.__s.lastName;
      },
      set(v) {
        this.__c("lastName", v);
      },
    },
    username: {
      get() {
        return this.__s.username;
      },
      set(v) {
        this.__c("username", v);
      },
    },
    password: {
      get() {
        return this.__s.password;
      },
      set(v) {
        this.__c("password", v);
      },
    },
    email: {
      get() {
        return this.__s.email;
      },
      set(v) {
        this.__c("email", v);
      },
    },

  },
  methods: {
    __c(a, b) {
      return this.$store.commit("SET_OBJECT", [a, b]);
    },
    async login() {
      console.log(this.$store.state);
      
  try {
    await this.$store.dispatch('login');
    this.$nextTick(() => {
      this.$router.push({ name: 'Dashboard' });
    });
  } catch (error) {
    console.error('Registration error:', error);
  }
},

    async signUp() {
      try {
        await this.$store.dispatch('register');
      } catch (error) {
        console.error('Registration error:', error);
      }
    },
    steplogin() {
      this.step = this.step - 1
      this.reset()
    },
    stepsignup() {
      this.reset()
      this.step = this.step + 1
    },
    reset(){
      this.__c("username", '');
      this.__c("password", '');
      this.__c("rePassword", '');
      this.__c("firstName", '');
      this.__c("lastName", '');
      this.__c("email", '');
    },
  },
  mounted() {
    if (this.__s.token) {
      this.$router.push({ name: 'Dashboard' });
    }
  },
};
</script>

<style scoped>
.v-application .rounded-bl-xl {
  border-bottom-left-radius: 300px !important;
}
.v-application .rounded-br-xl {
  border-bottom-right-radius: 300px !important;
}
</style>