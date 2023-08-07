<template>
  <div @click="openPopUp">
    <button>Create new project</button>
  </div>
  <div v-if="open" class="pop-up">
    <button @click="closePopUp">
      X
    </button>
    <h1>New Project</h1>
    <label for="">Project Name</label><br>
    <input type="text" v-model="graphName"><br>
    <button class="hover-3" @click="ajaxRequest">Create</button>
  </div>
</template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'NewGraph',
  
    data() {
      return {
        graphName: "",
        data: [],
        open: false,
      }
    },
  
    mounted() {
    },
  
    methods: {
      
      ajaxRequest() {

        const requestBody = {
            graphName: this.graphName
        };

        const token = localStorage.getItem('token');
        const config = {
          headers: {
            Authorization: `Bearer ${token}`
          }
        };
        axios.post('http://localhost:3000/VueJS_projects/allbanimate.com/backend/index.php?route=create-project', requestBody, config) // DEV
        //axios.post('https://api-events-on-time.thomastestaud.com/index.php?route=create-project', requestBody, config) // PROD
        .then(response => {
            
            //Redirect to the newly created graph
            //this.$router.push({ path: `/graph/${response.data}` });
            console.log(response.data);
            this.$router.push({ path: `/` });
        })
        .catch(error => {
          console.log(error);
        });
      },

      goToGraph(graphId) {
      this.$router.push({ path: `/graph/${graphId}` });
    },

    openPopUp() {
      this.open = true;
    },

    closePopUp() {
      this.open = false;
    },
      
    }
  
  }
  </script>

  <style scoped>

  .view {
    padding-top: 100px;
    /*height: 100%;*/

  }

  input {
    margin-bottom: 1rem;
  }

  </style>