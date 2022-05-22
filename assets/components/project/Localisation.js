import React, {useEffect, useState} from 'react';
import axios from "axios";

const Localisation = () => {

    const [regions, setRegions] = useState([]);

    useEffect(() => {
        axios.get('https://127.0.0.1:8000/api/regions')
        .then(response => {
            setRegions(response.data);
        })
        .catch(error => {
            console.log(error);
        });
    }, []);

    return (
        <form className="container">
            {JSON.stringify(regions)}
            <div className="d-block mt-4 mb-md-0">
                <p className="mb-0">Origine du projet.</p>

                <div className="mb-4 mt-2">
                    <label className="my-1 me-2" htmlFor="country">Region</label>
                    <select className="form-select" id="country" aria-label="Default select example">
                        <option selected="">Open this select menu</option>
                        {regions.map(region => (
                            <option key={region.id} value={region.id}>{region.nom}</option>
                        ))}
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
        </form>
    );
};

export default Localisation;