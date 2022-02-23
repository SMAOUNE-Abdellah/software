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
          class="addhost"
          color="teal lighten-3"
           dark         
          v-bind="attrs"
          v-on="on"
        >
          Add new Host
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="text-h5">Host Informations</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
             
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-select
                v-model="hostinfo.hostos"
                :items= "items"
                 label="Host System Distribution"
                 color="brown"
                >
                </v-select>
                
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  label="Host IP Add"   
                  color="brown"    
                  clearable           
                  v-model="hostinfo.hostip"
                ></v-text-field>
              </v-col>
             
             
            </v-row>
             <v-row>
             
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  label="User Name"
                  hint="enter the user name"
                  color="brown"
                  clearable
                  v-model="hostinfo.hostuser"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  label="Host Password"  
                  color="brown"
                  clearable               
                  v-model="hostinfo.hostps"
                  :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="show ? 'text' : 'password'"
                  @click:append="show = !show"
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
            @click.prevent=" createh()"
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
      hostinfo: {
        hostos: '',
        hostuser: '',
        hostip: '',
        hostps: '',
      },
      show : false,
      items: ['Centos','Debian','Ubuntu'],
    }),
    methods: {
      createh: function(){
        var data = new FormData()
        data.append('hostos',this.hostinfo.hostos)
        data.append('hostuser',this.hostinfo.hostuser)
        data.append('hostip',this.hostinfo.hostip)
        data.append('hostps',this.hostinfo.hostps)
        axios.post('http://localhost/saas/src/php/addhost.php',data)
        .then( res=>{
          console.log(res.data)
        })
        this.dialog = false
      }
    }
  }
</script>

<style scoped>
 .addhost{
     width: 200px ;
 }
</style>