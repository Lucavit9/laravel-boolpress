console.log("Ok Js:)");
//Chiamata Bootstrap
require("./bootstrap");

//Chiamata axios
window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.Vue = require("vue");

import AppComponent from "./app/AppComponent";

import router from "./routes";

const app = new Vue({
    el: "#app",
    render: (h) => h(AppComponent),
    router,
});
