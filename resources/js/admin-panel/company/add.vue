<template>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <sidebar />
            <div class="col">
                <div class="container">
                    <h1>Create Company</h1>
                    <form @submit.prevent="createCompany">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="name" v-model="company.name" />
                            <div class="text-danger">{{ errors.name }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" v-model="company.email" />
                            <div class="text-danger">{{ errors.email }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="website" class="form-label">Website Link *</label>
                            <input type="url" class="form-control" id="website" v-model="company.website" />
                            <div class="text-danger">{{ errors.website }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="logo" @change="handleLogoUpload" />
                            <div class="text-danger">{{ errorMessage }}</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

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
    name: "CompanyAdd",
    components: {
        sidebar,
    },
    data() {
        return {
            company: {
                name: "",
                email: "",
                website: "",
                logo: "",
            },
            errorMessage: null,
            errors: {
                name: "",
                email: "",
                website: "",
            },
        }
    },
    methods: {
        validateForm() {
            let isValid = true;
            if (!this.company.name) {
                this.errors.name = "Name is required.";
                isValid = false;
            } else {
                this.errors.name = "";
            }
            if (!this.company.email) {
                this.errors.email = "Email is required.";
                isValid = false;
            } else {
                this.errors.email = "";
            }
            if (!this.company.website) {
                this.errors.website = "Website url is required.";
                isValid = false;
            } else {
                this.errors.website = "";
            }
            return isValid;
        },
        async createCompany() {
            if (this.validateForm()) {
                const formData = new FormData();
                formData.append("name", this.company.name);
                formData.append("email", this.company.email);
                formData.append("website", this.company.website);
                formData.append("logo", this.company.logo);

                try {
                    const response = await requestHandler.post('/company', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                    });
                    router.push("/companies");
                } catch (error) {
                    console.error(error);
                    if (error.response && error.response.data && error.response.data.message) {
                        this.errorMessage = error.response.data.message;
                    }
                }
            }
        },
        handleLogoUpload(event) {
            // Handle logo file upload
            this.company.logo = event.target.files[0];
        },
    },
};

</script>