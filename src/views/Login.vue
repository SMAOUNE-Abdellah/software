<template>
  <v-container>
      <v-row align="center" justify="center" >
          <v-col cols="12" sm="10">
            <v-card class="elevation-6 mt-10"  >
             <v-window v-model="step">
                <v-window-item :value="1">
                  <v-row>
                    <v-col cols="12" md="6">
                      <v-card-text class="mt-12">
                        <h4
                          class="text-center"
                        >Login in to Your Account</h4>
                        <h6
                          class="text-center  grey--text "
                        >Log in to your account so you can continue builiding <br>and editing your onboarding flows</h6>
                        <v-row align="center" justify="center">
                          <v-col cols="12" sm="8">
                           
                          <v-text-field
                            label="Email"
                            outlined
                            dense
                            color="brown"
                            autocomplete="false"
                           class="mt-16"
                           v-model="login.email"
                          />
                          <v-text-field
                            label="Password"
                            outlined
                            dense
                            color="brown"
                          autocomplete="false"
                           v-model="login.password"
                           :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                           :type="show ? 'text' : 'password'"
                          @click:append="show = !show"
                          
                          />
                            <v-row>
                              <v-col cols="12" sm="7">
                                <v-checkbox
                       
                        label="Remember Me"
                        class="mt-n1"
                        color="brown"
                      > </v-checkbox>
                              </v-col>
                              <v-col cols="12" sm="5">
                                <span class="caption brown--text">Forgot password</span>
                              </v-col>
                            </v-row>
                          <v-btn color="brown" dark block tile @click="logins()">Log in</v-btn>
                     
                         <h5
                          class="text-center  grey--text mt-4 mb-3"
                        >Or Log in using</h5>
                         <div class="d-flex  justify-space-between align-center mx-10 mb-16">
                        <v-btn depressed outlined color="grey">
                          <v-icon color="red">fab fa-google</v-icon>
                        </v-btn>
                        <v-btn depressed outlined color="grey">
                          <v-icon color="blue">fab fa-facebook-f</v-icon>
                        </v-btn>
                        <v-btn depressed outlined color="grey">
                          <v-icon color="light-blue lighten-3">fab fa-twitter</v-icon>
                        </v-btn>
                         </div>
                          </v-col>
                        </v-row>  
                      </v-card-text>
                    </v-col>
                    <v-col cols="12" md="6" class="brown rounded-bl-xl" >
                    <div style="  text-align: center; padding: 180px 0;">
                      <v-card-text class="white--text" >
                        <h3 class="text-center ">Don't Have an Account Yet?</h3>
                        <h6
                          class="text-center"
                        >Let's get you all set up so you can start creating your your first<br>  onboarding experience</h6>
                      </v-card-text>
                      <div class="text-center">
                        <v-btn tile outlined dark @click="step++">SIGN UP</v-btn>
                      </div>
                      </div>
                    </v-col>
                  </v-row>
                </v-window-item>
                <v-window-item :value="2">
                  <v-row >
                    <v-col cols="12" md="6" class="brown rounded-br-xl">
                     <div style="  text-align: center; padding: 180px 0;">
                      <v-card-text class="white--text" >
                        <h3 class="text-center ">Alredy Signed up?</h3>
                        <h6
                          class="text-center"
                        >Log in to your account so you can continue building and<br>  editing your onboarding flows</h6>
                      </v-card-text>
                      <div class="text-center">
                        <v-btn tile outlined dark @click="step--">Log in</v-btn>
                      </div>
                      </div>
                    </v-col>

                    <v-col cols="12" md="6">
                      <v-card-text class="mt-12">
                        <h4
                          class="text-center"
                        >Sign Up for an Account</h4>
                        <h6
                          class="text-center  grey--text "
                        >Let's get you all set up so you can start creatin your <br>
                        first onboarding experiance</h6>
                        <v-row align="center" justify="center">
                          <v-col cols="12" sm="8">
                           <v-row>
                           <v-col cols="12" sm="6">
                            <v-text-field
                            label="Name"
                            outlined
                            dense
                            color="brown"
                            autocomplete="false"
                           class="mt-4"
                           v-model="signup.name"
                          />
                           </v-col>
                           <v-col cols="12" sm="6">
                            <v-text-field
                            label="User Name"
                            outlined
                            dense
                            color="brown"
                            autocomplete="false"
                           class="mt-4"
                           v-model="signup.username"
                          />
                           </v-col>
                           </v-row>
                          <v-text-field
                            label="Email"
                            outlined
                            dense
                            color="brown"
                            autocomplete="false"
                            v-model="signup.email"
                          />
                          <v-text-field
                            label="Password"
                            outlined
                            dense
                            color="brown"
                          autocomplete="false"
                           v-model="signup.password"
                           :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                           :type="show1 ? 'text' : 'password'"
                           @click:append="show1 = !show1"
                          
                          />
                            <v-row>
                              <v-col cols="12" sm="7">
                                <v-checkbox
                       
                        label="I Accept Saasi"
                        class="mt-n1"
                        color="brown"
                      > </v-checkbox>
                              </v-col>
                              <v-col cols="12" sm="5">
                                <span class="caption brown--text ml-n4">Terms &Conditions</span>
                              </v-col>
                            </v-row>
                          <v-btn color="brown" dark block tile @click.prevent="signups()">Sign up</v-btn>
                     
                         <h5
                          class="text-center  grey--text mt-4 mb-3"
                        >Or Sign up using</h5>
                         <div class="d-flex  justify-space-between align-center mx-10 mb-11">
                        <v-btn depressed outlined color="grey">
                          <v-icon color="red">fab fa-google</v-icon>
                        </v-btn>
                        <v-btn depressed outlined color="grey">
                          <v-icon color="blue">fab fa-facebook-f</v-icon>
                        </v-btn>
                        <v-btn depressed outlined color="grey">
                          <v-icon color="light-blue lighten-3">fab fa-twitter</v-icon>
                        </v-btn>
                         </div>
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
  </v-container>
</template>

<script>
  import axios from 'axios'
  export default {
   data: () => ({
    step: 1,
    signup:{
        name: '',
        username: '',
        email: '',
        password: ''

    },
    login:{
        email: '',
        password: ''
    },
    show: false,
    show1: false
  }),
  props: {
    source: String
  } ,
    
  methods:{
      logins: function(){
        var dataL = new FormData()
        dataL.append('email',this.login.email)
        dataL.append('password',this.login.password)
        axios.post('http://localhost/saas/src/php/inscription.php?action=login',dataL)
        .then( res =>{
            if (res.data[0]['email'] == this.login.email || res.data[0]['password'] == this.login.password) {
                this.$router.push('/dashboard')
            }

        })
      },
      signups: function(){
          var dataS = new FormData()
          dataS.append('name',this.signup.name)
          dataS.append('username',this.signup.username)
          dataS.append('email',this.signup.email)
          dataS.append('password',this.signup.password)
          axios.post('http://localhost/saas/src/php/inscription.php?action=signup',dataS)
          .then( res =>{
              console.log(res)
              this.$router.push('/dashboard')
          })


      }

  }
  }
</script>
<style scoped>
.v-application .rounded-bl-xl {
    border-bottom-left-radius: 300px !important;
}
.v-application .rounded-br-xl {
    border-bottom-right-radius: 300px !important;
}
</style>