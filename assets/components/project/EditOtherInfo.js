import React, {useEffect, useState} from 'react';
import axios from "axios";

const EditOtherInfo = ({project, ...props}) => {

    const [statuts, setStatuts] = useState([]);
    const [maturites, setMaturites] = useState([]);
    const [elements, setElements] = useState([]);
    const [financements, setFinancements] = useState([]);
    const [type, setType] = useState("");


    const handleChangeCR = (e) => {
        // check if is checkbox input
        if(e.target.type === "checkbox") {
            const { value, checked } = e.target;
            if (checked) {
                props.setProject((prevState) => ({
                    ...prevState,
                    [e.target.name]: [...prevState[e.target.name], +value],
                }));
            }
            else {
                props.setProject((prevState) => ({
                    ...prevState,
                    [e.target.name]: prevState[e.target.name].filter((elt) => elt !== +value),
                }));
            }
        } else {
            props.setProject((prevState) => ({
                ...prevState,
                [e.target.name]: +e.target.value
            }));
        }
    }

    const handleChangeMaturite = (e) => {
        const [id, type] = e.target.value.split('-');
        axios.get(`https://127.0.0.1:8000/api/maturite/${id}/elts`)
            .then(response => {
                setElements(response.data);
            })
            .catch(error => {
                console.log(error);
            });

        axios.get(`https://127.0.0.1:8000/api/maturite/${id}/financements`)
            .then(response => {
                setFinancements(response.data);
            })
            .catch(error => {
                console.log(error);
            });
        props.setProject((prevState) => ({
            ...prevState,
            maturite: +id
        }));
        setType(type);
    }

    useEffect(() => {
        props.setProject((prevProject) => ({...prevProject, ...infos}));
    }, [infos])

    useEffect(() => {
        axios.get('https://127.0.0.1:8000/api/status')
            .then(response => {
                setStatuts(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }, []);

    useEffect(() => {
        axios.get('https://127.0.0.1:8000/api/maturite')
            .then(response => {
                setMaturites(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }, []);


    return (
        <form className="container">
            <div className="d-block mt-4 mb-md-0">
                <p className="mb-4">Autres informations.</p>
                <div className="row container">
                    {maturites.map(maturite => (
                        <div className="form-check col-lg-4 col-sm-6" key={maturite.id}>
                            <input className="form-check-input" type="radio" id={maturite.id} value={`${maturite.id}-${maturite.type}`} name="maturite" onChange={handleChangeMaturite} />
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
                                <input className="form-check-input" type="checkbox" id={elt.id} value={elt.id} name="eltsMaturite" onChange={handleChangeCR} />
                                <label className="form-check-label" htmlFor={elt.id}>
                                    {elt.nom}
                                </label>
                            </div>
                        ))}
                    </div>
                    <p className="mb-4">Status.</p>
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
    );
};

export default EditOtherInfo;