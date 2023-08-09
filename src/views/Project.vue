  <template>
      
      <LoaderElement v-if="response == true" msg="We are fetching your projects..."/>
      <projectComponent v-if="response instanceof Object" :projectData="response"/>

  </template>
  
  <script>
  import projectComponent from '../components/ProjectComponent.vue';
  import axios from 'axios';
  import LoaderElement from '../components/LoaderElement.vue';
  

  export default {
    name: 'HomeComponent',
    components: {
      projectComponent,
      LoaderElement
    }, 

    data() {
      return {
        response: false,
      }
    },

    mounted() {
      this.fetchProject();
    },

    methods: {

      fetchProject() {

        this.response = true;

        // Retrieve the JWT token from local storage
        const token = localStorage.getItem('token');
        const config = {
          headers: {
            Authorization: `Bearer ${token}`
          }
        };
        //axios.get(`http://localhost:3000/VueJS_projects/allbanimate.com/backend/index.php?route=project&projectName=${this.$route.params.name}`, config) //DEV
        axios.get(`https://allbanimate.thomastestaud.com/backend/index.php?route=project&projectName=${this.$route.params.name}`, config) //PROD
        .then(response => {

          this.response = JSON.parse(response.data.data);
          
        })
        .catch(
          
          error => {
          console.log(error);
          //this.$router.push({ path: `/connect/` });
        });
        
      },

    }
  }
  </script>
  
  <!-- Add "scoped" attribute to limit CSS to this component only -->
  <style scoped>
    
  </style>