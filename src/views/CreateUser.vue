  <template>
    <div class="view">
      <img src="@/assets/allba.png" alt="Allbanimate logo">
      <p>{{ errors }}</p>
      <label for="">Username</label><br>
      <input type="text" v-model="username"><br>
      <label for="">Password</label><br>
      <input type="password" v-model="password"><br>
      <label for="">Confirm Password</label><br>
      <input type="password" v-model="confirmPassword"><br>
      <button  class="hover-3" @click="verifyPassword">Create account</button><br>
      <router-link to="/connect">I have an account</router-link>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'CreateUser',

    data() {
      return {
        username: "",
        password: "",
        confirmPassword: "",
        errors: "",
        pageName: "Create account"
      };
    },
    components: {
    },
  
    methods: {

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
        axios.post(process.env.VUE_APP_API_URL + 'index.php?route=user', requestBody) // PROD
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
      margin: auto;
      display: flex;
      justify-content: space-around;
      height: 100%;
    }
    .connect-card {
      text-align: center;
      /*height: 100%;*/
    }
    .view {
      padding-top: 80px;
      text-align: center;
      /*height: 100%;*/
    }

    .view > * {
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
      margin-bottom: 1.5rem;
      font-size: 1.3rem;
    }
  </style>