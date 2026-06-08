import * as bootstrap from 'bootstrap';
import $ from "jquery";
window.$ = window.jQuery = $;
window.bootstrap = bootstrap;

import DataTable from "datatables.net-bs5";
window.DataTable = DataTable;

document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("header-toggle");
    const nav = document.getElementById("nav-bar");
    const header = document.getElementById("header");

    if (!toggle || !nav || !header) return;

    toggle.addEventListener("click", () => {
        const isOpening = !nav.classList.contains("nav-open");
        nav.classList.toggle("nav-open");
        toggle.classList.toggle("bx-x");
        document.body.classList.toggle("body-pd");
        header.classList.toggle("body-pd");
        if (!isOpening) {
            nav.querySelectorAll(".collapse.show").forEach((el) => {
                bootstrap.Collapse.getOrCreateInstance(el).hide();
            });
        }
    });

    /*===== LINK ACTIVE =====*/
    document.querySelectorAll(".nav_link").forEach((link) => {
        link.addEventListener("click", function () {
            document
                .querySelectorAll(".nav_link")
                .forEach((l) => l.classList.remove("active"));
            this.classList.add("active");
        });
    });
});
