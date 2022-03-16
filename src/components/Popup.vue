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
                         @click="getservice(service.service_name)"
                          >
                          <v-list-item-title >
                                   {{service.service_name}}   v{{service.service_version}}      
                          </v-list-item-title>
                        </v-list-item>
                        </v-list-item-group>
                      </v-list>
                    </v-menu>
                  </div>

              </v-col>
              
            </v-row>
            <v-row v-if="hide">
            <v-row v-for="opt in tableau" :key="opt.id">
              <v-col cols="12" sm="4">
                <v-text-field
                          label="Parametre"
                          color="brown"
                          hint="enter the Name of Param"
                         required
                         clearable
                         v-model="opt.key"
                         disabled
                         
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                          label="Value"
                          color="brown"
                          hint="enter the Value of Param"
                         required
                         clearable
                         v-model="dep_opt.value[opt.id]"
                         
                ></v-text-field>
              </v-col>
            </v-row>
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
import YAML from 'yaml'
  export default {
    data: () => ({
      dialog: false,
      saasinfo: {
        saasname: '',
        saasmail: '',
        service: ''
      },
      services: '',
      dep_opt: {
        
        value: [],
        key: []
      },
      tableau:[{
        id: '',
        key: ''
      }],
      service_yaml:'',
      service_opt: '',
      show: false,
      hide: false
     
        
    }),
    methods: {
      create: function(){
        var Cdata = new FormData()
        var jsoncode_image = []
        for (let index = 0; index < this.service_selected.image.length; index++){
           jsoncode_image[index] = JSON.stringify(this.service_selected.image[index])
           Cdata.append('image[]',jsoncode_image[index])
        }
        //var jsoncode_image = JSON.stringify(this.service_selected.image)
        for (let x = 0; x < this.dep_opt.value.length; x++) {
          Cdata.append('dep_opt_key[]',this.tableau[x].key)
          Cdata.append('dep_opt_value[]',this.dep_opt.value[x])
        }
        Cdata.append('version',(this.service_selected.service_version))
        Cdata.append('nginx',this.service_selected.nginx)
        Cdata.append('saasname',this.saasinfo.saasname)
        Cdata.append('saasmail',this.saasinfo.saasmail)
        axios.post('http://localhost/saas/src/php/instance.php',Cdata)
        .then( res=>{
          let objectOrder = {
            version : null,
            services : null
          }
          console.log(Object.assign(objectOrder, JSON.parse(res.data[0].comp)))
          //var yaml = YAML.stringify(jsondec)     
          //console.log(YAML.stringify(JSON.parse(res.data[0].comp)))
          var Xdata = new FormData()
          Xdata.append('yaml',YAML.stringify(Object.assign(objectOrder, JSON.parse(res.data[0].comp))))
          //Xdata.append('json',res.data[0].comp)
          axios.post('http://localhost/saas/src/php/testyaml.php',Xdata)
          .then(rep=>{
            console.log(rep.data)
          })
        })
        this.dialog = false
      },
      getservice: function(service){
          var datum = new FormData()
          datum.append('service',service)
          axios.post('http://localhost/saas/src/php/getservice.php',datum)
          .then(res=>{
           this.service_selected=JSON.parse(res.data[0].comp)
           let j = 0
           var obj = []
           for (let index = 0; index < this.service_selected.image.length; index++) {
             
             for (let i = 0; i < this.service_selected.image[index].option.length; i++){
               if (this.service_selected.image[index].option[i].type == 'Variable Du00e9pendante') {
                  obj[j] = this.service_selected.image[index].option[i]
                  j++
             }
             }
             
           }
           console.log(YAML.stringify(JSON.parse(res.data[0].comp)));
           this.service_opt = obj
           for (let index = 0; index < Object.keys(obj).length; index++) {
             this.dep_opt.key[index] = obj[index].key
             this.tableau[index].id = index
             this.tableau[index].key = obj[index].key
           }
           this.hide = true
           //console.log(this.service_selected.service_version)
           
          })
          //var yaml = YAML.stringify(this.service_selected)
          //var dat = new FormData()
          //dat.append('yaml',yaml)
          
          //axios.post('http://localhost/saas/src/php/yaml.php',dat)
          //.then(rep=>{
                //console.log(rep.data)
         // })
      }
      
    },
     mounted(){
        axios.get('http://localhost/saas/src/php/versions.php')
        .then( response=>{
          var obj = []
          for (let index = 0; index < response.data.length; index++) {
            obj[index] = JSON.parse(response.data[index].comp)
            
          }
          
          //console.log(response.data[0].comp)
          console.log(obj[8])
          this.services = obj
        })
      }
  }
</script>
<style scoped>
 .addclient{
     width: 200px ;
 }
</style>