import React, {useEffect, useState} from 'react';
import axios from "axios";

const ProjectInfo = () => {

    const [project, setProject] = useState({
        institule: '',
        secteur: '',
        couts: 0,
        resultats: '',
        objectifs: '',


    });
    const [categories, setCategories] = useState([]);

    const handleChange = (e) => {
        setProject((prevState) => ({...prevState, [e.target.id]: e.target.value}));
    }

    useEffect(() => {
        axios.get('https://127.0.0.1:8000/api/categories')
            .then(response => {
                setCategories(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }, []);

    return (
        <form className="conatainer">
            <div className="d-block mt-4 mb-md-0">
                <p className="mb-0">Présentation du projet.</p>
                <div className="mb-4 mt-2">
                    <label className="my-1 me-2" htmlFor="institule">Intitulé</label>
                    <input type="text" className="form-control" id="institule" value={project.institule} onChange={handleChange}/>
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