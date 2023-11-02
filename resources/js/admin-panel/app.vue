<template>
  <div>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="/">Mini Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <router-link to="/signin" class="nav-link">
                Login
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
      <div class="text-center">
        <h1 class="spa">SPA</h1>
        <h6 class="description">Single Page Application</h6>
      </div>
    </div>
  </div>
</template>
  
<script>
import { RouterView } from "vue-router";

export default {
  name: "IndexPage",
  components: {
    RouterView,
  },
};
</script>
  
<style scoped>
.spa {
  font-size: 12rem;
  color: rgb(137, 230, 137);
  position: absolute;
  top: 32%;
  left: 38%;
}

.description {
  font-size: 1.9rem;
  color: rgb(137, 230, 137);
  position: absolute;
  top: 66%;
  left: 38.2%;
}
</style>