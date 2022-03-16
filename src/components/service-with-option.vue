<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="900px"
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
           Service With Options
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
                sm="4"
                
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
                sm="4"
                
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
                        <v-col
                        cols="12"
                        sm="4"
                        >
                             <v-text-field
                          label="Image path"
                          color="brown"
                          hint="enter the github url of the image"
                         required
                         clearable
                         v-model="images.path[image-1]"
                         ></v-text-field>
                        </v-col>
                       
                
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
                    <v-col cols="12" sm="12" v-if="hide"><h2>Images Options</h2></v-col>
                    <v-row>
                        <v-col cols="12" sm="4">
                       <v-select
                       :items=[1,2,3,4,5]
                       label="Number Of options"
                       color="brown"
                       v-model="options.number"
                       @change="hiden=true"
                       v-if="hide"
                       >
                       </v-select>
                </v-col>
                    </v-row>
                    <v-row v-if="hiden">
                        <v-row v-for="option in options.number" :key="option">
                             <v-col cols="12" sm="3">
                       <v-select
                       :items=opt
                       label="Type Of Option"
                       color="brown"
                       v-model="options.type[option-1]"
                       @change="type(options.type[option-1],option-1)"
                       >
                       </v-select>
                </v-col>
                <v-col cols="12" sm="3" v-if="stat[option-1]">
                    <v-text-field
                          label="Parametre"
                          color="brown"
                          hint="enter the Name of Param"
                         required
                         clearable
                         v-model="options.key[option-1]"
                         ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" v-if="stat[option-1]">
                    <v-text-field
                          label="Value"
                          color="brown"
                          hint="enter the Value Of Param"
                         required
                         clearable
                         v-model="options.value[option-1]"
                         ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" v-if="va[option-1]">
                    <v-text-field
                          label="Parametre"
                          color="brown"
                          hint="enter the Name of Param"
                         required
                         clearable
                         v-model="options.key[option-1]"
                         ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" v-if="va[option-1]">
                    <v-select
                       :items=images.based
                       label="Related With"
                       color="brown"
                       v-model="options.value[option-1]"
                       >
                       </v-select>
                </v-col>
                 <v-col cols="12" sm="3" v-if="dep[option-1]">
                    <v-text-field
                          label="Parametre"
                          color="brown"
                          hint="enter the Name of Param"
                         required
                         clearable
                         v-model="options.key[option-1]"
                         ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" v-if="dep[option-1]">
                    <v-select
                       :items="['String','Number','Bool','Table','Object']"
                       label="Variable Type"
                       color="brown"
                       v-model="options.value[option-1]"
                       >
                       </v-select>
                </v-col>
                <v-col cols="12" sm="3" v-if="doc[option-1]">
                    <v-text-field
                          label="Name Of the File"
                          color="brown"
                          hint="enter the Value Of Param"
                         required
                         clearable
                         v-model="options.key[option-1]"
                         ></v-text-field>
                </v-col>
                 <v-col cols="12" sm="3" v-if="doc[option-1]">
                <v-file-input
                  
                  label="Import  Script"
                  color="brown"
                  clearable
                  v-model="options.value[option-1]"
                  
  ></v-file-input>
              </v-col>
              <v-col cols="12" sm="3">
                  <v-select
                       :items=images.based
                       label="Option Belong To"
                       color="brown"
                       v-model="options.belong[option-1]"
                       >
                       </v-select>
              </v-col>
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
//import YAML from 'yaml'
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
      },
      hide: false,
      hiden: false,
      va: [],
      stat: [],
      dep: [],
      doc: [],
      opt:['Variable Static','Variable Dépendante','Variable Dynamique','file'],
      
      image_based: ['php:1.0','mysql:1.2','nodejs:1.0','mariadb:1.4'],
      network: ['network'],
      nginx: '',
      hosts:['110.11.45.2','112.4.12.1'],
      images: {
          number: '',
          url:[],
          based:[],
          path:[]
       
      },
      reg: {
        url: '',
        user: '',
        token: ''
      },
      options: {
          number: '',
          type: [],
          key: [],
          value: [],
          belong: []

      },
      select: [],
        items: [
          'Images',
          'URL',
          
        ],
      file: '',
      jsondecode: ''
      
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
        axios.post('http://localhost/saas/src/php/addservice.php',data,{
          headers :{
             'Content-Type': 'multipart/form-data'
          }
        })
        .then( res=>{
          console.log(res.data)
        })



        this.dialog = false
      },
      type: function(e,v){
         if(e == 'Variable Static'){
             this.stat[v] = true
         }
         else if (e == 'Variable Dépendante'){
             this.dep[v]=true
         }
         else if(e == 'file'){
         this.doc[v] = true}
         else if(e == 'Variable Dynamique'){
           this.va[v] = true
         }

         
      },
     
       createImages: function(){
        var dataL = new FormData()
        for (var i = 0; i < this.images.url.length; i++) {
          dataL.append('name[]', this.images.based[i]);
          dataL.append('url[]', this.images.url[i]);
          dataL.append('path[]',this.images.path[i])
          }
        for(var j = 0; j < this.options.number; j++){
          dataL.append('type[]', this.options.type[j])
          dataL.append('key[]', this.options.key[j])
          dataL.append('value[]', this.options.value[j])
          dataL.append('belong[]', this.options.belong[j])

        }  
        dataL.append('optnumber',this.options.number) 
        dataL.append('servicename',this.serviceinfo.servicename)
        dataL.append('serviceversion',this.serviceinfo.serviceversion) 
        dataL.append('imagesnumber',this.images.number)
        dataL.append('regurl',this.reg.url)
        dataL.append('reguser',this.reg.user)
        dataL.append('regtoken',this.reg.token)
        dataL.append('nginx',this.nginx)
        axios.post('http://localhost/saas/src/php/images-service.php',dataL,{
          headers :{
             'Content-Type': 'multipart/form-data'
          }
        })
        .then( res=>{
        
          console.log(res.data)
          
        })



        this.dialog = false
      },
    ndleFileUpload: function(event){
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