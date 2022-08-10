import React, {useEffect, useState} from 'react';
import axios from "axios";

const Localisation = ({setProject}) => {

    const [regions, setRegions] = useState([]);
    const [departements, setDepartements] = useState([]);
    // const [communes, setCommunes] = useState([]);
    const [arrondissements, setArrondissements] = useState([]);

    useEffect(() => {
        axios.get('https://banquedeprojet.minddevelonline.cm/api/regions')
            .then(response => {
                setRegions(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }, []);

    const handleRegionChange = (event) => {
        const value = event.target.value;
        axios.get(`https://banquedeprojet.minddevelonline.cm/api/regions/${value}/departements`)
            .then(response => {
                setDepartements(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }

    const handleDepartementChange = (event) => {
        const value = event.target.value;
        axios.get(`https://banquedeprojet.minddevelonline.cm/api/departements/${value}/arrondissements`)
            .then(response => {
                setArrondissements(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }

    const handleArrondissementChange = (event) => {
        const value = event.target.value;
        setProject((project) => ({...project, arrondissement: +value}));
    }

    // const handleCommuneChange = (event) => {
    //     const value = event.target.value;
    //     setProject((project) => ({...project, commune: +value}));
    // }


    return (<form className="container">
        <div className="d-block mt-4 mb-md-0">
            <p className="mb-0">Origine du projet.</p>

            <div className="mb-4 mt-2">
                <label className="my-1 me-2" htmlFor="country">Region</label>
                <select className="form-select" id="country" aria-label="Default select example"
                        onChange={handleRegionChange}>
                    <option selected="">Veuillez choisir une region</option>
                    {regions.map(region => (<option key={region.id} value={region.id}>{region.nom}</option>))}
                </select>
            </div>
            <div className="mb-4 mt-2">
                <label className="my-1 me-2" htmlFor="country">Département</label>
                <select className="form-select" id="country" aria-label="Default select example"
                        onChange={handleDepartementChange}>
                    <option selected=""> Choisir un département</option>
                    {departements.map(departement => (
                        <option key={departement.id} value={departement.id}>{departement.nom}</option>))}
                </select>
            </div>
            <div className="mb-4 mt-2">
                <label className="my-1 me-2" htmlFor="country">Arrondissement</label>
                <select className="form-select" id="country" aria-label="Default select example"
                        onChange={handleArrondissementChange}>
                    <option selected="">Choisir un arrondissement</option>
                    {arrondissements.map(arrondissement => (
                        <option key={arrondissement.id} value={arrondissement.id}>{arrondissement.nom}</option>))}
                </select>
            </div>

            {/*<div className="mb-4 mt-2">*/}
            {/*    <label className="my-1 me-2" htmlFor="country">Commune</label>*/}
            {/*    <select className="form-select" id="country" aria-label="Default select example" onChange={handleCommuneChange}>*/}
            {/*        <option selected="">Choisir une commune</option>*/}
            {/*        {communes.map(commune => (*/}
            {/*            <option key={commune.id} value={commune.id}>{commune.libelle}</option>))}*/}
            {/*    </select>*/}
            {/*</div>*/}
        </div>
    </form>);
};

export default Localisation;