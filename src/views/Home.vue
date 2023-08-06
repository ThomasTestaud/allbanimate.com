  <template>
    
      <projectComponent v-if="response instanceof Object" :projectData="response"/>

      <div v-if="response == true">We are fetching your project...</div>

      <div v-if="response == false">
        <BtnDeconnexion/>
        <h2 @click="fetchProject">Project 1</h2>
        <h2 @click="fetchProject">Project 2</h2>
      </div>

  </template>
  
  <script>
  import projectComponent from '../components/ProjectComponent.vue';
  import axios from 'axios';
  import BtnDeconnexion from '../components/BtnDeconnexion.vue';

  export default {
    name: 'HomeComponent',
    components: {
      projectComponent,
      BtnDeconnexion
    }, 
    data() {
      return {
        response: false,
      }
    },
    methods: {

      fetchProject() {
        this.response = true;

        let response = {
          calkLayers: [
            {
              code: ["", "", "", ""],
              displayed: true,
              onion: true,
              name: "Layer 1",
            },
            {
              code: ["", "", "", ""],
              displayed: true,
              onion: true,
              name: "Layer 2",
            },
          ],
          calkLayersEverCount: 4,
          frameRate: 6,
          drawingToolsData: {
            currentTool: false,
            currentColor: false,
            currentSize: 10,
            currentOpacity: 100,
            currentParticleSize: 3,
            currentDensity: 40,
            currentRGB: [0, 0, 0],
          },
          memoryColorPalette: [{string:"white", rgb: [255,255,255]}, {string:"black", rgb: [0,0,0]},],
          displayedFrame: 0,
          selectedCalk: 0,
          lineWidth: 10,
          onionValue: [1, 5, 10, 100, 10, 5, 1],
          onionLayerState: [false, true, true, true, false, false, false],
        };

        setTimeout(() => {
          this.adaptResponse(response);
        }, 1000);
        
      },

      adaptResponse(response) {
        this.response = response;
        console.log(typeof this.response);
      },

      ajaxRequest() {
        // Retrieve the JWT token from local storage
        const token = localStorage.getItem('token');
        const config = {
          headers: {
            Authorization: `Bearer ${token}`
          }
        };
        axios.get(`http://localhost:3000/VueJS_projects/allbanimate.com/backend/index.php`, config) //DEV
        //axios.get(`https://api-events-on-time.thomastestaud.com/index.php?route=list`, config) //PROD
        .then(response => {
          this.listData = response.data;
          this.requestStatus = "No list has been found for this user..."
        })
        .catch(
          
          error => {
          console.log(error);
          this.$router.push({ path: `/connect/` });
        });
      },

    }
  }
  </script>
  
  <!-- Add "scoped" attribute to limit CSS to this component only -->
  <style scoped>
    
  </style>