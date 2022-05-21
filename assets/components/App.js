import React, {useState} from 'react';
import {Stepper} from '@mantine/core';

const App = () => {
    const [step, setStep] = useState(0);

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
                <div className="btn-toolbar mb-2 mb-md-0">
                    <a href="#" className="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                        <svg className="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        New Plan
                    </a>
                    <div className="btn-group ms-2 ms-lg-3">
                        <button type="button" className="btn btn-sm btn-outline-gray-600">Share</button>
                        <button type="button" className="btn btn-sm btn-outline-gray-600">Export</button>
                    </div>
                </div>
            </div>
            <Stepper active={step} breakpoint="lg" onStepClick={setStep}>
                <Stepper.Step
                    label=""
                    completedIcon={<i className='bx bx-map-pin bx-tada-hover bx-md'/>}
                    loading={step === 0}
                />
                <Stepper.Step
                    label=""
                    completedIcon={<i className='bx bx-info-circle bx-tada-hover bx-md'/>}
                    loading={step === 1}
                />
                <Stepper.Step
                    label=""
                    completedIcon={<i className='bx bx-dots-horizontal-rounded bx-tada-hover bx-md'/>}
                    loading={step === 2}
                />
            </Stepper>

        </>
    );
};

export default App;