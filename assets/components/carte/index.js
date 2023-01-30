import React, {useEffect, useRef, useState} from 'react';
import {MapContainer, Marker, Popup, TileLayer, Tooltip} from "react-leaflet";
import './style.css';
import axios from "axios";
import MarkerClusterGroup from "react-leaflet-markercluster";
import {BASE_URL} from "../../constants";

const Carte = () => {

    const [regions, setRegions] = useState([]);
    const [communes, setCommunes] = useState([]);
    const [mapRegions, setMapRegions] = useState([]);
    const [commune, setProjets] = useState([]);


    const delay = (s) => {
        return new Promise((resolve) => setTimeout(resolve, s*1000));
    }

    useEffect(() => {
            axios.get(BASE_URL+'/api/projects/by-region')
            .then(async response => {
                if (response.data) {
                    setRegions(response.data);
                    console.log()
                }
            });
        return () => {};
    }, []);

    useEffect(() => {
            axios.get(BASE_URL+'/api/projects/by-commune')
            .then(async response => {
                if (response.data) {
                    setCommunes(response.data);
                    console.log()
                }
            });
        return () => {};
    }, []);

    // useEffect(() => {
    //     axios.get('https://127.0.0.1:8000/api/projects/by-maturite')
    //         .then(async response => {
    //             if (response.data) {
    //                 setProjets(response.data);
    //                 console.log()
    //             }
    //         });
    //     return () => {};
    // }, []);


    return (

        <MapContainer  className="markercluster-map" center={[7.369722, 12.354722]} zoom={6.48 } scrollWheelZoom={false} style={{height: '100vh'}}>
            <TileLayer
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                attribution='&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            />
            <MarkerClusterGroup>
                {communes && Object.values(communes).filter(commune => commune.lat).map((commune, index) => (
                    <Marker position={[commune.lat, commune.lon]} >

                        <Popup maxWidth={594} maxHeight={385} minWidth={0} closeButton={true}>
                           <div>
                               <h5 className="text-center"> {commune.institule}</h5>
                               <p className="text-center">{commune.objectifs}</p>
                               <br/>
                               <span> <b> Ville:</b> {commune.ville}</span><br/>
                               <span> <b> Secteur:  </b>{commune.secteur}</span><br/>
                               <span> <b>Maturité:</b> {commune.maturite}</span><br/>
                               <span>
                                    <b> <i className="lni lni-invest-monitor"></i>  Couts: </b> {commune.couts} FCFA
                               </span>
                           </div>
                            <div className="text-center">
                                <a href={"/projet/"+commune.id+"/details"} type="button"
                                className="btn btn-primary" tabIndex="0">View project profile</a>
                            </div>
                        </Popup>
                    </Marker>
                ))}

                {regions && Object.values(regions).filter(region => region.lat).map((region, index) => (
                    <Marker position={[region.lat, region.lon]} >

                        <Popup maxWidth={594} maxHeight={385} minWidth={0} closeButton={true}>
                           <div>
                               <h5 className="text-center"> {region.institule}</h5>
                               <p className="text-center">{region.objectifs}</p>
                               <br/>
                               <span> <b> Type de projet:</b> Conseil régional</span><br/>
                               <span> <b> Ville:</b> {region.ville}</span><br/>
                               <span> <b> Secteur:  </b>{region.secteur}</span><br/>
                               <span> <b>Maturité:</b> {region.maturite}</span><br/>
                               <span>
                                    <b> <i className="lni lni-invest-monitor"></i>  Couts: </b> {region.couts} FCFA
                               </span>
                           </div>
                            <div className="text-center">
                                <a href={"/projet/"+region.id+"/details"} type="button"
                                   className="btn btn-primary" tabIndex="0">View project profile</a>
                            </div>
                        </Popup>
                    </Marker>
                ))}
            </MarkerClusterGroup>

        </MapContainer>
    );
};

export default Carte;