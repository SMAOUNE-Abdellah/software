<template>
   <nav>
       <v-app-bar  color="brown" dark app >
           <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
           <v-toolbar-title class="text-uppercase ">
               <span class="font-weight-light">SAASI</span>
           </v-toolbar-title>
           <v-spacer></v-spacer>
           <v-menu offset-y>
      <template v-slot:activator="{ on }">
        <v-btn
          text
          v-on="on"
        >
          <v-icon left>expand_more</v-icon>
            <span>Menu</span>
        </v-btn>
      </template>
      <v-list flat>
        <v-list-item v-for="link in links"  :key="link.text" router :to="link.route" active-class="border">
          <v-list-item-title >{{link.text}}</v-list-item-title>
        </v-list-item>
      </v-list>
            </v-menu>
            <v-btn text @click="exit()">
                <span>Exit</span>
                <v-icon right>exit_to_app</v-icon>
             </v-btn>
       </v-app-bar>
      <v-navigation-drawer  v-model="drawer" dark app class="brown darken-4">
          <v-layout column align-center>
               <v-flex class="mt-5"> 
                    <v-avatar size="100">
                            <img src="/img1.png" alt="">
                    </v-avatar>
                    <p class="white--text subheading mt-1 text-center">{{userInfos}}</p>
               </v-flex>
               <v-flex class="mt-4 mb-4">
                  <Client />
                </v-flex>
                <v-flex class="mt-4 mb-4">
                  <Popup />
                </v-flex>
                
                <v-flex class="mt-4 mb-4">
                  <ServiceOpt />
                </v-flex>
                <v-flex class="mt-4 mb-4">
                  <Hosts />
                </v-flex>
                
          </v-layout>
          <v-list flat>
              <v-list-item v-for="link in links"  :key="link.text" router :to="link.route" active-class="border">
                  <v-list-item-action>
                     <v-icon >{{link.icon}}</v-icon>
                  </v-list-item-action>
                  <v-list-item-content >
                      <v-list-item-title >{{link.text}}</v-list-item-title>
                  </v-list-item-content>
              </v-list-item>
          </v-list>
      </v-navigation-drawer>
      <div>
          <div>
      <v-alert
        type="success"
        dismissible
        shaped
        outlined
        v-if="service_success.status">
        The Service {{service_success.data}}  Was Created
      </v-alert>
      <div class="text-center">
         <v-btn
        v-if="!alert2"
        dark
        @click="alert2 = true"
      >
        Reset Alert
      </v-btn>
      </div>
      </div>
         <div>
      <v-alert
        type="success"
        dismissible
        shaped
        outlined
        v-if="client_success.status">
        The Client {{client_success.data}}  Was Created
      </v-alert>
      <div class="text-center">
         <v-btn
        v-if="!alert1"
        dark
        @click="alert1 = true"
      >
        Reset Alert
      </v-btn>
      </div>
      </div>
      <div>
      <v-alert
        type="success"
        dismissible
        shaped
        outlined
        v-if="host_success.status">
        Host With IP Address {{host_success.data}} Was Created
      </v-alert>
      <div class="text-center">
         <v-btn
        v-if="!alert"
        dark
        @click="alert = true"
      >
        Reset Alert
      </v-btn>
      </div>
      </div>
      </div>
   </nav>
</template>
<script>
import Popup from './Popup.vue'
import Client from './Client.vue'
import {EventBus} from '@/EventBus'
//import Services from './services.vue'
import Hosts from './hosts.vue'
import ServiceOpt from './service-with-option.vue'
import { mapMutations } from "vuex";

export default {
   props: ["userInfos"],
   data: () => ({
      drawer: true,
      alert: true,
      alert1: true,
      alert2: true,
      host_success:{
        status: false,
        data: ''
      },
      client_success:{
        status: false,
        data: ''
      },
      service_success:{
        status: false,
        data: ''
      },
      links :[
          {icon: 'dashboard', text:'Dashboard', route: '/dashboard'},
          {icon: 'folder', text:'My Project', route: '/projects'},
          {icon: 'person', text:'Team', route: '/team'}
      ],
     
    }),
  
 
    methods :{
      ...mapMutations(["setUser", "setToken"]),
      exit: function(){
        this.setUser(null);
        this.setToken(null);
        this.$router.push('/')
      },
    
    },
     mounted(){
       EventBus.$on('host-created', data =>{
         this.host_success.status = true
         this.host_success.data = data
        
       })
        EventBus.$on('client-created', data =>{
          console.log(data)
         this.client_success.status = true
         this.client_success.data = data
        
       })
       EventBus.$on('service-created', data =>{
          console.log(data)
         this.service_success.status = true
         this.service_success.data = data
        
       })
    },
    components: {
    Popup,
    //Services,
    Hosts,
    Client,
    ServiceOpt
  },
   
}
</script>
<style scoped>
.border {
  border-left: 4px solid #0ba518;
}

</style>