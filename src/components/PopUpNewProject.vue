<template>
  <div @click="openPopUp">
    <button class="btn-primary">Create new project</button>
  </div>
  <div v-if="open" class="pop-up">
    <button class="cross" @click="closePopUp">
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
        //axios.post('http://localhost:3000/VueJS_projects/allbanimate.com/backend/index.php?route=create-project', requestBody, config) // DEV
        axios.post('https://allbanimate.com/backend/index.php?route=create-project', requestBody, config) // PROD
        .then(response => {
            
            //Redirect to the newly created graph
            //this.$router.push({ path: `/graph/${response.data}` });
            //console.log(response.data);
            this.$router.push({ path: `/project/${response.data}` });
        })
        .catch(error => {
          console.log(error);
        });
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

  .btn-primary {
    font-size: 1.5rem;
    padding: 1rem;
    border-radius: 2rem;
    border: 2px solid rgb(57, 57, 57);
    background-color: rgb(231, 231, 231);
    transition: background-color 0.1s;
    }

    .btn-primary:hover {
      background-color: var(--selected-background);
    }

  input {
    margin-bottom: 1rem;
  }
    

  .cross {
    background-color: inherit;
    border: 0px solid black;
    position: absolute;
    right: 1rem;
    top: 1rem;
    font-size: 2rem;
  }

  </style>