<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="800px"
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
                md="4"
              >
                <v-text-field
                  label="Saas Name"
                  hint="example of helper text only on focus"
                  v-model="saasinfo.saasname"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="4"
              >
                <v-text-field
                  label="Saas Login"
                  hint="example of persistent helper text"
                  persistent-hint
                  required
                  v-model="saasinfo.saaslogin"
                ></v-text-field>
              </v-col>
               <v-col
                cols="12"
                sm="6"
                md="4"
              >
                <v-text-field
                  label="Saas Password"
                  hint="example of persistent helper text"
                  persistent-hint
                  required
                  v-model="saasinfo.saasmp"
                ></v-text-field>
              </v-col>
             
              <v-col cols="12">
                <v-text-field
                  label="Password*"
                  type="password"
                  required
                  v-model="saasinfo.password"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
              >
                <v-autocomplete
                  :items="['Oracle', 'MySQL', 'PostgreSQL', 'MongoDB', 'IBM DB2', 'SQLite', 'Microsoft SQL Server', 'Cassandra']"
                  label="Database"
                  
                  multiple
                  v-model="saasinfo.db"
                ></v-autocomplete>
              </v-col>
              <v-col
                cols="12"
                sm="6"
              >
                <v-autocomplete
                  :items="['Apache', 'Nginx', 'BusyBox', 'Monkey Web Server', 'Node JS', 'Zeus Web Server', 'Hiawatha', 'Tomcat']"
                  label="Web Server"
                  multiple
                  v-model="saasinfo.server"
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
            @click=" create()"
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
        saaslogin: '',
        saasmp: '',
        password: '',
        server: [],
        db: []
      }
    }),
    methods: {
      create: function(){
        var Cdata = new FormData()
        Cdata.append('saasname',this.saasinfo.saasname)
        Cdata.append('saaslogin',this.saasinfo.saaslogin)
        Cdata.append('saasmp',this.saasinfo.saasmp)
        Cdata.append('server',this.saasinfo.server)
        Cdata.append('db',this.saasinfo.db)
        axios.post('http://localhost/pfe-backend/client.php?action=addclient',Cdata)
        .then( res=>{
          console.log(res.data)
        })



        this.dialog = false
      }
    }
  }
</script>