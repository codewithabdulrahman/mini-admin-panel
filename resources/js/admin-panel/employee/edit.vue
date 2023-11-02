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
                                    <input type="text" class="form-control custom-input" v-model="empFistName"
                                        :disabled="mode === 'view'" />
                                    <div class="text-danger">{{ errors.empFistName }}</div>
                                </div>
                                <div class="col-md-12">
                                    <h6>Last Name *</h6>
                                    <input type="text" class="form-control custom-input" v-model="empLastName"
                                        :disabled="mode === 'view'" />
                                    <div class="text-danger">{{ errors.empLastName }}</div>
                                </div>
                                <div class="col-md-12">
                                    <h6>Company *</h6>
                                    <select :disabled="mode === 'view'" id="companySelect" class="form-select" v-model="selectedCompany">
                                    <option v-for="company in companies" :value="company.id" :key="company.id">
                                        {{ company.name }}
                                    </option>
                                    </select>
                                    <div class="text-danger">{{ errors.empCompany }}</div>
                                </div>
                                <div class="col-md-12">
                                    <h6>Email</h6>
                                    <input type="email" class="form-control custom-input" v-model="empEmail"
                                        :disabled="mode === 'view'" />
                                </div>
                                <div class="col-md-12">
                                    <h6>Phone</h6>
                                    <input type="phone" class="form-control custom-input" v-model="empPhone"
                                        :disabled="mode === 'view'" />
                                </div>
                                <div class="mt-3">
                                    <button v-if="mode === 'edit'" type="button" class="btn btn-primary"
                                        @click="updateEmployee">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-secondary ms-2" @click="toggleMode">
                                        {{ mode === 'view' ? 'Edit' : 'View' }}
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
import router from "@/router";
import sidebar from "../components/sidebar.vue";
import requestHandler from '../../helper/request';

export default {
    name: "projectDetail",
    data() {
        return {
            companies: [],
            empFistName: "",
            empLastName: "",
            empEmail: "",
            empPhone: "",
            employeeId: "",
            selectedCompany: "",
            isLoading: false,
            mode: 'view',
            errors: {
                empFistName: "",
                empLastName: "",
            },
        };
    },
    components: {
        sidebar,
    },
    mounted() {
        this.employeeId = this.$route.params.employeeId;
        this.fetchEmployee();
        this.fetchCompanies();
    },
    methods: {
        async fetchEmployee() {
            const response = await requestHandler.get(`/employee/${this.employeeId}`);
            if (response.url) {
                router.push({ path: response.url });
            } else {
                const employee = response.employee;
                this.employeeId = employee.id;
                this.empFistName = employee.first_name;
                this.empLastName = employee.last_name;
                this.selectedCompany = employee.company.id;
                this.empEmail = employee.email;
                this.empPhone = employee.phone;
            }
        },
        async fetchCompanies() {
            const response = await requestHandler.get('/company')
            this.companies = response.Companies;
        },
        toggleMode() {
            if (this.mode === 'view') {
                this.mode = 'edit';
            } else {
                this.mode = 'view';
            }
        },
        validateForm() {
            let isValid = true;
            if (!this.empFistName) {
                this.errors.empFistName = "First Name is required.";
                isValid = false;
            } else {
                this.errors.empFistName = "";
            }
            if (!this.empLastName) {
                this.errors.empLastName = "Last Name is required.";
                isValid = false;
            } else {
                this.errors.empLastName = "";
            }
            return isValid;
        },
        async updateEmployee() {
            if (this.validateForm()) {
                this.isLoading = true; // Show loading button
                const empData = {
                    first_name: this.empFistName,
                    last_name: this.empLastName,
                    company_id: this.selectedCompany,
                    email: this.empEmail,
                    phone: this.empPhone,
                }
                try {
                    const response = await requestHandler.put(`/employee/${this.employeeId}`, empData);
                    if (response.url) {
                        router.push(`/${response.url}`);
                    } else {
                        router.push("/empolyees");
                    }
                } catch (error) {
                    // Handle error
                } finally {
                    this.isLoading = false;
                }
            }
        },
    },
};
</script>