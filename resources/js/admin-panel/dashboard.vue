<template>
    <router-view></router-view>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <sidebar />
            <div class="col">
                <div id="content">
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        </div>

                        <div class="row">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card custom-card custom-card-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs custom-text-primary text-uppercase mb-1">
                                                    Total Companies
                                                </div>
                                                <div class="h5 mb-0 custom-text-primary font-weight-bold">
                                                    {{ totalCompanies ?? 0 }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-building fa-2x custom-icon-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card custom-card custom-card-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs custom-text-success text-uppercase mb-1">
                                                    Total Employees
                                                </div>
                                                <div class="h5 mb-0 custom-text-success font-weight-bold">
                                                    {{ totalEmployees ?? 0 }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user fa-2x custom-icon-success"></i>
                                            </div>
                                        </div>
                                    </div>
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
import requests from "../helper/request"
import sidebar from "../admin-panel/components/sidebar.vue";
// import router from "@/router";
export default {
    name: "CompanyIndex",
    components: {
        sidebar,
    },
    data() {
        return {
            totalCompanies: '',
            totalEmployees: '',
        };
    },
    mounted() {
        this.fetchStats();
    },
    created() {

    },
    methods: {
        async fetchStats() {
            const response = await requests.get('/getDashboardStats');
            this.totalCompanies = response.companies;
            this.totalEmployees = response.employees;
        }
    }
}
</script>

<style scoped>
#content {
    margin-top: 5%;
}

.custom-card {
    background-color: #f5f5f5;
    border-left: 10px solid transparent;
    transition: background-color 0.3s;
}

.custom-card-primary {
    border-color: #007bff;
}

.custom-card-success {
    border-color: #28a745;
}

.custom-text-primary {
    color: #007bff;
}

.custom-text-success {
    color: #28a745;
}

.custom-icon-primary {
    color: #007bff;
}

.custom-icon-success {
    color: #28a745;
}
</style>