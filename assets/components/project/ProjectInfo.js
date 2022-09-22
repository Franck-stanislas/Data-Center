import React, {useEffect, useState} from 'react';
import axios from "axios";

const ProjectInfo = (props) => {

    const [project, setProject] = useState({
        institule: '',
        secteur: '',
        couts: 0,
        resultats: '',
        objectifs: '',
        caracteristique: '',
        marche: '',
        supply: '',
        atouts: '',
        valeur_ajouter: '',
        eligibilite: ''
    });
    const [categories, setCategories] = useState([]);

    const handleChange = (e) => {
        setProject((prevState) => ({...prevState, [e.target.id]: e.target.value}), );
    }

    useEffect(() => {
        props.setProject((prevProject) => ({...prevProject, ...project, secteur: +project.secteur, couts: +project.couts}));
    }, [project])

    useEffect(() => {
        axios.get('https://banquedeprojet.minddevelonline.cm/api/categories')
            .then(response => {
                setCategories(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }, []);

    return (
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
                            <option key={category.id} value={category.id}>{category.nomCategorie}</option>
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
    );
};

export default ProjectInfo;