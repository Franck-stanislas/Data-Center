import React, {useCallback, useEffect, useState} from 'react';
import axios from "axios";
import debounce from "lodash.debounce";
import jsPDF from "jspdf";
import "jspdf-autotable";
import { useTranslation } from 'react-i18next';


const CommuneProjectList = () => {
    const [projets, setProjets] = useState(null);
    const [maturites, setMaturites] = useState(null);
    const [categories, setCategories] = useState(null);
    const [totalCount, setTotalCount] = useState(0);
    const [totalPages, setTotalPages] = useState(0);
    const [numItemsPerPage, setNumItemsPerPage] = useState(0);
    const [currentPage, setCurrentPage] = useState(0);
    const [activesMaturites, setActivesMaturites] = useState([]);
    const [activesCategories, setActivesCategories] = useState([]);
    const [nbItemPagination, setNbItemPagination] = useState(2);
    const [isFirstLoad, setIsFirstLoad] = useState(true);
    const [searchInput, setSearchInput] = useState("");
    const [search, setSearch] = useState("");
    const [regions, setRegions] = useState([]);
    const [departements, setDepartements] = useState([]);
    const [arrondissements, setArrondissements] = useState([]);
    const [region, setRegion] = useState("");
    const [departement, setDepartement] = useState("");
    const [arrondissement, setArrondissement] = useState("");

    const { t, i18n } = useTranslation();
    const changeLanguage = lng => {
        i18n.changeLanguage(lng);
    };

    useEffect(() => {
        axios.get('https://banquedeprojet.minddevelonline.cm/api/projects/get-allByArron')
            .then(response => {
                setProjets(response.data.projets);
                setMaturites(response.data.maturites);
                setCategories(response.data.categories);
                setTotalCount(response.data.totalCount);
                setTotalPages(response.data.totalPages);
                setCurrentPage(response.data.currentPage);
                setNumItemsPerPage(response.data.numItemsPerPage);
                setIsFirstLoad(false);
            })
            .catch(error => {
                console.log(error);
            });
        axios.get('https://banquedeprojet.minddevelonline.cm/api/regions')
            .then(response => {
                setRegions(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }, []);

    useEffect(() => {
        setSearchValue(searchInput);
        return () => {};
    }, [searchInput]);

    const handleRegionChange = (event) => {
        const value = event.target.value;
        setRegion(value);
        setArrondissement(null)
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
        setDepartement(value);
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
        setArrondissement(value);
    }


    const handleChangeActiveMaturites = (idMaturite) => {
        setActivesMaturites((prevState) => {
            if (prevState.includes(idMaturite)) {
                return prevState.filter(id => id !== idMaturite)
            } else {
                return [...prevState, idMaturite]
            }
        })
    }

    const handleChangeActivesCategories = (idCategory) => {
        setActivesCategories((prevState) => {
            if (prevState.includes(idCategory)) {
                return prevState.filter(id => id !== idCategory)
            } else {
                return [...prevState, idCategory]
            }
        })
    }

    const setSearchValue = useCallback(debounce(async (searchInput) => {
            setSearch(searchInput);
        }, 500),
        [],
    );

    useEffect(() => {
        if (!isFirstLoad) {
            axios.post('https://banquedeprojet.minddevelonline.cm/api/projects/filters', {
                page: currentPage,
                activesMaturites,
                activesCategories,
                search,
                region, departement, arrondissement
            })
                .then(response => {
                    setProjets(response.data.projets);
                    setTotalPages(response.data.totalPages);
                    setCategories(response.data.categories);
                    setMaturites(response.data.maturites);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }, [currentPage, activesMaturites, activesCategories, search, region, departement, arrondissement])

    const imprimerProjet = () => {
        axios.post('https://banquedeprojet.minddevelonline.cm/api/projects/print-projects', {
            activesMaturites,
            activesCategories,
            search,
            region, departement, arrondissement
        })
            .then(response => {
                const projets = response.data;
                if (projets) {
                    const projectsToPrint = projets.map((project, index) => ({
                        'id' : index+1,
                        'nom': project.institule,
                        'secteur': project.secteur.nomCategorie,
                        'arrondissement': project.arrondissement.ville,
                        'couts': project.couts,
                        'maturite': project.maturite.nom_maturite,
                    }));
                    console.log({projectsToPrint});
                    const unit = "pt";
                    const size = "A4"; // Use A1, A2, A3 or A4
                    const orientation = "portrait"; // portrait or landscape

                    const marginLeft = 40;
                    const doc = new jsPDF(orientation, unit, size);

                    doc.setFontSize(15);

                    const title = "Liste des projets";
                    const headers = [["ID","NOM", "SECTEUR", "ARRONDISSEMENT", "COUTS", "MATURITE"]];

                    const data = projectsToPrint.map(elt=> [elt.id, elt.nom, elt.secteur, elt.arrondissement, elt.couts, elt.maturite]);

                    let content = {
                        startY: 50,
                        head: headers,
                        body: data
                    };

                    doc.text(title, marginLeft, 40);
                    doc.autoTable(content);
                    doc.save("listeProjets.pdf")
                }
            })
            .catch(error => {
                console.log(error);
            });
    }

    return (
        <>
            <div className="breadcrumbs">
                <div className="container">
                    <div className="row align-items-center">
                        <div className="col-lg-6 col-md-6 col-12">
                            <div className="breadcrumbs-content">
                                <h1 className="page-title">{t('Projets')}</h1>
                            </div>
                        </div>
                        <div className="col-lg-6 col-md-6 col-12">
                            <ul className="breadcrumb-nav">
                                <li><a href="/">{t('Accueil')}</a></li>
                                <li>{t('Liste des projets')}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {/*<header className="App-header">*/}
            {/*    <button className="btn" onClick={() => changeLanguage('en')}>english</button>*/}
            {/*    <button className="btn" onClick={() => changeLanguage('fr')}>french</button>*/}
            {/*</header>*/}

            <section className="category-page section">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-3 col-md-4 col-12">
                            <div className="category-sidebar">
                                <div className="single-widget search">
                                    <h3>{t('Rechercher')}</h3>
                                    <form action="#">
                                        <input type="text" placeholder="Rechercher Ici..." value={searchInput} onChange={(e) => setSearchInput(e.target.value)} />
                                        <button type="submit"><i className="lni lni-search-alt"/></button>
                                    </form>
                                </div>

                                <div className="single-widget">
                                    <h3>{t('Localisation')}</h3>
                                    <form>
                                        <ul className="list" id="cat-filter">
                                            <div className="form-group mb-2">
                                                <label htmlFor="region">{t('Region')}</label>
                                                <select name="region" id="region" className="form-control" value={region} onChange={handleRegionChange}>
                                                    <option selected="">{t('Veuillez choisir une region')}</option>
                                                    {regions.map(region => (<option key={region.id} value={region.id}>{region.nom}</option>))}
                                                </select>
                                            </div>
                                            <div className="form-group mb-2">
                                                <label htmlFor="departement">{t('Département')}</label>
                                                <select name="departement" id="departement" className="form-control" value={departement} onChange={handleDepartementChange}>
                                                    <option selected="">{t('Choisir un département')} </option>
                                                    {departements.map(departement => (
                                                        <option key={departement.id} value={departement.id}>{departement.nom}</option>))}
                                                </select>
                                            </div>
                                            <div className="form-group">
                                                <label htmlFor="arrondissement">{t('Arrondissement')}</label>
                                                <select name="arrondissement" id="arrondissement" className="form-control" value={arrondissement} onChange={handleArrondissementChange}>
                                                    <option selected="">{t('Choisir un arrondissement')}</option>
                                                    {arrondissements.map(arrondissement => (
                                                        <option key={arrondissement.id} value={arrondissement.id}>{arrondissement.nom}</option>))}
                                                </select>
                                            </div>
                                        </ul>
                                    </form>
                                </div>

                                <div className="single-widget">
                                    <h3>{t('Tous les secteurs')}</h3>
                                    <ul className="list" id="cat-filter">
                                        {categories && categories.map((category) => (
                                            <li key={category.id} onClick={() => handleChangeActivesCategories(category.id)}>
                                                <a href="#" onClick={(e) => e.preventDefault()} style={{color: activesCategories.includes(category.id) ? "#f5821e" : "inherit"}}>{category.nom_categorie}<span>{category.projetCount}</span></a>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div className="col-lg-9 col-md-4 col-12">
                            <div className="category-grid-list">
                                <div className="row">
                                    <div className="col-12">
                                        <div className="category-grid-topbar">
                                            <div className="row align-items-center">
                                                <div className="col-lg-6 col-md-6 col-12">
                                                    <h3 className="title">{t('Affiché')}
                                                        1-{projets?.length} {t('sur')} {totalCount}{t('projets trouvés')} </h3>
                                                </div>
                                                <div className="col-lg-6 col-md-6 col-12">
                                                    <nav>
                                                        <div className="nav nav-tabs" id="nav-tab" role="tablist">
                                                            <button className="nav-link active" id="nav-grid-tab"
                                                                    data-bs-toggle="tab" data-bs-target="#nav-grid"
                                                                    type="button" role="tab" aria-controls="nav-grid"
                                                                    aria-selected="true"><i
                                                                className="lni lni-grid-alt"></i></button>
                                                        </div>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="tab-content" id="nav-tabContent">
                                            <div className="tab-pane fade show active" id="nav-grid" role="tabpanel"
                                                 aria-labelledby="nav-grid-tab">
                                                <div className="row">
                                                    {projets && projets.map((projet) => (
                                                        <div className="col-lg-6 col-md-6 col-12" key={projet.id}>
                                                            <div className="single-item-grid">
                                                                <div className="content">
                                                                    <a href={"/category/"+projet.secteur.id+"/projets"} className="tag">
                                                                        {projet.secteur.nomCategorie}
                                                                    </a>
                                                                    <h3 className="title">
                                                                        <a href={"/projet/"+projet.id+"/details"}>{projet.institule}</a>
                                                                    </h3>
                                                                    <p className="location">
                                                                        <a href="javascript:void(0)">
                                                                            <i className="lni lni-map-marker"></i>
                                                                            {projet.arrondissement.ville}
                                                                        </a>
                                                                    </p>
                                                                    <p className="location">
                                                                        <a href="javascript:void(0)">
                                                                            <i class="lni lni-map-marker"></i>
                                                                            Region :  CMR
                                                                        </a>
                                                                    </p>
                                                                    <ul className="info">
                                                                        <span>{t('Estimation du cout')}</span><br/>
                                                                        <li className="price">{projet.couts} FCFA</li>
                                                                    </ul>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    ))}

                                                    {!projets && <span
                                                        className="text-danger text-center">{t('Aucun projet disponible pour le moment')}</span>}
                                                </div>
                                                <div className="row">
                                                    <div className="col-6">
                                                        <div className="pagination left">
                                                            <ul className="pagination-list">
                                                                <li onClick={() => currentPage > 1 && setCurrentPage((prevState) => prevState - 1)}>
                                                                    <a href="javascript:void(0)"><i
                                                                        className="lni lni-chevron-left"></i></a></li>
                                                                {[...Array(totalPages).keys()].slice(currentPage - 1, nbItemPagination + currentPage).map((i) => (
                                                                    <li key={i}
                                                                        className={currentPage - 1 === i ? "active" : ""}>
                                                                        <a href="javascript:void(0)"
                                                                           onClick={() => setCurrentPage(i + 1)}>{i + 1}</a>
                                                                    </li>
                                                                ))}
                                                                <li onClick={() => currentPage < totalPages && setCurrentPage((prevState) => prevState + 1)}>
                                                                    <a href="javascript:void(0)"><i
                                                                        className="lni lni-chevron-right"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                    </div>
                                                    <div className="col-6">
                                                        <div className="pagination right">
                                                            <button className="btn btn-outline-primary" onClick={() => imprimerProjet()}>
                                                                <i className="lni lni-download"></i>{t('Télécharger')}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
};

export default CommuneProjectList;