  <template>
    <div class="welcome-container">
      <WelcomeCard/>
      <div class="connect-card">
        <img src="@/assets/allba.png" alt="Allbanimate logo">
        <p>{{ errors }}</p>
        <label for="username">Username</label><br>
        <input type="text" name="username" v-model="username"><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" v-model="password"><br>
        <button @click="connect" class="hover-3">Connexion</button><br>
        <div class="sub-text-1"><p>Or</p></div>
        <button id="lastbtn" @click="connectAsJohnDoe()" class="hover-3"><div class="sub-text-1">Connect as </div>John Doe</button><br>
        <router-link to="/create-account">Create a new account</router-link>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import WelcomeCard from '../components/WelcomeCard';
  
  export default {
    name: 'ConnectView',

    data() {
      return {
        username: "",
        password: "",
        errors: "",
        pageName: "Login Page"
      };
    },

    components: {
      WelcomeCard
    },
  
    methods: {
      connectAsJohnDoe() {
        const requestBody = {
            userName: "John Doe",
            userPassword: "password"
        };

        //axios.post('http://localhost:3000/VueJS_projects/allbanimate.com/backend/index.php?route=connect', requestBody) //DEV
        axios.post('https://allbanimate.thomastestaud.com/backend/index.php?route=connect', requestBody) //PROD
            .then(response => {
              console.log(response.data.token);

              if(response.data.auth){
                const token = response.data.token;
                localStorage.setItem("token", token); // Save the JWT token in local storage
                this.$router.push({ path: `/my-projects` });
              }else{
                this.errors = "Username or password incorrect.";
              }
              
            })
            .catch(error => {
              console.log(error);
            });
          
          
        
      },

      connect() {
        const requestBody = {
            userName: this.username,
            userPassword: this.password
        };

        //axios.post('http://localhost:3000/VueJS_projects/allbanimate.com/backend/index.php?route=connect', requestBody) //DEV
        axios.post('https://allbanimate.thomastestaud.com/backend/index.php?route=connect', requestBody) //PROD
        .then(response => {
          console.log(response.data.token);

          if(response.data.auth){
            const token = response.data.token;
            localStorage.setItem("token", token); // Save the JWT token in local storage
            this.$router.push({ path: `/` });
          }else{
            this.errors = "Username or password incorrect.";
          }
          
        })
        .catch(error => {
          console.log(error);
        });
      }
      
    }
  
  }
  </script>

  <style scoped>

    .welcome-container {
      padding-top: 80px;
      margin: auto;
      display: flex;
      justify-content: space-around;
      height: 100%;
    }
    .connect-card {
      text-align: center;
      /*height: 100%;*/
    }

    .connect-card > * {
      border-radius: 1rem;
    }

    img {
      height: 7rem;
    }

    input {
      margin-bottom: 2rem;
    }
    
    label {
      font-size: 1.5rem;
    }

    button {
      font-size: 1.3rem;
    }

    #lastbtn {
      margin-bottom: 1.5rem;
    }
  </style>