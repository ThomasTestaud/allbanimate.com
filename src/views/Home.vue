  <template>
      <projectComponent v-if="response instanceof Object" :projectData="response"/>
      <div v-if="response == true">We are fetching your project...</div>
      <div v-if="response == false">
        <div @click="fetchProject">Project 1</div>
        <div @click="fetchProject">Project 2</div>
      </div>
  </template>
  
  <script>
  import projectComponent from '../components/ProjectComponent.vue'

  export default {
    name: 'HomeComponent',
    components: {
      projectComponent
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
      }
     
    }
  }
  </script>
  
  <!-- Add "scoped" attribute to limit CSS to this component only -->
  <style scoped>
    
  </style>