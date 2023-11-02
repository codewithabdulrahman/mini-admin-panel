<template>
  <div class="container-fluid">
    <div class="row flex-nowrap">
      <sidebar />
      <div class="col">
        <div class="d-flex align-items-center justify-content-between header">
          <h1 class="d-inline-block">Companies</h1>
          <a href="/addCompany" class="btn-add">Add New</a>
        </div>
        <div class="Company-container">
          <!-- start -->
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Logo</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Website</th>
                <th scope="col" colspan="2">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Check if Companies array is empty -->
              <tr v-if="Companies.length === 0">
                <td colspan="6">No data available</td>
              </tr>
              <!-- Render table rows if Companies array is not empty -->
              <tr v-else v-for="Company in Companies.slice().reverse()" :key="Company.id">
                <td>
                  <img :src="Company.logo" :width="50" :height="50">
                </td>
                <td>{{ Company.name }}</td>
                <td>{{ Company.email }}</td>
                <td>{{ Company.website }}</td>
                <td>
                  <button class="btn btn-info m-1" @click="viewCompany(Company.id)">View</button>
                  <button class="btn btn-danger m-1" @click="deleteCompany(Company.id)">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- end -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import requestHandler from "../../helper/request"
import sidebar from "../components/sidebar.vue";
import router from "@/router";


export default {
  name: "CompanyIndex",
  components: {
    sidebar,
  },
  data() {
    return {
      Companies: [],
      dataTable: null,
    };
  },
  computed: {
  },
  created() {
  },
  mounted() {
    this.fetchCompanies();
  },
  methods: {
    async fetchCompanies() {
      const response = await requestHandler.get('/company')
      this.Companies = response.Companies;
      this.Companies.forEach(company => {
        const url = window.location.href + '/' + company.logo;
        const updatedURL = url.replace('/companies', '');
        company.logo = updatedURL;
      });
    },


    async deleteCompany(companyId) {
      const response = await requestHandler.delete(`/company/${companyId}`);
      if (response) {
        this.fetchCompanies();
      }
    },

    viewCompany(companyId) {
      router.push({ name: "viewCompany", params: { companyId } });
    }
  },
};

</script>

<style scoped>
tr th,
td {
  text-align: center !important;
}

.header {
  margin: 4% 1% 0% 1%;
}

.btn-add {
  background-color: green;
  padding: 7px 10px;
  border-radius: 5px;
  color: #ffffff;
  text-decoration: none;
}

.btn-add:hover {
  background-color: #005246;
}

.btn-info {
  background-color: #005246;
  color: #ffffff;
}
</style>
