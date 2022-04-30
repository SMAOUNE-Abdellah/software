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
          class="addservice"
          color="teal lighten-3"
           dark         
          v-bind="attrs"
          v-on="on"
        >
          Add new Service
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="text-h5">Service Informations</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
             
              <v-col
                cols="12"
                sm="6"
                
              >
                <v-text-field
                  label="Service Name"
                  color="brown"
                  hint="enter the name of the service"
                  :rules="nameRules"
                  :counter="10"
                  required
                  clearable
                  v-model="serviceinfo.servicename"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                
              >
                <v-text-field
                  label="Service Version"
                  color="brown"
                  hint="enter the version of the service"
                  clearable
                  v-model="serviceinfo.serviceversion"
                ></v-text-field>
              </v-col>
             
             
            </v-row>
             <v-row>
             
              <v-col
                cols="12"
                sm="6"
               
              >
                <v-text-field
                  label="Service URL Code"
                  color="brown"
                  hint="enter the github url of the service"
                  clearable
                  v-model="serviceinfo.serviceurl"
                ></v-text-field>
              </v-col>
              <v-col>
                <v-file-input
                  accept=".sql"
                  label="Import SQL Script"
                  color="brown"
                  clearable
                  v-model="serviceinfo.servicesql"
                  @change="handleFileUpload( $event )"
  ></v-file-input>
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
            @click.prevent=" creates()"
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
      valid: false,
       nameRules: [
        v => !!v || 'Name is required',
        v => v.length <= 10 || 'Name must be less than 10 characters',
      ],
      serviceinfo: {
        servicename: '',
        serviceversion: '',
        serviceurl: '',
        servicesql: '',
      },
      file: ''
    }),
    methods: {
      creates: function(){
        var data = new FormData()
        data.append('servicename',this.serviceinfo.servicename)
        data.append('serviceversion',this.serviceinfo.serviceversion)
        data.append('serviceurl',this.serviceinfo.serviceurl)
        data.append('servicesql',this.file)
        axios.post('http://localhost/saasautomation/src/php/addservice.php',data,{
          headers :{
             'Content-Type': 'multipart/form-data'
          }
        })
        .then( res=>{
          console.log(res.data)
        })



        this.dialog = false
      },
      handleFileUpload: function(event){
         this.file = event.target.files[0];
      }
    }
  }
</script>
<style scoped>
 .addservice{
     width: 200px ;
 }
</style>
