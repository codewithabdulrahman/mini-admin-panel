import "./bootstrap";
import { createApp } from "vue";
import router from "./router/index";

import home from "./admin-panel/home.vue";
createApp(home).use(router).mount("#app");