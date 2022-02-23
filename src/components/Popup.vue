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
                  color="brown"
                  clearable
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
                  color="brown"
                  clearable                  
                  v-model="saasinfo.saasmail"
                ></v-text-field>
              </v-col>
              
             
              <v-col cols="12">
                <v-text-field
                  label="Password*"
                  color="brown"
                  clearable
                  :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="show ? 'text' : 'password'"
                  @click:append="show = !show"
                  hint="enter your password and confirme your identity"

                ></v-text-field>
              </v-col>
             
              <v-col
              cols="12"
              sm="6"
              >
                  <div >
                    <v-menu transition="fade-transition">
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn
                         dark
                         color="brown"
                         v-bind="attrs"
                         v-on="on"

                         
                         >
                            Add Service
                        </v-btn>
                      </template>
                      <v-list>
                        <v-list-item-group
                        v-model="saasinfo.service"
                        mandatory
                        color="indigo"
                        >
                        <v-list-item
                           v-for="service in services"
                         :key="service.id"
                         link
                          >
                          <v-list-item-title >
                                   {{service.nom}}   v{{service.version}}      
                          </v-list-item-title>
                        </v-list-item>
                        </v-list-item-group>
                      </v-list>
                    </v-menu>
                  </div>

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
  export default {
    data: () => ({
      dialog: false,
      saasinfo: {
        saasname: '',
        saasmail: '',
        service: ''
      },
      services: '',
      show: false
     
        
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
      },
      
    },
     mounted(){
        axios.get('http://localhost/saas/src/php/versions.php')
        .then( response=>{
          console.log(response.data)
          this.services = response.data
        })
      }
  }
</script>
<style scoped>
 .addclient{
     width: 200px ;
 }
</style>