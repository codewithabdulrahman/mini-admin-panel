<template>
  <div class="container-fluid">
    <div class="row flex-nowrap">
      <sidebar />
      <div class="col">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-6 mt-lg-5">
              <div class="card-body">
                <div class="col-md-12">
                  <h6>First Name *</h6>
                  <input type="text" class="form-control custom-input" v-model="employee.firstName" required />
                  <div class="text-danger">{{ errors.empFistName }}</div>
                </div>
                <div class="col-md-12">
                  <h6>Last Name *</h6>
                  <input type="text" class="form-control custom-input" v-model="employee.lastName" required />
                  <div class="text-danger">{{ errors.empLastName }}</div>
                </div>
                <div class="col-md-12">
                  <h6>Company *</h6>
                  <select id="companySelect" class="form-select" v-model="employee.selectedCompany" required>
                    <option v-for="company in companies" :value="company.id" :key="company.id">
                      {{ company.name }}
                    </option>
                  </select>
                  <div class="text-danger">{{ errors.empCompany }}</div>
                </div>
                <div class="col-md-12">
                  <h6>Email</h6>
                  <input type="email" class="form-control custom-input" v-model="employee.email" />
                </div>
                <div class="col-md-12">
                  <h6>Phone</h6>
                  <input type="phone" class="form-control custom-input" v-model="employee.phone" />
                </div>
                <div class="mt-3">
                  <button type="button" class="btn btn-primary" @click="saveEmployee">
                    Save
                  </button>
                </div>
              </div>
            </div>
          </div>
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
  name: "add",
  data() {
    return {
      employee: {
        firstName: "",
        lastName: "",
        email: "",
        phone: "",
        company: "",
        selectedCompany: ''
      },
      companies: [],
      isLoading: false,
      errors: {
        empFistName: "",
        empLastName: "",
        empCompany: "",
      },
    };
  },
  components: {
    sidebar,
  },
  mounted() {
    this.fetchCompanies();
  },
  methods: {
    async fetchCompanies() {
      const response = await requestHandler.get('/company')
      this.companies = response.Companies;
    },
    validateForm() {
      let isValid = true;
      if (!this.employee.firstName) {
        this.errors.empFistName = "First Name is required.";
        isValid = false;
      } else {
        this.errors.empFistName = "";
      }
      if (!this.employee.lastName) {
        this.errors.empLastName = "Last Name is required.";
        isValid = false;
      } else {
        this.errors.empLastName = "";
      }
      if (!this.employee.selectedCompany) {
        this.errors.empCompany = "Company is required.";
        isValid = false;
      } else {
        this.errors.empCompany = "";
      }
      return isValid;
    },
    async saveEmployee() {
      if (this.validateForm()) {
        const empData = {
          first_name: this.employee.firstName,
          last_name: this.employee.lastName,
          company_id: this.employee.selectedCompany,
          email: this.employee.email,
          phone: this.employee.phone,
        };
        try {
          const response = await requestHandler.post("/employee", empData);
          router.push("/empolyees");
        } catch (error) {
          console.error(error);
        }
      }
    },
  },
};
</script>