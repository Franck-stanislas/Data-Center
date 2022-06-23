import React, {useEffect, useRef, useState} from 'react';
import {MapContainer, Marker, Popup, TileLayer} from "react-leaflet";
import './style.css';
import axios from "axios";


const Carte = () => {

    const [regions, setRegions] = useState([]);
    const [mapRegions, setMapRegions] = useState([]);

    const delay = (s) => {
        return new Promise((resolve) => setTimeout(resolve, s*1000));
    }

    useEffect(() => {
        axios.get('https://127.0.0.1:8000/api/projects/by-region')
            .then(async response => {
                if (response.data) {
                    setRegions(response.data);
                    console.log()
                }
            });
        return () => {};
    }, []);


    return (

        <MapContainer center={[7.369722, 12.354722]} zoom={6.5} scrollWheelZoom={false} style={{height: '100vh'}}>
            <TileLayer
                attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            />
            {regions && Object.values(regions).filter(region => region.lat).map((region, index) => (
                <Marker position={[region.lat, region.lon]}>
                    <Popup>
                        Region : {region.region} <br /> Nombre de projet : {region.count}.
                    </Popup>
                </Marker>
            ))}
        </MapContainer>
    );
};

export default Carte;