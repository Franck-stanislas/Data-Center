import React, {useState} from 'react';
import axios from "axios";
import {Stepper} from "@mantine/core";
import Localisation from "./Localisation";
import ProjectInfo from "./ProjectInfo";
import OtherInfo from "./OtherInfo";

const Project = () => {
    const [step, setStep] = useState(0);
    const [project, setProject] = useState({});

    const save = () => {
        alert("save");
        axios.post('https://banquedeprojet.minddevelonline.cm/api/project/save', project)
            .then(res => {
                console.log(res);
            })
            .catch(err => {
                console.log(err);
            });
    }

    return (
        <>
            <div className="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                <div className="d-block mb-4 mb-md-0">
                    <nav aria-label="breadcrumb" className="d-none d-md-inline-block">
                        <ol className="breadcrumb breadcrumb-dark breadcrumb-transparent">
                            <li className="breadcrumb-item">
                                <a href="#">
                                    <svg className="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                </a>
                            </li>
                            <li className="breadcrumb-item active" aria-current="page">Ajout projet</li>
                        </ol>
                    </nav>
                    <h2 className="h4">Nouveau projet</h2>
                    <p className="mb-0">Suivez ces etapes.</p>
                </div>
            </div>
            <Stepper active={step} breakpoint="lg" onStepClick={setStep}>
                <Stepper.Step
                    label=""
                    completedIcon={<i className='bx bx-map-pin bx-tada-hover bx-md'/>}
                    icon={<i className='bx bx-map-pin bx-tada-hover bx-md'/>}
                    loading={step === 0}
                />
                <Stepper.Step
                    label=""
                    allowStepClick={false}
                    completedIcon={<i className='bx bx-info-circle bx-tada-hover bx-md'/>}
                    icon={<i className='bx bx-info-circle bx-tada-hover bx-md'/>}
                    loading={step === 1}
                />
                <Stepper.Step
                    label=""
                    completedIcon={<i className='bx bx-dots-horizontal-rounded bx-tada-hover bx-md'/>}
                    icon={<i className='bx bx-dots-horizontal-rounded bx-tada-hover bx-md'/>}
                    loading={step === 2}
                />
            </Stepper>

            {step === 0 && <Localisation setProject={setProject}/>}

            {step === 1 && <ProjectInfo setProject={setProject}/>}

            {step === 2 && <OtherInfo setProject={setProject} />}

            <div className="d-flex justify-content-center">
                <div className="btn-group" role="group" aria-label="Basic outlined example">
                    <button type="button" className="btn btn-outline-primary" onClick={() => setStep((step) => step === 0 ? step : step - 1)}>Prev</button>
                    {step !== 2 && <button type="button" className="btn btn-outline-primary" onClick={() => setStep((step) => step === 2 ? step : step + 1)}>Next</button>}
                    {step === 2 && <button type="button" className="btn btn-outline-secondary" onClick={save}>Save</button>}
                </div>
            </div>

        </>
    );
};

export default Project;