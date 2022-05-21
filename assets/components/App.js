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

            {step === 0 && <form className="container">
                <div className="d-block mt-4 mb-md-0">
                    <p className="mb-0">Origine du projet.</p>

                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Region</label>
                        <select className="form-select" id="country" aria-label="Default select example">
                            <option selected="">Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Département</label>
                        <select className="form-select" id="country" aria-label="Default select example">
                            <option selected="">Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Arrondissement</label>
                        <select className="form-select" id="country" aria-label="Default select example">
                            <option selected="">Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Commune</label>
                        <select className="form-select" id="country" aria-label="Default select example">
                            <option selected="">Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
            </form>}

            {step === 1 && <form>
                <div className="d-block mt-4 mb-md-0">
                    <p className="mb-0">Présentation du projet.</p>

                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Intitulé</label>
                        <input type="text" className="form-control" id="email"/>
                    </div>
                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Secteur</label>
                        <select className="form-select" id="country" aria-label="Default select example">
                            <option selected="">Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Objectis</label>
                        <textarea className="form-control" placeholder="Enter your message..." id="textarea"
                                  rows="4"></textarea>
                    </div>
                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Resultats attendus</label>
                        <textarea className="form-control" placeholder="Enter your message..." id="textarea"
                                  rows="4"></textarea>
                    </div>
                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Coût estimatif</label>
                        <input type="number" className="form-control" id="email"/>
                    </div>
                </div>
            </form>}

            {step === 2 && <form className="container">
                <div className="d-block mt-4 mb-md-0">
                    <p className="mb-4">Autres informations.</p>

                    <div className="row container">
                        <div className="form-check col-lg-4 col-sm-6">
                            <input className="form-check-input" type="checkbox" value="" id="defaultCheck10" />
                            <label className="form-check-label" htmlFor="defaultCheck10">
                                Idée de projet
                            </label>
                        </div>
                        <div className="form-check col-lg-4 col-sm-6">
                            <input className="form-check-input" type="checkbox" value="" id="defaultCheck10" />
                            <label className="form-check-label" htmlFor="defaultCheck10">
                                En cours de maturité
                            </label>
                        </div>
                        <div className="form-check col-lg-4 col-sm-6">
                            <input className="form-check-input" type="checkbox" value="" id="defaultCheck10" />
                            <label className="form-check-label" htmlFor="defaultCheck10">
                                Mature
                            </label>
                        </div>
                    </div>

                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Intitulé</label>
                        <input type="text" className="form-control" id="email"/>
                    </div>
                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Secteur</label>
                        <select className="form-select" id="country" aria-label="Default select example">
                            <option selected="">Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Objectis</label>
                        <textarea className="form-control" placeholder="Enter your message..." id="textarea"
                                  rows="4"></textarea>
                    </div>
                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Resultats attendus</label>
                        <textarea className="form-control" placeholder="Enter your message..." id="textarea"
                                  rows="4"></textarea>
                    </div>
                    <div className="mb-4 mt-2">
                        <label className="my-1 me-2" htmlFor="country">Coût estimatif</label>
                        <input type="number" className="form-control" id="email"/>
                    </div>
                </div>
            </form>}
        </>
    );
};

export default App;