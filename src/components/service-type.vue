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
           Add New Service 
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
                <v-col cols="12">
                     <v-combobox
                      v-model="select"
                      :items="items"
                      label="Service Type"
                      color="brown"
                      outlined
                      clearable
                      
                      >
                      </v-combobox>
                </v-col>
            </v-row>
             <v-row v-if="select == ['URL']">
             


                <!-- partie à copié-->
                
            
             <!-- partie à copié-->


            </v-row>
            <v-row v-if="select == ['Images']">
                <v-row>
                   <v-col cols="12" sm="6">
                       <v-select
                       :items=[1,2,3,4,5]
                       label="Number Of Images"
                       color="brown"
                       v-model="images.number"
                       @change="hide=true"
                       >
                       </v-select>
                </v-col>
                 <v-col cols="12" sm="12" v-if="hide"><h2>Registry Informations</h2></v-col>
                </v-row>
                
                <v-row v-if="hide">
                
                  <v-col cols="12" sm="4">
                     <v-text-field
                          label="URL Registry"
                          color="brown"
                          hint="enter the url of the registry"
                         required
                         clearable
                         v-model="reg.url"
                         ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="4">
                     <v-text-field
                          label="User Name"
                          color="brown"
                          hint="enter the user of the registry"
                         required
                         clearable
                         v-model="reg.user"
                         ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="4">
                     <v-text-field
                          label="Token Registry"
                          color="brown"
                          hint="enter the token of the repositry"
                         required
                         clearable
                         v-model="reg.token"
                         ></v-text-field>
                  </v-col>
               
                </v-row>
                
                  <v-col cols="12" sm="12" v-if="hide"><h2>Images Informations</h2></v-col>

                <v-row v-for="image in images.number" :key="image">

                    <v-row>
                      <v-col
                        cols="12"
                        sm="4"
                        >
                         <v-select
                       :items=image_based
                       label="Based image"
                       color="brown"
                       v-model="images.based[image-1]"
                      
                       >
                       </v-select>
                        </v-col>
                      
                        <v-col
                        cols="12"
                        sm="4"
                        >
                             <v-text-field
                          label="Image URL"
                          color="brown"
                          hint="enter the github url of the image"
                         required
                         clearable
                         v-model="images.url[image-1]"
                         ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="4">
                       <v-select
                       :items=[1,2,3,4,5]
                       label="Number Of Options"
                       color="brown"
                       v-model="images.optionnumber[image-1]"
                       
                       >
                       </v-select>
                </v-col>
                <v-row v-for="option in images.optionnumber[image-1]" :key="option">
                  <v-row >
                  <v-col cols="12" sm="4">
                       <v-select
                       :items=opt
                       label="Type Of Option"
                       color="brown"
                       
                        v-model="images.options[(image-1)][option-1]"
                        

                       >
                       </v-select>
                </v-col>
                </v-row>
                </v-row>
                      
 <!-- 

                        <v-col
                        cols="12"
                        sm="4"
                        v-if="sqldata[image-1]"
                        >
                         <v-text-field
                          label="DB Name"
                          color="brown"
                         required
                         clearable
                         v-model="images.dbname"
                         ></v-text-field>
                        </v-col>
                        
            -->             
                    </v-row>
                   
                </v-row>
                 <v-row   v-if="hide">
                    <v-col cols="12" sm="6">
                       <v-select
                       :items=network.concat(images.based)
                       label="Nginx Connection With"
                       color="brown"
                       v-model="nginx"
                       >
                       </v-select>
                </v-col>
                <v-col cols="12" sm="6">
                       <v-select
                       :items=hosts
                       label="deploiement in"
                       color="brown"
                       
                       >
                       </v-select>
                </v-col>
                 
                </v-row>
               
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            class="validation"
            color="brown darken-1"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>
          <v-btn
            class="validation"
            color="brown darken-1"
            text
            @click.prevent=" creates()"
            v-if="select == ['URL']"
          >
            Save
          </v-btn>
           <v-btn
            class="validation"
            color="brown darken-1"
            text
            @click.prevent=" createImages()"
            v-if="select == ['Images']"
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
        based: [],
        
      },
      hide: false,
      hoption: false,
      
      sqldata: [],
      opt:['Variable Static','Variable Dynamique','file'],
      
      image_based: ['php','mysql','node js','maria db'],
      network: ['network'],
      nginx: '',
      hosts:['110.11.45.2','112.4.12.1'],
      images: {
          number: '',
          url:[],
          based:[],
          optionnumber:[],
          options:[[]],
          dbname: '',
          dbps: ''
           
      },
      reg: {
        url: '',
        user: '',
        token: ''
      },
      select: [],
        items: [
          'Images',
          'URL',
          
        ],
      file: '',
      
    }),
    methods: {
      creates: function(){
        var data = new FormData()
        for (var i = 0; i < this.images.url.length; i++) {
          data.append('based[]', this.serviceinfo.based[i]);
          data.append('serviceurl[]', this.images.serviceurl[i]);
          }
        data.append('servicename',this.serviceinfo.servicename)
        data.append('serviceversion',this.serviceinfo.serviceversion)
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
      based: function(){
         
      },
     
       createImages: function(){
        var dataL = new FormData()
        for (var i = 0; i < this.images.url.length; i++) {
          dataL.append('name[]', this.images.based[i]);
          dataL.append('url[]', this.images.url[i]);
          }
        dataL.append('dbname', this.images.dbname);  
        dataL.append('dbps', this.images.dbps);  
        dataL.append('servicename',this.serviceinfo.servicename)
        dataL.append('serviceversion',this.serviceinfo.serviceversion) 
        dataL.append('imagesnumber',this.images.number)
        dataL.append('regurl',this.reg.url)
        dataL.append('reguser',this.reg.user)
        dataL.append('regtoken',this.reg.token)
        dataL.append('nginx',this.nginx)
        axios.post('http://localhost/saasautomation/src/php/images-service.php',dataL)
        .then( res =>{
            console.log(res.data)

        })
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
 .validation:hover{
   background-color: brown;
   color: white !important;
 }
 h2{
   margin-bottom: 10px;
 }
</style>
