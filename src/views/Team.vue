<template>
  <div class="team">
    <Navbar/>
    <h1 class="subheading grey--text">Team</h1>
    
  </div>
</template>

<script>
// @ is an alias to /src
import Navbar from '@/components/Navbar'
//import Footer from '@/components/Footer'
export default {
  name: 'team',
  components: {
    Navbar,
    //Footer
   
  },
  data : () => ({
   
  }),
}
</script>