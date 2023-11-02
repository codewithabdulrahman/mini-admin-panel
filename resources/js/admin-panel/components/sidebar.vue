<template>
  <section id="sidebar">
    <div class="mt-5 mb-3">
      <h4 class="text-white dash-head"><b>MINI CRM</b></h4>
    </div>

    <ul class="list-unstyled components">
      <li :class="{ 'active': isActive('/dashboard') }" onclick="location.href='/dashboard';">
        <span class="text-white">Dashboard</span>
      </li>
      <li :class="{ 'active': isActive('/empolyees') }" onclick="location.href='/empolyees';">
        <span class="text-white">Employees</span>
      </li>
      <li :class="{ 'active': isActive('/companies') }" onclick="location.href='/companies';">
        <span class="text-white">Companies</span>
      </li>
      <li class="logout" @click="logout">
        <span class="text-white">Logout</span>
      </li>
    </ul>
  </section>
</template>

<script>
import requests from "../../helper/request"
import storage from '../../helper/storage';
export default {
  data() {
    return {
    };
  },
  mounted() {
  },
  created() {
  },
  methods: {
    isActive(route) {
      // Use your route matching logic here
      return window.location.pathname === route;
    },
    async logout() {
      const response = await requests.get('/logout');
      storage.removeToken();
      if (response) {
        // Redirect to the login page or perform any other logout actions
        this.$router.push("/signin");
      }
    },
  },
};
</script>

<style scoped>
.logout {
  position: absolute;
  bottom: 1%;
}

.dash-head {
  border: solid 1px;
  display: flex;
  justify-content: center;
  margin: 10px 10px;
}

#sidebar {
  background-color: #005246 !important;
  width: 13rem;
  height: 100vh;
}

.list-unstyled {
  margin-top: 2rem;
  margin-left: -7%;
  width: 113%;
}

.list-unstyled li {
  list-style: none;
  font-size: 18px;
  padding: 10px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.list-unstyled li:hover {
  background-color: black;
}

.list-unstyled li span {
  width: 100%;
  display: inline-block;
  text-decoration: none;
  margin-left: 2.5rem;
  color: white;
}

@media (max-width: 768px) {
  #sidebar {
    height: 170vh;
    width: 11rem;
  }

}

@media (min-width: 600px) and (max-width: 1024px) {
  #sidebar {
    height: 112vh;
    width: 11rem;
  }
}
</style>