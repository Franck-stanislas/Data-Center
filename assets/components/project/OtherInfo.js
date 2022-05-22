import React from 'react';

const OtherInfo = () => {
    return (
        <form className="container">
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
        </form>
    );
};

export default OtherInfo;