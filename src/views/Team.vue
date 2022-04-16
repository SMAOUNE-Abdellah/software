<template>
  <div class="team">
    <Navbar :user-infos="getuser.username"/>
    <h1 class="subheading grey--text">Team</h1>
    <Footer/>
  </div>
</template>

<script>
// @ is an alias to /src
import Navbar from '@/components/Navbar'
import Footer from '@/components/Footer'
import { mapGetters } from "vuex";

export default {
  name: 'team',
  components: {
    Navbar,
    Footer
   
  },
   computed: {
    ...mapGetters(["getuser"])
  },
  data : () => ({
   
  }),
}
</script>