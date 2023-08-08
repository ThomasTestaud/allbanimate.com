  <template>

    <div class="parameter-bar">
      <BtnDeconnexion/>
    </div>
      
      <div class="container">
        <NewProject/>

        <template v-if="projectList.length > 0">
          <div class="clickable-card" v-for="project in projectList" @click="openProject(project.name)" :key="project">
            <h2>{{ project.name }}</h2>
            <p>Last save: {{ project.last_save }}</p>
          </div>
        </template>

        <div v-else>
          We are fetching your projects...
        </div>
      </div>

  </template>
  
  <script>
  import axios from 'axios';
  import BtnDeconnexion from '../components/BtnDeconnexion.vue';
  import NewProject from '../components/PopUpNewProject.vue';

  export default {
    name: 'MyProjects',
    components: {
      BtnDeconnexion,
      NewProject
    }, 
    data() {
      return {
        projectList: false,
      }
    },
    mounted() {
      this.fetchProjectList();
    },

    methods: {

      fetchProjectList() {
        // Retrieve the JWT token from local storage
        const token = localStorage.getItem('token');
        const config = {
          headers: {
            Authorization: `Bearer ${token}`
          }
        };
        axios.get(`http://localhost:3000/VueJS_projects/allbanimate.com/backend/index.php?route=project-list`, config) //DEV
        //axios.get(`https://api-events-on-time.thomastestaud.com/index.php?route=list`, config) //PROD
        
        .then(response => {
          this.projectList = response.data;
          this.requestStatus = "No list has been found for this user...";
        })

        .catch(
          error => {
          console.log(error);
          //this.$router.push({ path: `/connect/` });
        });
      },

      openProject(project) {
        this.$router.push({ path: `/project/${project}` });
      },

    }
  }
  </script>
  
  <!-- Add "scoped" attribute to limit CSS to this component only -->
  <style scoped>
    .container {
      margin: 2rem;
    }

    .clickable-card {
      border: 2px solid rgb(57, 57, 57);
      margin-top: 1rem;
      padding: 1rem;
      border-radius: 1rem;
      background-color: rgb(186, 186, 186);
      cursor: pointer;
      transition: background-color 0.1s;
    }

    .clickable-card:hover {
      background-color: var(--selected-background);
    }
  </style>