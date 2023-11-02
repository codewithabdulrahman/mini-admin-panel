import axios from "axios";
import storage from "./storage";

axios.defaults.baseURL = "/api";

const requestHandler = {
    // GET request
    async get(endpoint, params = {}) {
        try {
            const token = storage.getToken();
            const response = await axios.get(endpoint, {
                params,
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });

            if (response.data) {
                return response.data;
            } else {
                return response;
            }
        } catch (error) {
            handleRequestError(error);
            throw error;
        }
    },

    // POST request
    async post(endpoint, data = {}) {
        try {
            const token = storage.getToken();
            const response = await axios.post(endpoint, data, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });
            return response.data;
        } catch (error) {
            handleRequestError(error);
            throw error;
        }
    },

    // PUT request
    async put(endpoint, data = {}) {
        try {
            const token = storage.getToken();
            const response = await axios.put(endpoint, data, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });
            return response.data;
        } catch (error) {
            handleRequestError(error);
            throw error;
        }
    },

    // DELETE request
    async delete(endpoint) {
        try {
            const token = storage.getToken();
            const response = await axios.delete(endpoint, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });
            return response.data;
        } catch (error) {
            handleRequestError(error);
            throw error;
        }
    },
};

function handleRequestError(error) {
    if (error.response && error.response.status === 401) {
        storage.removeToken();
        window.location.href = "/signin";
    }
}
export default requestHandler;