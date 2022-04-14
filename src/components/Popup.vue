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
              
                  <v-col cols="12" sm="6">
                       <v-select
                       :items=host.ip
                       label="deploiement in"
                       color="brown"
                       v-model="ip"
                       >
                       </v-select>
                </v-col>
               



                </v-row>
                <v-row>
                  <v-col cols="12" sm="6">
                       <v-select
                       :items="['SCP']"
                       label="Backup Type"
                       color="brown"
                       v-model="backup.type"
                       >
                       </v-select>
                </v-col>
                 <v-col cols="12" sm="6">
                       <v-select
                       :items="['one a day','one a week','one a month']"
                       label="Backup Number"
                       color="brown"
                       v-model="backup.number"
                       >
                       </v-select>
                </v-col>
             
              </v-row>
             
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
               
            <v-row v-for="ins in service_ins" :key="ins.id">
              <v-col cols="12" sm="4">
                <v-text-field
                          label="Parametre"
                          color="brown"
                          hint="enter the Name of Param"
                         required
                         clearable
                         v-model="ins.key"
                         disabled
                         
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4" v-if="ins.type == 'Variable ENV'">
                <v-text-field
                          label="Value"
                          color="brown"
                          hint="enter the Value of Param"
                         required
                         clearable
                         v-model="ins.final_value"
                         
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4" v-if="ins.type == 'SQL Request'">
                <v-text-field
                          label="Value"
                          color="brown"
                          hint="enter the Value of Param"
                         required
                         clearable
                         v-model="ins.final_value"
                         
                ></v-text-field>
              </v-col>
               <v-col cols="12" sm="4" v-if="ins.type == 'File'">
                <v-file-input
                  
                  label="Import  Script"
                  color="brown"
                  clearable
                  v-model="ins.final_value"
                  
               ></v-file-input>
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
      images:'',
      tableau:[{
        id: '',
        key: ''
      }],
      host:{
        id: [],
        name: [],
        user: [],
        ip: [],
        ps: []
      },
      ip:'',
      
      backup:{
        type: '',
        number: ''
      },
      service_yaml:'',
      service_ins: '',
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
        for (let x = 0; x < this.service_ins.length; x++) {
          if(this.service_ins[x].type == 'Variable ENV'){
          Cdata.append('ins_var_id[]',this.service_ins[x].id)
          Cdata.append('ins_var_type[]',this.service_ins[x].type)
          Cdata.append('ins_var_key[]',this.service_ins[x].key)
          Cdata.append('ins_var_value[]',this.service_ins[x].value)
          Cdata.append('ins_var_fvalue[]',this.service_ins[x].final_value)
          }
          else if(this.service_ins[x].type == 'File'){
            Cdata.append('ins_file_id[]',this.service_ins[x].id)
            Cdata.append('ins_file_key[]',this.service_ins[x].key)
            Cdata.append('ins_file_fvalue[]',this.service_ins[x].final_value)

          }
         else if(this.service_ins[x].type == 'SQL Request'){
           Cdata.append('ins_sql_id[]',this.service_ins[x].id)
           Cdata.append('ins_sql_key[]',this.service_ins[x].key)
           Cdata.append('ins_sql_fvalue[]',this.service_ins[x].final_value)

         } 
        }
        Cdata.append('version',(this.service_selected.service_version))
        Cdata.append('nginx',this.service_selected.nginx)
        Cdata.append('domaine',this.service_selected.domaine)
        Cdata.append('saasname',this.saasinfo.saasname)
        Cdata.append('saasmail',this.saasinfo.saasmail)
        axios.post('http://localhost/saas/src/php/instance2.php',Cdata,{
          headers :{
             'Content-Type': 'multipart/form-data'
          }
        })
        .then( res=>{
          let objectOrder = {
            version : null,
            services : null
          }
          console.log(Object.assign(objectOrder, JSON.parse(res.data)))
          //var yaml = YAML.stringify(jsondec)     
          //console.log(YAML.stringify(JSON.parse(res.data[0].comp)))
          var Xdata = new FormData()
          Xdata.append('yaml',YAML.stringify(Object.assign(objectOrder, JSON.parse(res.data))))
          Xdata.append('name',this.service_selected.service_name)
          Xdata.append('nginx',this.service_selected.nginx)
          Xdata.append('client',this.saasinfo.saasname)
          Xdata.append('backup_type',this.backup.type)
          Xdata.append('backup_number',this.backup.number)
          Xdata.append('ip',this.ip)
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
           var img = []
           for (let index = 0; index < this.service_selected.image.length; index++) {
             img[index] = this.service_selected.image[index].name
              if(this.service_selected.image[index].ins){
             for (let i = 0; i < this.service_selected.image[index].ins.length; i++){
                  obj[j] = this.service_selected.image[index].ins[i]
                  j++
             }
              }
           }
           //console.log(YAML.stringify(JSON.parse(res.data[0].comp)));
           this.service_ins = obj
           this.images = img
          // for (let index = 0; index < (Object.keys(obj)).length; index++) {
           //  this.dep_opt.key[index] = obj[index].key
            // this.tableau[index].id = index
            // this.tableau[index].key = obj[index].key
             console.log(this.images[0])
          // }
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
          console.log(obj[0])
          this.services = obj
         
          //console.log(response.data[0].comp)
          axios.get('http://localhost/saas/src/php/gethost.php')
            .then(res=>{
              var host_id = []
              var host_ip = []
              var host_user = []
              var host_name = []
              var host_ps = []
              for (let x = 0; x < res.data.length; x++){
                host_id[x] = res.data[x].id
                host_ip[x] = res.data[x].ip
                host_user[x] = res.data[x].user
                host_name[x] = res.data[x].name
                host_ps[x] = res.data[x].ps

               // host_ip[x] = JSON.parse(res.data[x].ip)
              }
              for (let i = 0; i < res.data.length; i++) {
                this.host.id[i] = host_id[i]
                this.host.ip[i] = host_ip[i]
                this.host.user[i] = host_user[i]
                this.host.name[i] = host_name[i]
                this.host.ps[i] = host_ps[i]
                
              }
              
              console.log(this.host)
            })
            
        })
       
        
      },
     
  }
</script>
<style scoped>
 .addclient{
     width: 200px ;
 }
</style>
