<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600px"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          outlined 
          class="addclient"
          color="teal lighten-3"
           dark         
          v-bind="attrs"
          v-on="on"
        >
          Add New Client
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="text-h5">Client Informations</span>
        </v-card-title>
        <v-card-text>
          <v-container>
             <v-row>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  label="First Name"
                  color="brown"
                  clearable
                  v-model="client.fname"
                ></v-text-field>
              </v-col>
               <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  label="Last Name"
                  color="brown"
                  clearable
                  v-model="client.lname"
                ></v-text-field>
              </v-col>
               



                </v-row>
               
            <v-row>
              <VuePhoneNumberInput v-model="client.phone" color="brown" default-country-code="DZ"/>
            </v-row>
           <v-row>
                   <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-text-field
                  label="email"
                  color="brown"
                  clearable
                  v-model="client.email"
                  :rules="emailRules"
                ></v-text-field>
              </v-col>
                    
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="brown darken-1"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="brown darken-1"
            text
            type="submit"
            @click.prevent=" create()"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import axios from 'axios'
import {EventBus} from '@/EventBus'
import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';
//import * as EmailValidator from 'email-validator';
export default {
    data: () =>({
        dialog: false,
        client:{
            fname: '',
            lname: '',
            email: '',
            phone: ''
        },
         emailRules: [ 
        v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
      ]
    }),
    components:{
      VuePhoneNumberInput
    },
    methods:{
        create: function(){
           var data = new FormData()
           data.append('fname',this.client.fname)
           data.append('lname',this.client.lname)
           data.append('email',this.client.email)
           data.append('phone',this.client.phone)
           axios.post('http://localhost/saasautomation/src/php/client.php',data)
          .then(res=>{
            if (res.data) {
            EventBus.$emit('client-created',res.data)
          }
          })
          this.dialog = false
        }
    }
}
</script>

<style scoped>
 .addclient{
     width: 200px ;
 }
</style>
