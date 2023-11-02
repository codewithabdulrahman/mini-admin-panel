<template>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <sidebar />
            <div class="col">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 mt-lg-5">
                            <div class="card-body">
                                <div v-if="mode === 'view'" class="col-md-2" style="float: right;">
                                    <img :src="logoFile" :width="80" :height="80">
                                </div>
                                <div class="col-md-7">
                                    <h6>Company Name *</h6>
                                    <input type="text" class="form-control custom-input" v-model="companyName"
                                        :disabled="mode === 'view'" />
                                    <div class="text-danger">{{ errors.companyName }}</div>
                                </div>
                                <div class="col-md-12">
                                    <h6>Company Email *</h6>
                                    <input type="email" class="form-control custom-input" v-model="companyEmail"
                                        :disabled="mode === 'view'" />
                                        <div class="text-danger">{{ errors.companyEmail }}</div>
                                </div>
                                <div v-if="mode != 'view'" class="col-md-12">
                                    <h6>Company Logo </h6>
                                    <input type="file" @change="handleFileUpload" accept="image/*"
                                        :disabled="mode === 'view'" />
                                        <div class="text-danger">{{ errorMessage }}</div>
                                </div>
                                <div class="col-md-12">
                                    <h6>Company Website *</h6>
                                    <input type="email" class="form-control custom-input" v-model="companyWebsite"
                                        :disabled="mode === 'view'" />
                                        <div class="text-danger">{{ errors.companyWebsite }}</div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button v-if="mode === 'edit'" type="button" class="btn btn-primary" @click="updateCompany">
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
</template>
  
<script>
import router from "@/router";
import sidebar from "../components/sidebar.vue";
import requestHandler from '../../helper/request';

export default {
    name: "companyDetail",
    data() {
        return {
            companyId: "",
            companyName: "",
            companyEmail: "",
            companyWebsite: "",
            logoFile: null,
            isLoading: false,
            mode: 'view',
            errorMessage: null,
            errors: {
                companyName: "",
                companyEmail: "",
                companyWebsite: "",
            },
        };
    },
    components: {
        sidebar,
    },
    created() {
        this.companyId = this.$route.params.companyId;
    },
    mounted() {
        this.fetchCompany();
    },
    methods: {
        toggleMode() {
            if (this.mode === 'view') {
                this.mode = 'edit';
            } else {
                this.mode = 'view';
            }
        },
        validateForm() {
            let isValid = true;
            if (!this.companyName) {
                this.errors.companyName = "Company Name is required.";
                isValid = false;
            } else {
                this.errors.companyName = "";
            }
            if (!this.companyEmail) {
                this.errors.companyEmail = "Company Email is required.";
                isValid = false;
            } else {
                this.errors.companyEmail = "";
            }
            if (!this.companyWebsite) {
                this.errors.companyWebsite = "Website url is required.";
                isValid = false;
            } else {
                this.errors.companyWebsite = "";
            }
            return isValid;
        },
        async fetchCompany() {
            const response = await requestHandler.get(`/company/${this.companyId}`);
            if (response.url) {
                router.push({ path: response.url });
            } else {
                const company = response.company;
                this.companyId = company.id;
                this.companyName = company.name;
                this.companyEmail = company.email;
                this.companyWebsite = company.website;
                this.logoFile = company.logo;
                const url = window.location.href + '/' + this.logoFile;
                const updatedURL = url.replace(`/viewCompany/${this.companyId}`, '');
                this.logoFile = updatedURL;
            }
        },
        async updateCompany() {
            if (this.validateForm()) {
                this.isLoading = true;
                const formData = new FormData();
                formData.append("name", this.companyName);
                formData.append("email", this.companyEmail);
                formData.append("website", this.companyWebsite);
                if (this.logoFile) {
                    formData.append("logo", this.logoFile);
                }
                try {
                    const response = await requestHandler.post(`/company/${this.companyId}`, formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    });
                    if (response.url) {
                        router.push(`/${response.url}`);
                    } else {
                        router.push("/companies");
                    }
                } catch (error) {
                    if (error.response && error.response.data && error.response.data.message) {
                        this.errorMessage = error.response.data.message;
                    }
                } finally {
                    this.isLoading = false;
                }
            }
        },
        handleFileUpload(event) {
            // Handle logo file upload
            this.logoFile = event.target.files[0];
        },
    },
};
</script>