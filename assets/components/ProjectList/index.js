import React, {useEffect, useState} from 'react';
import axios from "axios";

const ProjectList = () => {
    const [projets, setProjets] = useState(null);
    const [maturites, setMaturites] = useState(null);
    const [categories, setCategories] = useState(null);
    const [totalCount, setTotalCount] = useState(0);
    const [totalPages, setTotalPages] = useState(0);
    const [numItemsPerPage, setNumItemsPerPage] = useState(0);
    const [currentPage, setCurrentPage] = useState(0);
    const [activesMaturites, setActivesMaturites] = useState([]);
    const [nbItemPagination, setNbItemPagination] = useState(2);

    useEffect(() => {
        axios.get('https://127.0.0.1:8000/api/projects/get-all')
            .then(response => {
                setProjets(response.data.products);
                setMaturites(response.data.maturites);
                setCategories(response.data.categories);
                setTotalCount(response.data.totalCount);
                setTotalPages(response.data.totalPages);
                setCurrentPage(response.data.currentPage);
                setNumItemsPerPage(response.data.numItemsPerPage);
                console.log(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }, []);

    useEffect(() => {
        axios.post('https://127.0.0.1:8000/api/projects/get-all', {
            page: currentPage,
            maturites,
        })
            .then(response => {
                setProjets(response.data.products);
                setTotalPages(response.data.totalPages);
            })
            .catch(err => {
                console.log(err);
            });
    }, [currentPage, maturites])

    return (
        <>
            <div className="breadcrumbs">
                <div className="container">
                    <div className="row align-items-center">
                        <div className="col-lg-6 col-md-6 col-12">
                            <div className="breadcrumbs-content">
                                <h1 className="page-title">Projets</h1>
                            </div>
                        </div>
                        <div className="col-lg-6 col-md-6 col-12">
                            <ul className="breadcrumb-nav">
                                <li><a href="/">Home</a></li>
                                <li>Liste des projets</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <section className="category-page section">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-3 col-md-4 col-12">
                            <div className="category-sidebar">
                                <div className="single-widget search">
                                    <h3>Rechercher</h3>
                                    <form action="#">
                                        <input type="text" placeholder="Rechercher Ici..."/>
                                        <button type="submit"><i className="lni lni-search-alt"/></button>
                                    </form>
                                </div>

                                <div className="single-widget">
                                    <h3>Toutes les categories</h3>
                                    <ul className="list" id="cat-filter">
                                        {categories && categories.map((category) => (
                                            <li key={category.id}>
                                                <a href="javascript:void(0)">{category.nom_categorie}<span>{category.projetCount}</span></a>
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
                                        <div className="category-grid-topbar mb-4">
                                            <span className="ml-4 mt-3 fw-bold">Maturité du projet</span>
                                                <nav className="list-nav1">
                                                    <ul>
                                                        {maturites && maturites.map((maturite) => (
                                                            <li
                                                                className={activesMaturites.includes(maturite.id) ? "active m-3" : "m-3"}
                                                                key={maturite.id}
                                                                onClick={() => setActivesMaturites((prevState) => {
                                                                if (prevState.includes(maturite.id)) {
                                                                    return prevState.filter(id => id !== maturite.id)
                                                                } else {
                                                                    return [...prevState, maturite.id]
                                                                }
                                                            })}>
                                                                <a href="javascript:void(0)" key={maturite.id}>{maturite.nom_maturite}<span>{maturite.projetCount}</span></a>
                                                            </li>
                                                        ))}
                                                    </ul>
                                                </nav>
                                        </div>

                                        <div className="category-grid-topbar">
                                            <div className="row align-items-center">
                                                <div className="col-lg-6 col-md-6 col-12">
                                                    <h3 className="title">Showing 1-{projets?.length} of {totalCount} projets found</h3>
                                                </div>
                                                <div className="col-lg-6 col-md-6 col-12">
                                                    <nav>
                                                        <div className="nav nav-tabs" id="nav-tab" role="tablist">
                                                            <button className="nav-link active" id="nav-grid-tab"
                                                                    data-bs-toggle="tab" data-bs-target="#nav-grid"
                                                                    type="button" role="tab" aria-controls="nav-grid"
                                                                    aria-selected="true"><i
                                                                className="lni lni-grid-alt"></i></button>
                                                            <button className="nav-link" id="nav-list-tab"
                                                                    data-bs-toggle="tab" data-bs-target="#nav-list"
                                                                    type="button" role="tab" aria-controls="nav-list"
                                                                    aria-selected="false"><i
                                                                className="lni lni-list"></i></button>
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
                                                                    <a href="javascript:void(0)" className="tag">
                                                                        {projet.secteur.nomCategorie}
                                                                    </a>
                                                                    <h3 className="title">
                                                                        <a href="/">{projet.institule}</a>
                                                                    </h3>
                                                                    <p className="location">
                                                                        <a href="javascript:void(0)">
                                                                            <i className="lni lni-map-marker"></i>
                                                                            {projet.arrondissement.ville}
                                                                        </a>
                                                                    </p>
                                                                    <ul className="info">
                                                                        <span>Estimation du cout</span><br/>
                                                                        <li className="price">{projet.couts} FCFA</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    ))}
                                                </div>
                                                <div className="row">
                                                    <div className="col-12">
                                                        <div className="pagination left">
                                                            <ul className="pagination-list">
                                                                <li onClick={() => setCurrentPage((prevState) => prevState > 0 && prevState-1)}><a href="javascript:void(0)"><i
                                                                    className="lni lni-chevron-left"></i></a></li>
                                                                {[...Array(totalPages).keys()].slice(currentPage-1, nbItemPagination+currentPage).map((i) => (
                                                                    <li key={i} className={currentPage-1 === i ? "active" : ""}>
                                                                        <a href="javascript:void(0)" onClick={() => setCurrentPage(i+1)}>{i+1}</a>
                                                                    </li>
                                                                ))}
                                                                {/*{totalPages > 1 && Array.from({length: totalPages}, (_, i) => (
                                                                    <li
                                                                        key={i}
                                                                        className={i + 1 === currentPage ?
                                                                            "active"
                                                                            : i + 1 > nbItemPagination ? "d-none" : ""}
                                                                    >
                                                                        <a href="javascript:void(0)">{i + 1}</a>
                                                                    </li>
                                                                ))}*/}
                                                                <li onClick={() => setCurrentPage((prevState) => prevState + 1 < totalPages && prevState+1)}><a href="javascript:void(0)"><i
                                                                    className="lni lni-chevron-right"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="tab-pane fade" id="nav-list" role="tabpanel"
                                                 aria-labelledby="nav-list-tab">
                                                <div className="row">

                                                    <div className="col-lg-12 col-md-12 col-12">
                                                        <div className="single-item-grid">
                                                            <div className="row align-items-center">
                                                                <div className="col-lg-12 col-md-5 col-12">
                                                                    <div className="content">
                                                                        <a href="javascript:void(0)" className="tag">categ proj aut</a>
                                                                        <div
                                                                            className="d-inline-flex justify-content-between">
                                                                            <h3 className="title me-5">
                                                                                <a href=" {{ path('app_project_detail', {'id':projet.id}) }} ">titre</a>
                                                                            </h3>
                                                                            <p className="location me-5">
                                                                                <a href="javascript:void(0)">
                                                                                    <i className="lni lni-map-marker"></i>
                                                                                    ville
                                                                                </a>
                                                                            </p>
                                                                            <ul className="info">
                                                                                <span>Estimation du cout</span>
                                                                                <li className="price">86 FCFA
                                                                                </li>
                                                                            </ul>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                <div className="row">
                                                    <div className="col-12">
                                                        <div className="pagination left">
                                                            <ul className="pagination-list">
                                                                pagination
                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <span
                                            className="text-danger text-center">Aucun projet disponible pour le moment</span>
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

export default ProjectList;