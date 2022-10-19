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

import "./components/i18n";
import React from 'react';
import ReactDOM from 'react-dom';
import Project from "./components/project";
import Carte from "./components/carte";
import ProjectList from "./components/ProjectList";
import EditProject from "./components/project/EditProject";
import RegionalProjectList from "./components/RegionalProjectList";
import Map from "./components/carte";
import { QueryClient, QueryClientProvider, useQuery } from 'react-query'
import RegionProject from "./components/RegionProject";
import ProjectRegional from "./components/RegionProject";
import CommuneProjectList from "./components/CommuneProjectList";

const queryClient = new QueryClient()


if(document.getElementById('root-list-projects')) {
    ReactDOM.render(<ProjectList/>, document.getElementById('root-list-projects'));
}

if(document.getElementById('root-carte-project')) {
    ReactDOM.render(
        <Carte/>, document.getElementById('root-carte-project'));
        // <QueryClientProvider client={queryClient}>
        // </QueryClientProvider>
}

if(document.getElementById('root')) {
    ReactDOM.render(<Project/>, document.getElementById('root'));
}

if(document.getElementById('root-region')) {
    ReactDOM.render(<ProjectRegional/>, document.getElementById('root-region'));
}

if(document.getElementById('root-edit')) {
    ReactDOM.render(<EditProject/>, document.getElementById('root-edit'));
}

if(document.getElementById('root-regional-projet')) {
    ReactDOM.render(<RegionalProjectList/>, document.getElementById('root-regional-projet'));
}

if(document.getElementById('root-communal-projet')) {
    ReactDOM.render(<CommuneProjectList/>, document.getElementById('root-communal-projet'));
}