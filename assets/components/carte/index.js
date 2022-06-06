import React, {useEffect, useRef} from 'react';
import MyMarker from "./Marker";
import GoogleMapReact from "google-map-react";
import './style.css';
import * as tt from '@tomtom-international/web-sdk-maps';
import '@tomtom-international/web-sdk-maps/dist/maps.css'


const points = [
    {id: 1, title: "Round Pond", lat: 51.506, lng: -0.184},
    {id: 2, title: "The Long Water", lat: 51.508, lng: -0.175},
    {id: 3, title: "The Serpentine", lat: 51.505, lng: -0.164}
];


const Carte = () => {

    const mapElement = useRef();

    const addMarker = (map) => {
        const markers = new tt.Marker({
            draggable: false,
        }).setLngLat(new tt.LngLat(51.506, -0.184))
            .addTo(map);
        const popup = new tt.Popup({anchor: 'top'}).setText('Hello');

        return markers.setPopup(popup);
    }

    useEffect(() => {
        let map = tt.map({
            key: 'iBeHAVJ2tUmA68XGMQZAGQGkbH1YXKQN',
            container: mapElement.current,
            center: [-121.91599, 37.36765],
            zoom: 5,
        });
        var popupOffsets = {
            top: [0, 0],
            bottom: [0, -70],
            'bottom-right': [0, -70],
            'bottom-left': [0, -70],
            left: [25, -35],
            right: [-25, -35]
        }

        var element = document.createElement('div');
        element.id = 'marker';
        element.innerHTML = '1';
        var marker = new tt.Marker({
            element: element,
        })
            .setLngLat([-121.91599, 37.36765])
            .addTo(map);
        //var popup = new tt.Popup({offset: popupOffsets}).setHTML("your company name, your company address");
        //marker.setPopup(popup).togglePopup();
        //addMarker(map);
        return () => map.remove();
    }, []);

    return (
        <div ref={mapElement} className="mapDiv"/>
    );
};

export default Carte;