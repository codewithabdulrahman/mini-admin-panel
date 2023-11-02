<template>
  <div>
    <router-view />
    <div class="container-fluid page-background">
      <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-3">
          <div class="card white-background">
            <div class="card-body py-5">
              <div class="text-center">
                <p id="login_error_message" :class="{ 'd-none': hideWrongCraditionalsMessage, 'text-danger': !isHidden }">
                  Invalid username or password
                </p>
              </div>
              <form @submit.prevent="login">
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input v-model="email" type="email" class="form-control" id="email" placeholder="Enter your email" />
                  <div class="text-danger">{{ emailError }}</div>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input v-model="password" type="password" class="form-control" id="password"
                    placeholder="Enter your password" />
                  <div class="text-danger">{{ passwordError }}</div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <!-- Add any additional content here, e.g., "Remember Me" checkbox -->
                </div>
                <div class="text-end">
                  <button type="submit" class="btn submitbtn" :disabled="isLoading">
                    <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status"
                      aria-hidden="true"></span>
                    <span v-else>Login</span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
  
<script>
import requests from '../../helper/request';
import storage from '../../helper/storage'

export default {
  name: 'LoginComponent',
  data() {
    return {
      email: "",
      password: "",
      hideWrongCraditionalsMessage: true,
      isLoading: false,
      emailError: "",
      passwordError: "",
    };
  },
  methods: {
    async login() {
      try {
        // Reset error messages
        this.emailError = "";
        this.passwordError = "";

        // Perform form validation
        if (!this.email) {
          this.emailError = "Email is required.";
          return;
        }

        if (!this.password) {
          this.passwordError = "Password is required.";
          return;
        }

        this.isLoading = true; // Show loading icon

        const response = await requests.post('/login', {
          email: this.email,
          password: this.password,
        });

        storage.setToken(response.access_token);
        this.$router.push({ name: 'dashboard' });

      } catch (error) {
        this.hideWrongCraditionalsMessage = false;
        console.error('Error fetching data:', error);
      } finally {
        this.isLoading = false; // Hide loading icon (whether success or error)
      }
    },
  }
}
</script>