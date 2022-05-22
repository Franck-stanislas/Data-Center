import React from 'react';

const ProjectInfo = () => {
    return (
        <form className="conatainer">
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
        </form>
    );
};

export default ProjectInfo;