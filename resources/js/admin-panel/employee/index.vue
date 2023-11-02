<template>
  <div class="container-fluid">
    <div class="row flex-nowrap">
      <sidebar />
      <div class="col">
        <div class="d-flex align-items-center justify-content-between header">
          <h1 class="d-inline-block">Employees</h1>
          <a href="/addEmployee" class="btn-add">Add New</a>
        </div>
        <div class="Employee-container">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Company</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col" colspan="3">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="Employees.length === 0">
                <td colspan="8">No data available</td>
              </tr>
              <!-- Render table rows if Employees array is not empty -->
              <tr v-else v-for="Employee in Employees.slice().reverse()" :key="Employee.id">
                <td>{{ Employee.first_name }}</td>
                <td>{{ Employee.last_name }}</td>
                <td>{{ Employee.company.name }}</td>
                <td>{{ Employee.email }}</td>
                <td>{{ Employee.phone }}</td>
                <td>
                  <button class="btn btn-info m-1" @click="viewEmployee(Employee.id)">View</button>
                  <button class="btn btn-danger m-1" @click="deleteEmployee(Employee.id)">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
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
  name: "EmployeeIndex",
  components: {
    sidebar,
  },
  data() {
    return {
      Employees: [],
      dataTable: null,
    };
  },
  computed: {
  },
  created() {
  },
  mounted() {
    this.fetchEmployees();
  },
  methods: {
    async fetchEmployees() {
      const response = await requestHandler.get('/employee')
      this.Employees = response.employees;
    },
    async deleteEmployee(employeeId) {
      const response = await requestHandler.delete(`/employee/${employeeId}`);
      if (response) {
        this.fetchEmployees();
      }
    },
    viewEmployee(employeeId) {
      router.push({ name: "viewEmployee", params: { employeeId } });
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
  color: #FFFFFF;
  text-decoration: none;
}

.btn-add:hover {
  background-color: #005246;
}

.btn-info {
  background-color: #005246;
  color: #FFFFFF;
}

.Employee-container {
  overflow-y: scroll;
  height: 70vh;
  margin: 4% 1% 0% 1%;
}

.Employee-container::-webkit-scrollbar {
  width: 0px;
}</style>