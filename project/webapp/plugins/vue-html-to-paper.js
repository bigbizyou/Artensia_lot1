import Vue from 'vue';
import VueHtmlToPaper from 'vue-html-to-paper';

const options = {
    "name": "Titre du document",
    "specs": [
      "fullscreen=yes",
      "titlebar=yes",
      "scrollbars=yes"
    ],
    "timeout": 1000,
    "autoClose": true,
    "windowTitle": "Fichier PDF"
}

Vue.use(VueHtmlToPaper , options);
