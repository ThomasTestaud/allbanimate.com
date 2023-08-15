  <template>
    <div class="welcome-container">
      <WelcomeCard/>

      <div v-if="login" class="connect-card">
        <img src="@/assets/allba.png" alt="Allbanimate logo">
        <p>{{ errors }}</p>
        <label for="username">Username</label><br>
        <input type="text" name="username" v-model="username"><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" v-model="password"><br>
        <button @click="connect">Connexion</button><br>
        <div class="sub-text-1"><p>Or</p></div>
        <button class="lastbtn" @click="connectAsJohnDoe()"><div class="sub-text-1">Connect as </div>John Doe</button><br>
        <!--<router-link to="/create-account">Create a new account</router-link>-->
        <a @click="login = false" href="#">Create a new account</a>
      </div>

      <div v-else class="connect-card">
        <img src="@/assets/allba.png" alt="Allbanimate logo">
        <p>{{ errors }}</p>
        <label for="">Username</label><br>
        <input type="text" v-model="username"><br>
        <label for="">Password</label><br>
        <input type="password" v-model="password"><br>
        <label for="">Confirm Password</label><br>
        <input type="password" v-model="confirmPassword"><br>
        <button class="lastbtn" @click="verifyPassword">Create account</button><br>
        <!--<router-link to="/connect">I have an account</router-link>-->
        <a @click="login = true" href="#">I already have an account</a>
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
        pageName: "Login Page",
        login: true,
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
        axios.post('https://allbanimate.com/backend/index.php?route=connect', requestBody) //PROD
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
        axios.post('https://allbanimate.com/backend/index.php?route=connect', requestBody) //PROD
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
      },

      verifyPassword() {
        
        if(this.password === this.confirmPassword){
          this.createAccount();
        }else{
          this.errors = "Please make sure both passwords are the same.";
        }
        
      },
      
      createAccount() {

        const requestBody = {
            userName: this.username,
            userPassword: this.password
        };
        
        //axios.post('http://localhost:3000/VueJS_projects/allbanimate.com/backend/index.php?route=user', requestBody) // DEV
        axios.post('https://allbanimate.com/backend/index.php?route=user', requestBody) // PROD
        .then(response => {

          if(response.data.auth){
            const token = response.data.token;
            localStorage.setItem("token", token); // Save the JWT token in local storage
            this.$router.push({ path: `/` });
          }else{
            this.errors = "This username already exist.";
          }

        })
        .catch(error => {
          console.log(error);
        });
      },
      
    }
  
  }
  </script>

  <style scoped>

    .welcome-container {
      padding-top: 80px;
      padding: 1rem;
      max-width: 1400px;
      margin: auto;
      display: flex;
      justify-content: space-around;
    }
    .connect-card {
      text-align: center;
      padding-top: 80px;
      width: 300px;
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

    .lastbtn {
      margin-bottom: 1.5rem;
    }
    
  </style>