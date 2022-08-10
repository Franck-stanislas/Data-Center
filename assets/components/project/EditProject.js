import React, {useEffect, useState} from 'react';
import axios from "axios";
import {Stepper} from "@mantine/core";
import Localisation from "./Localisation";
import ProjectInfo from "./ProjectInfo";
import OtherInfo from "./OtherInfo";
import EditProjectInfo from "./EditProjectInfo";
import EditOtherInfo from "./EditOtherInfo";

const EditProject = () => {
    const [step, setStep] = useState(1);
    const [project, setProject] = useState({});
    const [categories, setCategories] = useState([]);
    const [statuts, setStatuts] = useState([]);
    const [maturites, setMaturites] = useState([]);
    const [elements, setElements] = useState([]);
    const [financements, setFinancements] = useState([]);
    const [type, setType] = useState("");

    useEffect(() => {
        axios.get('https://banquedeprojet.minddevelonline.cm/api/status')
            .then(response => {
                setStatuts(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }, []);

    useEffect(() => {
        axios.get('https://banquedeprojet.minddevelonline.cm/api/maturite')
            .then(response => {
                setMaturites(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }, []);

    useEffect(() => {
        var projectData = JSON.parse(d.querySelector('.edit-project').getAttribute('data-project'));
        console.log(projectData);
        setProject(projectData);
        return () => {};
    }, []);

    useEffect(() => {
        axios.get('https://banquedeprojet.minddevelonline.cm/api/categories')
            .then(response => {
                setCategories(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }, []);

    const handleChangeCR = (e) => {
        // check if is checkbox input
        if(e.target.type === "checkbox") {
            const { value, checked, name } = e.target;
            console.log(value, checked, name);
            if (checked) {
                setProject((prevState) => ({
                    ...prevState,
                    [name]: [...prevState[name], +value],
                }));
            }
            else {
                setProject((prevState) => ({
                    ...prevState,
                    [e.target.name]: prevState[e.target.name].filter((elt) => elt !== +value),
                }));
            }
        } else {
            setProject((prevState) => ({
                ...prevState,
                [e.target.name]: +e.target.value
            }));
        }
    }

    const handleChange = (e) => {
        setProject((prevState) => ({...prevState, [e.target.id]: e.target.value}));
    }

    const handleChangeMaturite = (e) => {
        const [id, type] = e.target.value.split('-');
        axios.get(`https://banquedeprojet.minddevelonline.cm/api/maturite/${id}/elts`)
            .then(response => {
                setElements(response.data);
            })
            .catch(error => {
                console.log(error);
            });

        axios.get(`https://banquedeprojet.minddevelonline.cm/api/maturite/${id}/financements`)
            .then(response => {
                setFinancements(response.data);
            })
            .catch(error => {
                console.log(error);
            });
        setProject((prevState) => ({
            ...prevState,
            maturite: +id
        }));
        setType(type);
    }


    const edit = () => {
        axios.post('https://banquedeprojet.minddevelonline.cm/api/project/edit', project)
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
                    <h2 className="h4">Modification projet</h2>
                    <p className="mb-0">Suivez ces etapes.</p>
                </div>
            </div>
            <Stepper active={step} breakpoint="lg" onStepClick={setStep}>
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

            {step === 1 && (
                <form className="container">
                    <div className="d-block mt-4 mb-md-0">
                        <p className="mb-0">Présentation du projet.</p>
                        <div className="mb-4 mt-2">
                            <label className="my-1 me-2" htmlFor="institule">Intitulé</label>
                            <input type="text" className="form-control" id="institule" value={project.institule} onChange={handleChange}/>
                        </div>
                        <div className="mb-4 mt-2">
                            <label className="my-1 me-2" htmlFor="institule">Caracteristique de l'activité</label>
                            <textarea rows="4" className="form-control" id="caracteristique" value={project.caracteristique} onChange={handleChange}> </textarea>
                        </div>

                        <div className="mb-4 mt-2">
                            <label className="my-1 me-2" htmlFor="institule">Marchés cibles</label>
                            <input type="text" className="form-control" id="marche" value={project.marche} onChange={handleChange}/>
                        </div>

                        <div className="mb-4 mt-2">
                            <label className="my-1 me-2" htmlFor="supply">Supply Chain</label>
                            <textarea rows="4" className="form-control" id="supply" value={project.supply} onChange={handleChange}></textarea>
                        </div>

                        <div className="mb-4 mt-2">
                            <label className="my-1 me-2" htmlFor="atouts">Facteurs et atouts géographiques de production</label>
                            <input rows="4" className="form-control" id="atouts" value={project.atouts} onChange={handleChange}/>
                        </div>

                        <div className="mb-4 mt-2">
                            <label className="my-1 me-2" htmlFor="secteur">Secteur</label>
                            <select className="form-select" id="secteur" aria-label="" onChange={handleChange}>
                                <option selected="">Choisir une categorie</option>
                                {categories.map(category => (
                                    <option key={category.id} value={category.id} selected={project.secteur === category.id}>{category.nomCategorie}</option>
                                ))}
                            </select>
                        </div>
                        <div className="mb-4 mt-2">
                            <label className="my-1 me-2" htmlFor="objectifs">Objectis</label>
                            <textarea className="form-control" placeholder="Enter your objectifs..." id="objectifs" value={project.objectifs} onChange={handleChange}
                                      rows="4"></textarea>
                        </div>

                        <div className="mb-4 mt-2">
                            <label className="my-1 me-2" htmlFor="valeur_ajouter">Position sur le complexe des chaines de valeur ajoutée</label>
                            <textarea className="form-control"  rows="4" id="valeur_ajouter" value={project.valeur_ajouter} onChange={handleChange}></textarea>
                        </div>

                        <div className="mb-4 mt-2">
                            <label className="my-1 me-2" htmlFor="eligibilite">Eligibilité au bénéfice des appuis et
                                arrangement de l’environnement institutionnel</label>
                            <textarea className="form-control" placeholder="Entrer vos données..." id="eligibilite" value={project.eligibilite} onChange={handleChange}
                                      rows="4"></textarea>
                        </div>

                        <div className="mb-4 mt-2">
                            <label className="my-1 me-2" htmlFor="resultats">Resultats attendus</label>
                            <textarea className="form-control" placeholder="Enter your message..." id="resultats" value={project.resultats} onChange={handleChange}
                                      rows="4"></textarea>
                        </div>
                        <div className="mb-4 mt-2">
                            <label className="my-1 me-2" htmlFor="couts">Coût estimatif</label>
                            <input type="number" className="form-control" id="couts" value={project.couts} onChange={handleChange}/>
                        </div>
                    </div>
                </form>
            )}

            {step === 2 && (
                <form className="container">
                    <div className="d-block mt-4 mb-md-0">
                        <p className="mb-4">Autres informations.</p>
                        <div className="row container">
                            {maturites.map(maturite => (
                                <div className="form-check col-lg-4 col-sm-6" key={maturite.id}>
                                    <input className="form-check-input" type="radio" id={maturite.id} checked={project.maturite === maturite.id} value={`${maturite.id}-${maturite.type}`} name="maturite" onChange={handleChangeMaturite} />
                                    <label className="form-check-label" htmlFor={maturite.id}>
                                        {maturite.nomMaturite}
                                    </label>
                                </div>
                            ))}
                        </div>

                        {(type === 'mature' || type === 'encours') && <>
                            <p className="mb-4">Elémentts de maturité.</p>
                            <div className="row container">
                                {elements.map(elt => (
                                    <div className="form-check col-lg-4 col-sm-6" key={elt.id}>
                                        <input className="form-check-input" type="checkbox" id="eltsm" value={elt.id} name="eltsMaturite" onChange={handleChangeCR} />
                                        <label className="form-check-label" htmlFor={elt.id}>
                                            {elt.nom}
                                        </label>
                                    </div>
                                ))}
                            </div>
                            <div className="row container">
                                {statuts.map(statut => (
                                    <div className="form-check col-lg-4 col-sm-6" key={statut.id}>
                                        <input className="form-check-input" type="radio" id={statut.id} value={statut.id} name="status" onChange={handleChangeCR} />
                                        <label className="form-check-label" htmlFor={statut.id}>
                                            {statut.nom}
                                        </label>
                                    </div>
                                ))}
                            </div>
                            <p className="mb-4">Financement.</p>
                            <div className="row container">
                                {financements.map(financement => (
                                    <div className="form-check col-lg-4 col-sm-6" key={financement.id}>
                                        <input className="form-check-input" type="checkbox" id={financement.id} value={financement.id} name="financements" onChange={handleChangeCR} />
                                        <label className="form-check-label" htmlFor={financement.id}>
                                            {financement.nomFinancement}
                                        </label>
                                    </div>
                                ))}
                            </div>
                        </>}

                        {(type === 'idee') && <>
                            <p className="mb-4">Financement.</p>
                            <div className="row container">
                                {financements.map(financement => (
                                    <div className="form-check col-lg-4 col-sm-6" key={financement.id}>
                                        <input className="form-check-input" type="checkbox" id={financement.id} value={financement.id} name="financements" onChange={handleChangeCR} />
                                        <label className="form-check-label" htmlFor={financement.id}>
                                            {financement.nomFinancement}
                                        </label>
                                    </div>
                                ))}
                            </div>
                        </>}

                    </div>
                </form>
            )}

            <div className="d-flex justify-content-center">
                <div className="btn-group" role="group" aria-label="Basic outlined example">
                    <button type="button" className="btn btn-outline-primary" onClick={() => setStep((step) => step === 1 ? step : step - 1)}>Prev</button>
                    {step !== 2 && <button type="button" className="btn btn-outline-primary" onClick={() => setStep((step) => step === 2 ? step : step + 1)}>Next</button>}
                    {step === 2 && <button type="button" className="btn btn-outline-secondary" onClick={() => edit()}>Save</button>}
                </div>
            </div>

        </>
    );
};

export default EditProject;