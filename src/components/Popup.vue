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
          color="teal lighten-3"
           dark         
          v-bind="attrs"
          v-on="on"
        >
          Add new Client
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
                  label="Saas Name"
                  hint="enter the company name of your client"
                  v-model="saasinfo.saasname"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  label="Saas e-mail"                  
                  v-model="saasinfo.saasmail"
                ></v-text-field>
              </v-col>
              
             
              <v-col cols="12">
                <v-text-field
                  label="Password*"
                  type="password"
                  hint="enter your password and confirme your identity"

                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
              >
                <v-autocomplete
                  :items="['Salsabiil e-commerce']"
                  label="Services"
                  hint="Add a Service for your client"
                  multiple
                  v-model="saasinfo.service"
                ></v-autocomplete>
              </v-col>
             
            </v-row>
          </v-container>
          <small>*indicates required field</small>
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
  export default {
    data: () => ({
      dialog: false,
      saasinfo: {
        saasname: '',
        saasmail: '',
        service: ''
      }
    }),
    methods: {
      create: function(){
        var Cdata = new FormData()
        Cdata.append('saasname',this.saasinfo.saasname)
        Cdata.append('saasmail',this.saasinfo.saasmail)
        Cdata.append('service',this.saasinfo.service)
        axios.post('http://localhost/saas/src/php/client.php?action=addclient',Cdata)
        .then( res=>{
          console.log(res.data)
        })



        this.dialog = false
      }
    }
  }
</script>