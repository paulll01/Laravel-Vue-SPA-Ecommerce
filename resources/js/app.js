import "bootstrap";

import "../../node_modules/apexcharts/dist/apexcharts.min.js";
import "../../node_modules/chart.js/dist/chart.umd.js";
import "../../node_modules/izitoast/dist/js/iziToast.min";
import "./customize.js";
import "./bootstrap.js";
import "./main.js";

// FilePond core
import * as FilePond from "filepond";

// Optional plugins
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";

// Import styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Register plugins
FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateType
);

// Make FilePond available globally (optional)
window.FilePond = FilePond;
