/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import React from 'react';
import ReactDOM from 'react-dom';
import Project from "./components/project";
import Carte from "./components/carte";
import ProjectList from "./components/ProjectList";


if(document.getElementById('root-list-projects')) {
    ReactDOM.render(<ProjectList/>, document.getElementById('root-list-projects'));
}

if(document.getElementById('root-carte-project')) {
    ReactDOM.render(<Carte/>, document.getElementById('root-carte-project'));
}

if(document.getElementById('root')) {
    ReactDOM.render(<Project/>, document.getElementById('root-carte-project'));
}